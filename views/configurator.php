<div class="wbcontainer">
<?php  
global $addthis_addjs;
echo $addthis_addjs->getAtPluginPromoText();
?>

<form method="post" action="options.php"> 


<?php require('includes/static_assets.php') ?>
<?php require('includes/configurator_script.php') ?>

<script type='text/javascript'>
window.wombat_config = <?php if(get_option('addthis_bar_config_default') != '') { echo get_option('addthis_bar_config_default'); } else { echo '{}'; } ?> ;
if(typeof wombat_config === 'undefined') {
	wombat_config = {};
}
</script>
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
}

</style>

<div>	    
    <div class="wbcontainer ml10" style="">
		<div style="position:absolute;right:68px;top:20px">
		<span>Profile ID:</span>
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

		
        	<input class="button-primary" type="submit" name="save" value="<?php _e('Save Options'); ?>" id="submit-button" style="float:right"/>    
	</div>
			<div class="clear"></div>
	    
	
    <div class="lwrOpt">
        <div class="wbcHdr">
			<h3 class="helv org">Finalize appearance</h3>
        </div>

        <div class="clrPkr br4" style="overflow:auto;padding-right:20px;">
			<div style="float:left;padding-left:15px;padding-right:30px">
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
			<div style="float:left" style="padding-left:45px;padding-right:100px">
				<div style="font-size:14px;float:none"><b>Auto-dismiss bar</b></div><p />
	            <input type="checkbox" id="CBdisT" style="top:-3px;position:relative"/>After
	            <input type="text" id="TBdisT" value="20" size="3" style="margin-left:0;"/>sec
			</div>
            
        </div><br>
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
