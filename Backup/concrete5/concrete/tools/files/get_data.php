<br />
<b>Warning</b>:  copy(/kunden/326221_24251/webseiten/cloud/owncloud/data/matthis/files_versions/Dokumente/My Web Sites/concrete5/concrete/tools/files/get_data.php.v1359203653) [<a href='function.copy'>function.copy</a>]: failed to open stream: No such file or directory in <b>/kunden/326221_24251/webseiten/cloud/owncloud/lib/filestorage/local.php</b> on line <b>109</b><br />
<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$u = new User();
$form = Loader::helper('form');

$respw = array();

$fileIDs = array();
$files = array();
if (is_array($_REQUEST['fID'])) {
	$fileIDs = $_REQUEST['fID'];
} else {
	$fileIDs[] = $_REQUEST['fID'];
}

foreach($fileIDs as $fID) {
	$f = File::getByID($fID);
	$fp = new Permissions($f);
	if ($fp->canRead()) {
		$files[] = $f;
	}
}

if (count($files) == 0) {
	die(t("Access Denied."));
}

$i = 0;
foreach($files as $f) {
	$ats = $f->getAttributeList();
	$resp[$i]['error'] = false;
	$resp[$i]['filePathDirect'] = $f->getRelativePath();
	$resp[$i]['filePathInline'] = View::url('/download_file', 'view_inline', $f->getFileID());
	$resp[$i]['filePath'] = View::url('/download_file', 'view', $f->getFileID());
	$resp[$i]['title'] = $f->getTitle();
	$resp[$i]['fileName'] = $f->getFilename();
	$resp[$i]['thumbnailLevel1'] = $f->getThumbnailSRC(1);
	$resp[$i]['thumbnailLevel2'] = $f->getThumbnailSRC(2);
	$resp[$i]['thumbnailLevel3'] = $f->getThumbnailSRC(3);
	$resp[$i]['fID'] = $f->getFileID();
	foreach($ats as $key => $value) {
		$resp[$i][$key] = $value;
	}
	$i++;
}

$h = Loader::helper('json');
print $h->encode($resp);