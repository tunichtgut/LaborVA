<br />
<b>Warning</b>:  copy(/kunden/326221_24251/webseiten/cloud/owncloud/data/matthis/files_versions/Dokumente/My Web Sites/concrete5/concrete/mail/spam_detected.php.v1359203617) [<a href='function.copy'>function.copy</a>]: failed to open stream: No such file or directory in <b>/kunden/326221_24251/webseiten/cloud/owncloud/lib/filestorage/local.php</b> on line <b>109</b><br />
<?php 

defined('C5_EXECUTE') or die("Access Denied.");

$subject = SITE . " " . t("Notification - Spam Detected");
$body = t("

Someone has attempted to send you spam through your website. Details below:

%s", $content);