<div class='at-wrap wrap'>
    <?php if(!at_welcome_is_pro_user()) { ?>
    <div class="updated addthis_setup_nag">
        <p>AddThis Pro now available - start your trial at 
            <a href="http://www.addthis.com" target="_blank">www.addthis.com</a> 
            and get premium widgets, personalized content recommendations, 
            advanced customization options and priority support.
        </p>
    </div>
    <?php } ?>
    <?php  
        global $addthis_addjs;
        echo $addthis_addjs->getAtPluginPromoText();
    ?>
	<div class="at-tabs">
		<?php 
		$activated = get_option('addthis_bar_activated');
//		$activated = 0;
		?>
		<a class="at-modal-trigger-activate" 
		<?php if($activated == '0') { 
			echo 'title="Developers: Activate the Addthis Welcome plugin to show the welcome bar on your website.">Activate';
		 } else {
			echo 'title="Developers: Deactivate the Addthis Welcome plugin to remove the welcome bar from your website.">Deactivate</a>';
		} ?>
		</a>
		<?php  
		$advanced = get_option('addthis_bar_config_advanced');
		?>
		
		<a class="at-modal-trigger" 
		<?php if($advanced != '0' ) {
				//if(current_user_can('subscriber'))
				echo 'title="Developers: Edit your Welcome Bar plugin code using our API to unlock additional features.">Revert to Default Plugin';
			} else {
				echo 'title="Developers: Edit your Welcome Bar plugin code using our API to unlock additional features.">Edit Plugin Code (Advanced)';
			} ?>
			
		</a>
		
	</div>
	
	<p>
	<span class="addthis-btn"></span>
    <span class="addthis-title">AddThis</span> <span class="addthis-plugin-name">Welcome</span></p>
	
	<div class='clear'></div>
</div>


	<div class="at-welcome-dialog" style="display:none">
	    <p><?php 
		if($advanced != '0') {
			echo "Are you sure you want to revert to the default configurator? Some of your changes may be lost.";
		} else {
			echo "Are you sure you would like to directly edit the Welcome Bar code?";
		} ?>	
		</p>
	    <form class="at-welcome-dialog-buttons" method="post" action="options.php" style="float:left;margin-top:2px;padding-top:0">
			<?php settings_fields('addthis_bar_config_advanced'); ?>
			<?php $options = get_option('addthis_bar_config_advanced'); ?>
			<input type="hidden" name="addthis_bar_config_advanced" value = "<?php if( get_option('addthis_bar_config_advanced') != '0') { echo '0';} else { echo '1';} ?>" />
	        <input id="at-welcome-dialog-ok" class="button button-highlighted" type="submit" value="OK" />		
		</form>
		<button id="at-welcome-dialog-cancel" class="button" value="Cancel" />
			Cancel
		</button>
	    
	</div>
	<div class="at-welcome-activate" style="display:none">
	    <p><?php 
		if($activated == '0') {
			echo "Are you sure you want to activate the Addthis Welcome plugin?";
		} else {
			echo "Are you sure you want to deactivate the Addthis Welcome plugin?";
		} ?>	
		</p>
	    <form class="at-welcome-dialog-buttons" method="post" action="options.php" style="float:left;margin-top:2px;padding-top:0">
	    	<?php settings_fields('addthis_bar_activated'); ?>
			<?php $options = get_option('addthis_bar_activated'); ?>
			<input type="hidden" name="addthis_bar_activated" value = "<?php if( get_option('addthis_bar_activated') != '0') { echo '0';} else { echo '1';} ?>" />
	        <input id="at-welcome-activate-ok" class="button button-highlighted" type="submit" value="OK" />		
		</form>
		<button id="at-welcome-activate-cancel" class="button" value="Cancel" />
			Cancel
		</button>
	    
	</div>