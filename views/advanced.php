<div class="">
<?php  
global $addthis_addjs;
echo $addthis_addjs->getAtPluginPromoText();
?>

<?php require('includes/static_assets.php') ?>

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
    <div class="lwrOpt ml10">
        <div class="wbcHdr">
		<h3 class="helv org">Customize the Welcome Bar through the <a href="http://support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank"> Welcome Bar API</a></h3>
		<span>Reference the <a href="//support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank">Welcome bar API</a> to design a custom greeting for your site.</span>
        </div>
	</div>

        </div>
        <div class="codeRt">
            <div class="instructions"><span class="copyLabel">Edit your settings.</span>
                <div class="RDcodesize">
                </div>
            </div>
            <div class="copyCode">
                <form action="options.php" method="post">
			<?php settings_fields('addthis_bar_config_default'); ?>
			<?php $options = get_option('addthis_bar_config_default'); ?>		
			<textarea id="wbCode" name="addthis_bar_config_default" style="resize:both;height:400px" rows=25 cols=100 ><?php echo $options; ?></textarea>
			
			<?php //do_settings_fields('addthis_bar_config_default'); ?>		
			<?php if(current_user_can('unfiltered_html')) {
				submit_button();
			} ?> 
                </form>

		<span class="legal">By publishing this code, you are accepting our <a href="http://www.addthis.com/tos" target="_blank">Terms of Service</a></span>
            </div>
						
            <p class="mt20">Note: This feature is not compatible with IE 7 and below.</p>
            
			<br/>
			
        </div>
    </div>
</div> 


</div>
