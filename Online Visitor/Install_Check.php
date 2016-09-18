<?php
defined('is_running') or die('Not an entry point...');

function Install_Check(){
	global $config;

	echo '<p>Install Simple Online Visitor 2.0</p>';
	if( isset($config['customlang']['%d Visitors and %d robots online currently']) ){
		echo '<p>Please visit the Simple Online Visitor Admin page to convert the old text data</p>';
	}
	return true;
}
