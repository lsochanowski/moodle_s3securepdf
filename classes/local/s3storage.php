<?php
namespace mod_s3securepdf\local;
defined('MOODLE_INTERNAL') || die();

// DO NOT load a second AWS SDK here to avoid conflicts with Moodle core.
// Only vendor/autoload is used by watermark.php for FPDI/FPDF.

use Aws\S3\S3Client;

class s3storage {
  private static ?S3Client $client = null;

  protected static function mkclient(): S3Client {
    if (self::$client) return self::$client;
    $endpoint = get_config('mod_s3securepdf','endpoint');
    $region   = get_config('mod_s3securepdf','region') ?: 'garage';
    $key      = get_config('mod_s3securepdf','accesskey');
    $secret   = get_config('mod_s3securepdf','secretkey');
    $verify   = (bool)get_config('mod_s3securepdf','verifytls');
    $connect  = (float)(get_config('mod_s3securepdf','connecttimeout') ?? 10);
    $request  = (float)(get_config('mod_s3securepdf','requesttimeout') ?? 30);
    $debugs3  = (int)(get_config('mod_s3securepdf','debugs3') ?? 0);

    self::$client = new S3Client([
      'version' => 'latest',
      'region' => $region,
      'endpoint' => $endpoint,
      'use_path_style_endpoint' => true,
      'credentials' => ['key'=>$key, 'secret'=>$secret],
      'http' => ['verify'=>$verify, 'connect_timeout'=>$connect, 'timeout'=>$request],
      'debug' => ($debugs3 ? true : false)
    ]);
    if ($debugs3) { error_log('[s3securepdf] S3 client timeouts connect='.(string)$connect.' request='.(string)$request.' region='.$region); }
    return self::$client;
  }

  public static function client(): S3Client { return self::mkclient(); }

  public static function download_to(string $bucket, string $key, string $destpath): void {
    $res = self::client()->getObject(['Bucket'=>$bucket, 'Key'=>$key]);
    $body = $res['Body'];
    $fp = fopen($destpath, 'wb');
    while (!$body->eof()) { fwrite($fp, $body->read(8192)); }
    fclose($fp);
  }
}
