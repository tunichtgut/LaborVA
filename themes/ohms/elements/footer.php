<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>
	    <div id="footer">
                <hr id="footerRule" />
                <div id="ohmsLogo"></div>
                <div id="footerNav">
                    <span id="links">
                        <a href="http://www.ohms.de" title="<?php echo t('Autohaus Ohms GmbH & Co. KG i. I.')?>"><?php echo t('Autohaus Ohms GmbH & Co. KG i. I.')?></a>
                        <br />
                        <a href="http://localhost:63146/index.php/impressum/" title="Impresum">Impressum</a>
                        &nbsp; &nbsp; 
                        &middot;
                        &nbsp; &nbsp; 
			            <?php 
			            $u = new User();
			            if ($u->isRegistered()) { ?>
				            <?php  
				            if (Config::get("ENABLE_USER_PROFILES")) {
					            $userName = '<a href="' . $this->url('/profile') . '">' . $u->getUserName() . '</a>';
				            } else {
					            $userName = $u->getUserName();
				            }
				            ?>
				            <span class="sign-in"><?php echo t('Hallo <b>%s</b>.', $userName)?> <a href="<?php echo $this->url('/login', 'logout')?>"><?php echo t('Ausloggen')?></a></span>
			            <?php  } else { ?>
				            <span class="sign-in"><a href="<?php echo $this->url('/login')?>"><?php echo t('Für Mitarbeiter')?></a></span>
			            <?php  } ?>
                    </span>
                    <br />
                    <span id="copyNotice">
                        &copy; <?php echo date('Y')?>
			            <?php echo t(' - ')?>
                        <?php echo t('Alle Rechte vorbehalten.')?>
                    </span>
                </div>
			    
	    </div>
    </div> <!--End mainContent-->
</div>

<?php  Loader::element('footer_required'); ?>

</body>
</html>