<?php
defined('is_running') or die('Not an entry point...');

function Install_Check(){
	global $config;

	echo '<p>Install Simple Online Visitor</p>';
	if( isset($config['customlang']['%d Visitors and %d robots online currently']) ){
		echo '<p>Convert old text string</p>';
		$text = $config['customlang']['%d Visitors and %d robots online currently'];
		$textarea = array('text'=> '<div class="online_visitor">'.$text.'</div>');
		$datafolder = $config['addons']['Online Visitor']['data_folder'];
		$file = 'data/_addondata/'.$datafolder.'/textarea.php';
		if( !gpFiles::SaveData($file, 'textarea', $textarea) ){
			echo '<p>Convert failed</p>';
		}else{
			echo '<p>Convert successfull</p>';
		}
	}
	
	return true;
}
