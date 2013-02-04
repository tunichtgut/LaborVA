<br />
<b>Warning</b>:  copy(/kunden/326221_24251/webseiten/cloud/owncloud/data/matthis/files_versions/Dokumente/My Web Sites/concrete5/concrete/single_pages/dashboard/system/seo/view.php.v1359203698) [<a href='function.copy'>function.copy</a>]: failed to open stream: No such file or directory in <b>/kunden/326221_24251/webseiten/cloud/owncloud/lib/filestorage/local.php</b> on line <b>109</b><br />

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('System &amp; Settings'));?>
<form>
<?php 
foreach($categories as $cat) { ?>

	<div class="page-header">
	<h3><a href="<?php echo Loader::helper('navigation')->getLinkToCollection($cat)?>"><?php echo $cat->getCollectionName()?></a>
	<small><?php echo $cat->getCollectionDescription()?></small>
	</h3>
	</div>
	
	<?php 
	$show = array();
	$subcats = $cat->getCollectionChildrenArray(true);
	foreach($subcats as $catID) {
		$subcat = Page::getByID($catID, 'ACTIVE');
		$catp = new Permissions($subcat);
		if ($catp->canRead() && $subcat->getAttribute('exclude_nav') != 1) { 
			$show[] = $subcat;
		}
	}
	
	if (count($show) > 0) { ?>
	
	<div class="clearfix">
	
	<?php  foreach($show as $subcat) { ?>
	
	<div class="span4">
		<a href="<?php echo Loader::helper('navigation')->getLinkToCollection($cat)?>"><?php echo $subcat->getCollectionName()?></a>
	</div>
	
	<?php  } ?>
	
	</div>
	
	<?php  } ?>

<?php  } ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper();?>
