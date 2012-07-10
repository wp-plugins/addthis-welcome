<?php


global $addthis_addjs;

$addthis_welcome_bar_include = 'addthis.bar.initialize(' . get_option('addthis_bar_config_default') . ');';
$addthis_addjs->addAfterScript($addthis_welcome_bar_include);
$addthis_addjs->output_script();

?>

<style>
	.addthis_bar_container:not(.closed) {
		left:0px;
	}
	.addthis_bar_watermark, .addthis_bar_close_button, .addthis_bar_open_button{
		background-position: top left !important;
	}
</style>
