<?php 
$activated = get_option('addthis_bar_activated');
if($activated == '0') {
		echo '<span style="margin-left: 680px;margin-top: 20px;float: left;">Addthis Welcome plugin is currently deactivated</span>';
	} else {
	echo '<span style="margin-left: 680px;margin-top: 20px;float: left;">Addthis Welcome plugin is currently activated</span>';
	}?>
<div class="">

<?php //require('includes/static_assets.php') ?>

<style>

.fixInput{
	height:auto !important;
}

#followId, #btnTxt, #btnUrl, #welcomeMsg {
height: auto;
line-height: 15px;
}

</style>
<div>	
	<?php if(get_option('addthis_bar_activated') == '0' && isset($_GET)) {
    	echo '<div class="updated"><p>Welcome Addthis plugin is currently deactivated. For your configurations to appear on the website, you need to activate the plugin first.</p></div>';
	} ?>    
    <div class="lwrOpt ml10">
        <div class="wbcHdr">
		<h3 class="helv org" style="float: left;width: 100%;">Customize the Welcome Bar through the <a href="http://support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank"> Welcome Bar API</a></h3>
		<span style="float: left;width: 100%;margin-bottom: 10px;">Reference the <a href="//support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank">Welcome bar API</a> to design a custom greeting for your site.</span>
        </div>
	</div>
	<div class="clear"></div>
	<div class="clear"></div>
</div>
<div class="codeRt">
	<div class="instructions"><span class="copyLabel">Edit your settings.</span>
    	<div class="RDcodesize">
             <div class="clear"></div>
        </div>
    </div>
    <div class="copyCode">
        <form action="options.php" method="post">
			<?php settings_fields('addthis_bar_config_default'); ?>
			<?php $options = get_option('addthis_bar_config_default'); ?>		
			<textarea id="wbCode" name="addthis_bar_config_default" style="resize:both;height:400px" rows=25 cols=100 ><?php echo $options; ?></textarea>
			<div class="clear"></div><div class="clear"></div><div class="clear"></div>
			<?php //do_settings_fields('addthis_bar_config_default'); ?>		
			<?php if(current_user_can('unfiltered_html')) {
				//submit_button();
				echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
			} ?> 
        </form>
		<span class="legal">By publishing this code, you are accepting our <a href="http://www.addthis.com/tos" target="_blank">Terms of Service</a></span>
		<div class="clear"></div><div class="clear"></div><div class="clear"></div><div class="clear"></div>
		<p class="mt20">Note: This feature is not compatible with IE 7 and below.</p>
		<div class="clear"></div><div class="clear"></div><div class="clear"></div><div class="clear"></div>
    </div>
				
    
    <div class="clear"></div><div class="clear"></div><div class="clear"></div>
</div>
</div>
    <div class="clear"></div><div class="clear"></div>
