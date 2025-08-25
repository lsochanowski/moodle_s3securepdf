<?php
$string['pluginname'] = 'S3 Secure PDF';
$string['modulename'] = 'S3 Secure PDF';
$string['modulenameplural'] = 'S3 Secure PDF';
$string['privacy:metadata'] = 'Wtyczka S3 Secure PDF przechowuje minimalne dane osobowe do watermarku.';

$string['name'] = 'Nazwa';
$string['intro'] = 'Opis';
$string['objectkey'] = 'Klucz obiektu (S3)';
$string['objectkey_help'] = 'Ścieżka/klucz PDF w skonfigurowanym buckecie (np. documents/manuals/intro.pdf).';
$string['watermarktpl'] = 'Szablon watermarku';
$string['download'] = 'Pobierz PDF';
$string['invalidtoken'] = 'Nieprawidłowy lub przeterminowany token pobrania.';

$string['setting:endpoint'] = 'S3 Endpoint';
$string['setting:region'] = 'S3 Region';
$string['setting:bucket'] = 'S3 Bucket';
$string['setting:prefix'] = 'Prefiks ścieżki';
$string['setting:accesskey'] = 'Access key';
$string['setting:secretkey'] = 'Secret key';
$string['setting:verifytls'] = 'Weryfikuj certyfikaty TLS';
$string['setting:cacheseconds'] = 'Cache TTL (sekundy)';
$string['setting:tokenseconds'] = 'Token TTL (sekundy)';
$string['setting:watermarktpl'] = 'Domyślny szablon watermarku';
$string['setting:fontsize'] = 'Rozmiar czcionki';
$string['setting:opacity'] = 'Krycie (0-1)';
$string['setting:angle'] = 'Kąt (stopnie)';
$string['setting:connecttimeout'] = 'Connect timeout (sekundy)';
$string['setting:requesttimeout'] = 'Request timeout (sekundy)';
$string['setting:debugs3'] = 'Debuguj żądania S3 do error_log';

$string['event:file_downloaded'] = 'Pobrano plik S3 Secure PDF';
$string['s3connecterror'] = 'Błąd połączenia z S3. Sprawdź endpoint/dane lub timeouty.';
