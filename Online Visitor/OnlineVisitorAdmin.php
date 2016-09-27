<?php
defined('is_running') or die('Not an entry point...');

class OnlineVisitorAdmin {
	
	public static $ovTemplateFile;
	
	public function __construct() {
			global $addonPathData;
			self::$ovTemplateFile = $addonPathData.'/template.php';
			$this->OnlineVisitorAdmin();
	}
	
	public function CheckOldVersion(){
		global $config;
		if( !isset($config['customlang']['%d Visitors and %d robots online currently']) ){
			$ovTemplateHTML = array('html'=>'<div class="online_visitor">{visitors} visitors and {bots} robots online currently</div>');
		}else{
			echo '<p>Convert old string to editable html area: ';
			$string = $config['customlang']['%d Visitors and %d robots online currently'];
			$string = preg_replace('/%d/', '{visitors}', $string, 1);
			$string = preg_replace('/%d/', '{bots}',     $string, 1);
			$ovTemplateHTML = array('html'=>'<div class="online_visitor">'.$string.'</div>');
			if( !gpFiles::SaveData(self::$ovTemplateFile, 'ovTemplateHTML', $ovTemplateHTML) ){
				echo '<span style="color: red;">failed</span>';
			}else{
				echo '<span style="color: green;">successfull</span>';
			}
			echo '</p>';
			unset( $config['customlang']['%d Visitors and %d robots online currently'] );
			\gp\admin\Tools::SaveConfig();
		}
		return $ovTemplateHTML;
	}
	
	public function OnlineVisitorAdmin(){
		global $langmessage, $title;
		if( isset($_POST['save']) ){
			$ovTemplateHTML = array('html'=>$_POST['ovTextarea']);
			if( gpFiles::SaveData(self::$ovTemplateFile, 'ovTemplateHTML', $ovTemplateHTML) ){
				msg($langmessage['SAVED']);
			}else{
				msg($langmessage['OOPS']);
			}
		}
		if( file_exists(self::$ovTemplateFile) ){
			$ovTemplateHTML = gpFiles::Get(self::$ovTemplateFile,'ovTemplateHTML');
		}else{
			$ovTemplateHTML = $this->CheckOldVersion();
		}
		$string = htmlspecialchars($ovTemplateHTML['html']);
		echo '<h2>Simple Online Visitor Admin Page</h2>';
		echo 'version 2.0.1';
		echo '<h3>Editable area</h3>';
		echo '<div>';
		echo '<form method="post" action="'.common::GetUrl($title).'">';
		echo '<p><textarea name="ovTextarea" cols="80" rows="5">'.$string.'</textarea></p>';
		echo '<input name="save" type="submit" class="btn btn-default" value="'.$langmessage['save'].'" />&nbsp;';
		echo '<input name="reset" type="reset" value="'.$langmessage['cancel'].'" />&nbsp;';
		echo '</form></div>';
		echo '<h3>Variables</h3>';
		echo '{visitors} - Visitors counter<br />{bots} - Bots counter<br />';
		echo '<h3>Examples</h3>';
		echo '<h4>Default:</h4><br />';
		echo 'code:<pre>'.htmlspecialchars('<div class="online_visitor">{visitors} Visitors and {bots} robots online currently</div>').'</pre>';
		echo 'result:<div class="online_visitor">5 Visitors and 2 robots online currently</div><br />';
		echo '<h4>Red visitors and green bots count:</h4><br />';
		echo 'code:<pre>'.htmlspecialchars('<div class="online_visitor"><span style="color: red;">{visitors}</span> Visitors and <span style="color: green;">{bots}</span> robots online currently</p></div>').'</pre>';
		echo 'result:<div class="online_visitor"><span style="color: red;">5</span> Visitors and <span style="color: green;">2</span> robots online currently</p></div><br /><br />';
		echo '<h4>Variable {bots} not defined:</h4><br />';
		echo 'code:<pre>'.htmlspecialchars('<div class="online_visitor">{visitors} Visitors online currently</div>').'</pre>';
		echo 'result:<div class="online_visitor">5 Visitors online currently</div>';
	}
}
