S3 Secure PDF — overlay patch 0.3.3 (2025-08-25)

What changed:
- Remove duplicate heading in view.php (Moodle already shows activity name).
- Switch to server-side S3 fetch and inline delivery via download.php.
- Watermark with user full name + timestamp using FPDI (if available). Falls back to original PDF if FPDI not installed.
- New settings for endpoint/region/bucket/access/secret. Presigned URLs can remain disabled.
- Capability mod/s3securepdf:view ensured in db/access.php.
- version.php bumped to 2025082500, release 0.3.3.

How to install:
1) Make a backup of your plugin folder.
2) Unzip this archive over your existing mod/s3securepdf folder (it only adds/overwrites a few files).
3) In Moodle as admin, visit the notifications page to trigger the plugin upgrade.
4) Go to: Site administration → Plugins → Activity modules → S3 Secure PDF and fill S3 settings.
5) Ensure composer dependencies exist (aws-sdk-php, fpdi). If not, run composer install in the plugin root.

Notes:
- If your DB column for the S3 object key is named differently, adjust in download.php ($key resolution).
- If you prefer no watermark, you can comment out the FPDI block in download.php.
