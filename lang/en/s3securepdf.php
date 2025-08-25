<?php
$string['pluginname'] = 'S3 Secure PDF';
$string['modulename'] = 'S3 Secure PDF';
$string['modulenameplural'] = 'S3 Secure PDFs';
$string['privacy:metadata'] = 'The S3 Secure PDF plugin stores minimal personal data for watermarking.';

$string['name'] = 'Name';
$string['intro'] = 'Description';
$string['objectkey'] = 'Object key (S3)';
$string['objectkey_help'] = 'Path/key to the PDF in the configured bucket (e.g. documents/manuals/intro.pdf).';
$string['watermarktpl'] = 'Watermark template';
$string['download'] = 'Download PDF';
$string['invalidtoken'] = 'Invalid or expired download token.';

$string['setting:endpoint'] = 'S3 Endpoint';
$string['setting:region'] = 'S3 Region';
$string['setting:bucket'] = 'S3 Bucket';
$string['setting:prefix'] = 'Path prefix';
$string['setting:accesskey'] = 'Access key';
$string['setting:secretkey'] = 'Secret key';
$string['setting:verifytls'] = 'Verify TLS certificates';
$string['setting:cacheseconds'] = 'Cache TTL (seconds)';
$string['setting:tokenseconds'] = 'Token TTL (seconds)';
$string['setting:watermarktpl'] = 'Default watermark template';
$string['setting:fontsize'] = 'Font size';
$string['setting:opacity'] = 'Opacity (0-1)';
$string['setting:angle'] = 'Angle (deg)';
$string['setting:connecttimeout'] = 'Connect timeout (seconds)';
$string['setting:requesttimeout'] = 'Request timeout (seconds)';
$string['setting:debugs3'] = 'Debug S3 requests to error_log';

$string['event:file_downloaded'] = 'S3 Secure PDF file downloaded';
$string['s3connecterror'] = 'S3 connection failed. Please check endpoint/credentials or timeouts.';
