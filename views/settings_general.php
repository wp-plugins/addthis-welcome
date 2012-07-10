<style>

#icon-edit.addthis.icon32{
background: url(//s7.addthis.com/static/r07/widget005_32x32_top.png) no-repeat left;
background-position: 0 -416px!important;
overflow: hidden;
display: block;
height: 32px!important;
width: 32px!important;
line-height: 32px!important;
}

</style>

<div class='at-wrap wrap'>
	
	<div class="at-tabs">
		
		<?php  
		$advanced = get_option('addthis_bar_config_advanced');
		?>
		
		<a class="at-modal-trigger" <?php
			if($advanced != '0' ) {
				//if(current_user_can('subscriber'))
				echo 'title="Developers: Edit your Welcome Bar plugin code using our API to unlock additional features.">Revert to Default Plugin';
			} else {
				echo 'title="Developers: Edit your Welcome Bar plugin code using our API to unlock additional features.">Edit Plugin Code (Advanced)';
			} ?>
			
		</a>
	</div>
	
	<div id="icon-edit" class="icon32 addthis"><br></div>
	<h2>AddThis Welcome Bar</h2>
	
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

