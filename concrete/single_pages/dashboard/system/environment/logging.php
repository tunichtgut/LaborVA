<?php 
defined('C5_EXECUTE') or die("Access Denied.");
$dh = Loader::helper('concrete/dashboard');

echo $dh->getDashboardPaneHeaderWrapper(t('Logging'), t('Enables saving records of emails being sent out. This will save records even if actual email delivery is disabled on your site.'), 'span10 offset3', false);
?>

<form method="post" class="form-stacked" action="<?php  echo $this->action('update_logging'); ?>">
	<div class="ccm-pane-body">	
		<?php  echo $this->controller->token->output('update_logging'); ?>
		
		<div class="clearfix">
			<div class="input">
			<ul class="inputs-list">
			<li>
			<label for="ENABLE_LOG_ERRORS">
				<?php  echo $fh->checkbox('ENABLE_LOG_ERRORS', 1, $intLogErrors) ?>
			
				<span><?php  echo t('Log Application Exceptions'); ?></span>
			</label>	
			</li>
			<li><label for="ENABLE_LOG_EMAILS">
				<?php  echo $fh->checkbox('ENABLE_LOG_EMAILS', 1, $intLogEmails) ?>
			
				<span><?php  echo t('Log Emails Sent'); ?></span>
			</label>
			</li>
			</ul>
			</div>
		</div>		

	</div>

	<div class="ccm-pane-footer">	
		<?php  echo $interface->submit(t('Save'), 'logging-form', 'right', 'primary'); ?>
	</div>
</form>

<?php  echo $dh->getDashboardPaneFooterWrapper(false); ?>