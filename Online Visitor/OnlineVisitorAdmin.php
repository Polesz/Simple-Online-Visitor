<?php
defined('is_running') or die('Not an entry point...');

$langmessage['Editable area'] = 'Editable area';

class OnlineVisitorAdmin {
	
	public static $data_dir;
	
	public function __construct() {
			global $addonPathData;
			self::$data_dir = $addonPathData;
			$this->OnlineVisitorAdmin();
	}
	
	public function OnlineVisitorAdmin(){
	  global $langmessage,$title;
	  $file = self::$data_dir.'/textarea.php';
	  if( isset($_POST['save']) ){
			$textarea = array('text' => $_POST['sovtext']);
			if( !gpFiles::SaveData($file, 'textarea', $textarea) ){
				msg('sikertelen mentés');
			}else{
				msg('sikeres mentés');
			}
		}
	  if( file_exists($file) ){
				$textarea = gpFiles::Get($file,'textarea');
	  }else{
		  $textarea = array('text' => '<div class="online_visitor">{visitors} visitors and {bots} bot online currently</div>');
	  }
		echo '<div>';
		echo '<h3>'.$langmessage['Editable area'].'</h3>';
		echo '<form method="post" action="'.common::GetUrl($title).'">';
		echo '<p><textarea name="sovtext" cols="80" rows="5">'.htmlspecialchars($textarea['text']).'</textarea></p>';
		echo '<input name="save" type="submit" class="btn btn-default" value="'.$langmessage['save'].'" />&nbsp;';
		echo '<input name="reset" type="reset" value="'.$langmessage['cancel'].'" />&nbsp;';
		echo '<input name="preview" type="button" value="'.$langmessage['preview'].'" />';		
		echo '</form></div>';
		echo '<hr />';
		echo '<div><p>note:<br/>{visitors} and {bots} variable needed</p></div>';
	}
}
