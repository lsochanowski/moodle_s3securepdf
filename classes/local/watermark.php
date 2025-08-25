<?php
namespace mod_s3securepdf\local;
defined('MOODLE_INTERNAL') || die();

// Load vendor libs for FPDI/FPDF (no AWS) if available.
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

use setasign\Fpdi\Fpdi;

class watermark {
  public static function build_text(string $tpl, array $ctx): string {
    $search = ['{{fullname}}','{{username}}','{{userid}}','{{timestamp}}','{{course}}','{{sessionhash}}'];
    $replace = [
      $ctx['fullname'] ?? '',
      $ctx['username'] ?? '',
      (string)($ctx['userid'] ?? ''),
      $ctx['timestamp'] ?? '',
      $ctx['course'] ?? '',
      $ctx['sessionhash'] ?? ''
    ];
    return str_replace($search, $replace, $tpl);
  }

  public static function apply(string $srcpath, string $dstpath, string $text): void {
    $angle = (int)(get_config('mod_s3securepdf','angle') ?? 45);
    $fontsize = (int)(get_config('mod_s3securepdf','fontsize') ?? 12);
    $opacity = (float)(get_config('mod_s3securepdf','opacity') ?? 0.25);
    $gray = max(0, min(255, (int)round(255 * (1 - $opacity))));

    $pdf = new Fpdi();
    $pagecount = $pdf->setSourceFile($srcpath);

    for ($i=1; $i<= $pagecount; $i++) {
      $tpl = $pdf->importPage($i);
      $size = $pdf->getTemplateSize($tpl);
      $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
      $pdf->AddPage($orientation, [$size['width'], $size['height']]);
      $pdf->useTemplate($tpl, 0, 0, $size['width'], $size['height'], true);

      $pdf->SetFont('Helvetica','', $fontsize);
      $pdf->SetTextColor($gray, $gray, $gray);

      $cx = $size['width']/2; $cy = $size['height']/2;
      if (method_exists($pdf, 'Rotate')) $pdf->Rotate($angle, $cx, $cy);
      $pdf->Text(10, $cy, $text);
      if (method_exists($pdf, 'Rotate')) $pdf->Rotate(0);
    }
    $pdf->Output('F', $dstpath);
  }
}
