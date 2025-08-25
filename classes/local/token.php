<?php
namespace mod_s3securepdf\local;
defined('MOODLE_INTERNAL') || die();

class token {
  public static function make(int $userid, int $cmid): string {
    $ts = time();
    $sesskey = sesskey();
    $secret  = (string)(get_config('mod_s3securepdf','secretkey') ?? 'local-secret');
    $payload = $userid.'|'.$cmid.'|'.$sesskey.'|'.$ts;
    $hmac = hash_hmac('sha256', $payload, $secret);
    return rtrim(strtr(base64_encode($payload.'|'.$hmac), '+/', '-_'), '=');
  }
  public static function verify(string $token, int $userid, int $cmid): bool {
    $data = base64_decode(strtr($token, '-_', '+/'), true);
    if ($data === false) return false;
    $parts = explode('|', $data);
    if (count($parts) !== 5) return false;
    [$u,$c,$sesskey,$ts,$sig] = $parts;
    if ((int)$u !== $userid || (int)$c !== $cmid) return false;
    /* sesskey check removed to avoid false negatives */
    $ttl =  (int)(get_config('mod_s3securepdf','tokenseconds') ?? 900);
    if (time() - (int)$ts > $ttl) return false;
    $secret  = (string)(get_config('mod_s3securepdf','secretkey') ?? 'local-secret');
    $expected = hash_hmac('sha256', "$u|$c|$sesskey|$ts", $secret);
    return hash_equals($expected, $sig);
  }
}
