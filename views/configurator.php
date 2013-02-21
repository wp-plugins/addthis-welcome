<?php

$activated = get_option('addthis_bar_activated');
if($activated == '0') {
		echo '<span style="float: left;margin-left: 680px;margin-top: 20px;">Addthis Welcome plugin is currently deactivated</span>';
	} else {
	echo '<span style="float: left;margin-left: 680px;margin-top: 20px;">Addthis Welcome plugin is currently activated</span>';
	}?>

<div class="wbcontainer">
<?php if(get_option('addthis_bar_activated') == '0' && isset($_GET)) {
    	echo '<div class="updated"><p>Welcome Addthis plugin is currently deactivated. For your configurations to appear on the website, you need to activate the plugin first.</p></div>';
} ?>
<div class="error" id="set-error" style="display:none;">Please select atleast one rule.</div>
<form method="post" action="options.php"> 


<?php //require('includes/static_assets.php') ?>
<?php require('includes/configurator_script.php') ?>

<script type='text/javascript'>
window.wombat_config = <?php if(get_option('addthis_bar_config_default') != '') { echo get_option('addthis_bar_config_default'); } else { echo '{}'; } ?> ;
if(typeof wombat_config === 'undefined') {
	wombat_config = {};
}
</script>
<?php 
if(get_option('addthis_bar_config_default') != '') {
	$options = get_option('addthis_bar_config_default');
	$background = explode('"backgroundColor": "', $options);
	$bgColor = explode('",', $background[1]);
	$text = explode('"textColor": "', $options);
	$tColor = explode('",', $text[1]);
	$btn = explode('"buttonColor": "', $options);
	$btnColor = explode('",', $btn[1]);
	$btnText = explode('"buttonTextColor": "', $options);
	$btnTextColor = explode('",', $btnText[1]);

echo "<style type='text/css'>
.addthis_bar_container {
	background-color: $bgColor[0] !important;
}
.addthis_bar_p {
	color: $tColor[0] !important;
}
.addthis_bar_button {
	background-color: $btnColor[0] !important;
	color: $btnTextColor[0] !important;
	border-color: $btnColor[0] !important;
}
</style>";
}
?>
<style>

.fixInput{
	height:auto !important;
}

#followId, #btnTxt, #btnUrl, #welcomeMsg {
height: auto;
line-height: 15px;
}


.addthis_bar_container{
	z-index:1000;
	color:none;
}

</style>

<div>	    
    <div class="wbcontainer ml10" style="">
		<div style="position:absolute;right:74px;top:28px">
		<strong>AddThis Profile ID:</strong>
        <input style="width:240px;" size=18 maxlength="80" class="fixInput" value="<?php 
			global $addthis_addjs;
			$pubid = $addthis_addjs->pubid ;
			echo $pubid;

		?>"type="text" id="" disabled="disabled"/>
		</div>
        <div class="wbcHdr">
			<h3 class="helv org">Customize messages for visitors coming from...</h3>
        </div>
        <div class="wbcMain">
	
			<div class="wbcMainLt">
	                <div class="wbcWhoHdr tlbr4 trbr4"><span class="boxHdr"></span></div>
	                <div id="wbRules">
	                    <!--div class="wbcWho"><input type="checkbox" checked=true id="CBtwitter" value="twitter" /> Twitter</div-->
	                    <!--div class="wbcWho"><input type="checkbox" checked=false id="CBany" value="any" /> Any other visitor</div-->
	                    <!--<div class="wbcWho"><input type="checkbox" id="CBamazon" value="amazon" /> Amazon.com</div>-->
	                </div>
	                <div class="wbcAdd bold">+ Add visitor type</div>
	                <div class="wbcWhoFtr brbr4 blbr4">
	                    <div class="wbcWhoFtrHide">
	                        <hr class="leftHr">
	                        <h5>Profile</h5>
	                           <select id="pub" name="pub">

	                            </select>
	                    </div>
	                </div>
	            </div>
        
            <div class="wbcMainRt" style="">
                <p class="mb10">Visitors from <span id="previewLabel">everywhere</span> will see this bar at the top of their screen:</p>
                <div class="clear"></div>
                <div class="liveHide blbr4 brbr4">
                    <div class="liveContainer">
                        <div class="addthis_bar_container"></div>
                    </div>
                </div>
                <div id="previewBar">
                    <span id="previewBarText">Would you consider a re-tweet? </span>
                    <div id="previewBarButton">Tweet</div>
                </div>
                <div class="clear"></div>
                <p class="mb10">Customize the message and call to action for visitors from <span id="optionsLabel">Twitter</span>:</p>
                
                <div class="optionsDiv br4">
                    <div class="optionsMsg">
                        <span>Message:</span><br>
                        <input size=28 maxlength="80" class="fixInput" type="text" id="welcomeMsg"/>
                    </div>
                    <div class="optionsBtn">
                        <span>Button Action:</span><br>
                        <select id="btnType">
                            <option value=share>Share</option>
                            <option value=follow>Follow</option>
                            <option value=custom>Go to URL</option>
                        </select>
                        <div class="optionsUrl">
                            <span id="urlLabel">Button URL:</span><span id="urlValError">(Please provide a protocol, i.e. "http://")</span><br>
                            <input type="text" id="btnUrl" class="fixInput"/>
                        </div>
                        <div class="followDrop">
                            <span id="followSelectLabel">Select a Service</span><br>
                            <select id="followSelect">
                                <option value="google">Google</option>
                                <option value="youtube">Youtube</option>
                                <option value="facebook">Facebook</option>
                                <option value="rss">RSS</option>
                                <option value="flickr">Flickr</option>
                                <option value="foursquare">Foursquare</option>
                                <option value="instagram">Instagram</option>
                                <option value="twitter" selected="selected">Twitter</option>
                                <option value="linkedin">Linkedin</option>
                                <option value="pinterest">Pinterest</option>
                                <option value="tumblr">Tumblr</option>
                                <option value="vimeo">Vimeo</option>
                            </select>
                        </div> 
                    </div>
                    <div class="optionsTxt">
                        <span>Button Text:</span><br>
                        <input class="fixInput" size=20 maxlength="40" type="text" id="btnTxt"/>
                        <div class="optionsId">
                            <span id="followLabel"></span><br>
                            <input type="text" id="followId" class="fixInput"/>
                        </div>                                           
                    </div>
                    <div class="clear"></div>
                </div>
				<div class="br4">
					<div class="optionsMsg">
						
						
                        
                    </div>
					<div class="clear"></div>
				</div>
		
		
		<?php settings_fields('addthis_bar_config_default'); ?>
		<?php // $options = get_options('addthis_bar_config_default'); ?>
		<input type='hidden' id='wbCode' class="addthis_bar_config_input" name='addthis_bar_config_default' />
		<input type="hidden" name="is-set" id="is-set" value="" />
		
        	
	</div>
			<div class="clear"></div>
	    
	
    <div class="lwrOpt">
        <div class="wbcHdr">
			<h3 class="helv org">Finalize appearance</h3>
        </div>

        <div class="clrPkr br4" style="overflow:auto;padding-right:20px;width:900px;">
			<div style="float:left;padding-left:15px;width:655px;padding-right:10px;">
	            <div style="font-size:14px;float:none"><b>Colors</b></div><br>
	            <div>
	                <span>Background:</span><br />
	                <input type="text" id="barColor" class="color-picker" size="6" value="#464646" style="position:relative;top:1px;padding-right:0px;margin-right:0px"/>
	            </div>
	            <div style="margin-left:10px">
	                <span>Message Text:</span><br>
	                <input type="text" id="messageColor" class="color-picker" size="6" value="#CCCCCC" style="position:relative;top:1px;padding-right:0px;margin-right:0px;"/>
	            </div>
	            <div style="margin-left:10px">
	                <span>Button:</span><br>
	                <input type="text" id="buttonColor" class="color-picker" size="6" value="#098DF4" style="position:relative;top:1px;padding-right:0px;margin-right:0px"/>
	            </div>
	            <div style="margin-left:10px">
	                <span>Button Text:</span><br>
	                <input type="text" id="buttonTextColor" class="color-picker" size="6" value="#FFFFFF" style="position:relative;top:1px;padding-right:0px;margin-right:0px"/>
	            </div>
			</div>
			<div style="float:left;width:220px;" style="padding-left:45px;padding-right:100px">
				<div style="font-size:14px;float:none"><b style="float:left;padding-left:6px;">Auto-dismiss bar</b></div><p style="margin-top:20px;float:left;width:130px;">
	            <input type="checkbox" id="CBdisT" style="top: 0px;position: relative;float: left;"/><span style="float: left;margin-top: 3px;">After</span>
	            <input type="text" id="TBdisT" value="20" size="3" style="margin-left:3px;margin-right:3px;float:left;margin-top:0;"/><span style="float: left;margin-top: 3px;">sec</span></p>
			</div>
            
        </div>
        <p>
            <input class="button-secondary" type="submit" name="save" value="<?php _e('Save'); ?>" id="submit-button"/>
        </p>
        <div id="rules-error" style="display:none;" class="error">Please select atleast one rule.</div>
        <br />
			<div>
			<h4>Additional features</h4>
            <span>Use the <a href="//support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank">Welcome bar API</a> to design a custom greeting for your site. Welcome visitors based on location, time of day, new vs. returning, and more.</span>
			</div>
        </div>
    </div>
   	<div class="clear"></div>
   	
</div>
<div id="lightbox-panel">
	<a id="close-panel" class="lb-close" href="#">X</a>
	<div class="lb-title"><h4>Add Visitor Type</h4></div>
	<div class="lb-inner">
		<ul class="tabs">
			<li><a class="wbPopTabs0 tab-active" href="#">From URL</a></li>
			<li><a class="wbPopTabs1" href="#">From Service</a></li>
			<li><a class="wbPopTabs2" href="#">More Options</a></li>
		</ul>
		<div class="wbPopMain">
			<div class="wbPopUrl">
				<p>Welcome visitors from any URL that contains:</p>
				<input type="text" id="urlSelect" value="ex: abcnews.com" /><br/>
				<input id="BTwbpopurl" class="lgbtn" type="button" value="Add visitor type" />
			</div>
			<div class="wbPopSvc">
				<p>Welcome visitors from:</p>
				<select id="serviceSelect" value="any">- Any -</select><br/>
				<input id="BTwbpopsvc" class="lgbtn" type="button" value="Add visitor type" />
			</div>
			<div class="wbPopMore">
				Use our <a href="//support.addthis.com/customer/portal/articles/524574-addthis-bar-api" target="_blank">API</a> to customize greetings based on:
				<ul class="list-plus mt10">
					
				</ul>
		</div>
	</div>
	</div>	
</div><!-- /lightbox-panel -->

<div id="lightbox"> </div><!-- /lightbox -->

</form>

</div>