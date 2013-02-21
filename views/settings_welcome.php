<?php require('includes/static_assets.php') ?>
<style>
.welcome-note {
	float: left;
	width: 500px;
	padding: 100px;
	margin: 0 170px;
}
.welcome-note .addthis-title {
	color: black;
	font-size: 45px;
	font-weight: bold;
	letter-spacing: 0px;
	float: left;
	padding-top: 8px;
	margin-left: 8px;
}
.welcome-note .addthis-plugin-name {
	float: left;
	font-size: 43px;
	font-weight: normal;
	letter-spacing: 4px;
	margin-left: 8px;
	padding-top: 9px;
}
.welcome-note {
	color: #444444;
	font-family: "Open Sans",Helvetica,arial,sans-serif;
	font-weight: 300;
	letter-spacing: -.05em;
}
.welcome-note .btn-blue {
	padding: 15px 10px;
	font-size: 1.2em;
	font-weight: normal;
	color:#fff;
}
.welcome-note .bigtext{
	color: #666;
	float: left;
	width: 435px;
}
.welcome-note span.bigtext{
	font-weight: bold;
	color: #444;
	font-size: 19px;
}
.welcome-note .title-block {
	float:left;
	margin-bottom: 40px;
}
</style>
<div class='welcome-note'>
	<div class="title-block">
	<p>
<!--	<img style="float:left;" alt='addthis' src="//cache.addthis.com/icons/v1/thumbs/32x32/more.png" class="header-img"/>-->
	<span class="addthis-btn"></span>
    <span class="addthis-title">AddThis</span> <span class="addthis-plugin-name">Welcome</span></p>
	</div>
	<div class='clear'></div>
	<span class='bigtext'>Increase conversations with custom greetings</span>
	<p class="bigtext" >Welcome visitors with a personalised greeting based on their social network preferences. Invite them to take specific actions like sharing, following, or visiting a page.</p>
	<form name="at-welcome-bar-active" class="at-welcome-bar-activate" method="post" action="#" style="float:left;margin-top:2px;padding-top:0">
		<input type="hidden" name="addthis_bar_initial_activate" id="addthis_bar_initial_activate" value = "<?php if( get_option('addthis_bar_initial_activate') == '0') { echo '1';} else { echo '0';} ?>" />
		<?php settings_fields('addthis_bar_initial_activate'); ?>
		<?php //settings_fields('addthis_bar_activated'); ?>
		<input type="hidden" name="addthis_bar_activated" id="addthis_bar_activated" value = "<?php if( get_option('addthis_bar_activated') == '0') { echo '1';} else { echo '0';} ?>" />
		<input id="at-welcome-bar-activate" class="btn-blue" type="submit" value="Activate the welcome bar" />
	</form>
</div>
