<?php

global $addthis_addjs;

$addthis_welcome_bar_include = 'addthis.bar.initialize(' . get_option('addthis_bar_config_default') . ');';
$addthis_addjs->addAfterScript($addthis_welcome_bar_include);
$addthis_addjs->output_script();

?>
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
	.addthis_bar_container:not(.closed) {
		left:0px;
	}
	.addthis_bar_watermark, .addthis_bar_close_button, .addthis_bar_open_button{
		background-position: top left !important;
	}
	.addthis_bar_placeholder {
		float:left;
	}
</style>
<!--[if gte IE 8]>
<style type="text/css">
	.addthis_bar_placeholder {
		height: 0 !important;
	}
</style>
<![endif]-->