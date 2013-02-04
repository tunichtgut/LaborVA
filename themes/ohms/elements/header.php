<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?php echo LANGUAGE?>" xmlns="http://www.w3.org/1999/xhtml">
<head>

<!-- Site Header Content //-->
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $this->getStyleSheet('main.css')?>" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $this->getStyleSheet('typography.css')?>" />

<?php  Loader::element('header_required'); ?>

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

</head>
<body>

<div id="page">
    <div id="mainContent">
	    <div id="header">
		    <?php  if ($c->isEditMode()) { ?>
		    <div style="min-height: 80px">
		    <?php  } ?>
		
		    <div id="headerNav">
			    <?php
			    $a = new Area('Header Nav');
			    $a->display($c);
			    ?>
		    </div>

		    <?php 
		    // we use the "is edit mode" check because, in edit mode, the bottom of the area overlaps the item below it, because
		    // we're using absolute positioning. So in edit mode we add a bit of space so everything looks nice.
		    ?>
            <div id="headerSpacer"></div>

		    <div class="spacer"></div>

		    <?php  if ($c->isEditMode()) { ?>
		    </div>
		    <?php  } ?>
		
		    <div id="header-area">
			    <!--div class="divider"></div-->
			    <div id="header-area-inside">
			    <?php 			
			    $ah = new Area('Header');
			    $ah->display($c);			
			    ?>	
			    </div>	
			
		    </div>
	    </div>			
