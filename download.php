<?php
// Server-side S3 fetch + watermark delivery.
require(__DIR__.'/../../config.php');

$id = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('s3securepdf', $id, 0, false, MUST_EXIST);
$course = get_course($cm->course);
$context = context_module::instance($cm->id);

require_login($course, true, $cm);
require_capability('mod/s3securepdf:view', $context);

// Get instance and object key (adjust to your field name if different).
$instance = $DB->get_record('s3securepdf', ['id' => $cm->instance], '*', MUST_EXIST);
$key = null;
foreach (['s3object','objectkey','filename','object'] as $candidate) {
    if (!empty($instance->$candidate)) { $key = $instance->$candidate; break; }
}
if (empty($key)) {
    print_error('missingobject', 'mod_s3securepdf');
}

// Config
$conf = get_config('mod_s3securepdf');
if (empty($conf->s3_endpoint) || empty($conf->s3_bucket) || empty($conf->s3_accesskey) || empty($conf->s3_secretkey)) {
    print_error('s3notconfigured', 'mod_s3securepdf');
}

// Composer autoload (module/vendor or site/vendor)
$loaded = false;
foreach ([__DIR__.'/vendor/autoload.php', __DIR__.'/../../vendor/autoload.php', $CFG->dirroot.'/vendor/autoload.php'] as $path) {
    if (file_exists($path)) { require_once($path); $loaded = true; break; }
}

try {
    $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region'  => $conf->s3_region ?: 'us-east-1',
        'endpoint' => $conf->s3_endpoint,
        'use_path_style_endpoint' => true,
        'credentials' => [
            'key'    => $conf->s3_accesskey,
            'secret' => $conf->s3_secretkey,
        ],
    ]);
    $res = $s3->getObject([
        'Bucket' => $conf->s3_bucket,
        'Key'    => $key,
    ]);
    $pdfdata = (string)$res['Body'];
} catch (Throwable $e) {
    print_error('s3fetcherror', 'mod_s3securepdf', '', s($e->getMessage()));
}

// Temp files
$tmpdir = make_temp_directory('s3securepdf');
$tmpin  = $tmpdir.'/in_'.uniqid('', true).'.pdf';
$tmpout = $tmpdir.'/out_'.uniqid('', true).'.pdf';
file_put_contents($tmpin, $pdfdata);

// Watermark via FPDI if library is available, else passthrough original.
$watermarked = false;
try {
    if (class_exists('setasign\\Fpdi\\Fpdi')) {
        $pdf = new setasign\Fpdi\Fpdi();
        $pagecount = $pdf->setSourceFile($tmpin);
        for ($i = 1; $i <= $pagecount; $i++) {
            $tpl = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tpl);
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tpl);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetTextColor(150, 150, 150);
            $pdf->SetXY(10, 10);
            $label = fullname($USER).' | '.userdate(time());
            $pdf->Cell(0, 10, $label);
        }
        $pdf->Output($tmpout, 'F');
        $watermarked = true;
    }
} catch (Throwable $e) {
    // fallback below
}

if (!$watermarked) {
    // fallback to original if watermark libs not present
    $tmpout = $tmpin;
}

// Send
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="'.basename($key).'"');
header('Content-Length: '.filesize($tmpout));
readfile($tmpout);

// Cleanup
if ($tmpout != $tmpin) @unlink($tmpout);
@unlink($tmpin);
exit;
