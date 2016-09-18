<?php
defined('is_running') or die('Not an entry point...');

class OnlineVisitor{
	
	public static $ovTemplateFile;
	public static $ovVisitorsFile;
	public static $ovBotsFile;
	public static $ovSessionTime = 30*60; // time in seconds (30 minutes)
	
	function __construct(){
			global $addonPathData;
			self::$ovTemplateFile 	= $addonPathData.'/template.php';
			self::$ovVisitorsFile	= $addonPathData.'/visitor.php';
			self::$ovBotsFile		= $addonPathData.'/bot.php';
			$this->OnlineVisitor();
	}

	function DetectBot($AGENT){
		// botlist: http://www.blackhatworld.com/blackhat-seo/black-hat-seo/335475-complete-spiders-crawlers-bots-control-script-redirect-where-you-want.html
		$botList = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi","looksmart",
			"URL_Spider_SQL", "Firefly", "NationalDirectory","Ask Jeeves", "TECNOSEEK",
			"InfoSeek", "WebFindBot", "girafabot", "crawler", "www.galaxy.com", "Googlebot",
			"Scooter", "Slurp","msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
			"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot","Mediapartners-Google",
			"Sogou web spider", "WordPress", "WordPress/3.1;", "WordPress/3.1", "WebAlta Crawler",
			"ABCdatos BotLink", "Acme.Spider", "Ahoy! The Homepage Finder", "Alkaline", "Anthill",
			"Walhello appie", "Arachnophilia", "Arale", "Araneo", "AraybOt", "ArchitextSpider",
			"Aretha", "ARIADNE", "arks", "AskJeeves","ATN Worldwide", "Atomz.com Search Robot",
			"AURESYS", "BackRub", "Bay Spider", "Big Brother", "Bjaaland", "BlackWidow",
			"Die Blinde Kuh", "Bloodhound", "Borg-Bot", "BoxSeaBot", "bright.net caching robot",
			"BSpider", "CACTVS Chemistry Spider", "Calif", "Cassandra", "Digimarc Marcspider/CGI",
			"Checkbot", "ChristCrawler.com", "churl", "cIeNcIaFiCcIoN.nEt", "CMC/0.01", "Collective",
			"Combine System", "Conceptbot", "ConfuzzledBot", "CoolBot", "Web Core / Roots",
			"XYLEME Robot", "Internet Cruiser Robot", "Cusco", "CyberSpyder Link Test", "CydralSpider",
			"Desert Realm Spider", "DeWeb(c) Katalog/Index", "DienstSpider", "Digger",
			"Digital Integrity Robot", "Direct Hit Grabber", "DNAbot", "DownLoad Express",
			"DragonBot", "DWCP (Dridus' Web Cataloging Project)", "e-collector", "EbiNess",
			"EIT Link Verifier Robot", "ELFINBOT", "Emacs-w3 Search Engine", "ananzi", "esculapio",
			"Esther", "Evliya Celebi", "FastCrawler", "Fluid Dynamics Search Engine robot",
			"Felix IDE", "Wild Ferret Web Hopper #1, #2, #3", "FetchRover", "fido", "Hämähäkki",
			"KIT-Fireball", "Fish search", "Fouineur", "Robot Francoroute", "Freecrawl", "FunnelWeb",
			"gammaSpider, FocusedCrawler", "gazz", "GCreep", "GetBot", "GetURL", "Golem",
			"Grapnel/0.01 Experiment", "Griffon", "Gromit", "Northern Light Gulliver", "Gulper Bot",
			"HamBot", "Harvest", "havIndex", "HI (HTML Index) Search", "Hometown Spider Pro",
			"ht://Dig", "HTMLgobble", "Hyper-Decontextualizer", "iajaBot", "IBM_Planetwide",
			"Popular Iconoclast", "Ingrid", "Imagelock", "IncyWincy", "Informant", "InfoSeek Robot 1.0",
			"Infoseek Sidewinder", "InfoSpiders", "Inspector Web", "IntelliAgent", "I, Robot", "Iron33",
			"Israeli-search", "JavaBee", "JBot Java Web Robot", "JCrawler", "Jeeves", "JoBo Java Web Robot",
			"Jobot", "JoeBot", "The Jubii Indexing Robot", "JumpStation", "image.kapsi.net", "Katipo",
			"KDD-Explorer", "Kilroy", "KO_Yappo_Robot", "LabelGrabber", "larbin", "legs", "Link Validator",
			"LinkScan", "LinkWalker", "Lockon", "logo.gif Crawler", "Lycos", "Mac WWWWorm", "Magpie",
			"marvin/infoseek", "Mattie", "MediaFox", "MerzScope", "NEC-MeshExplorer", "MindCrawler",
			"mnoGoSearch search engine software", "moget", "MOMspider", "Monster", "Motor", "MSNBot",
			"Muncher", "Muninn", "Muscat Ferret", "Mwd.Search", "Internet Shinchakubin", "NDSpider",
			"Nederland.zoek", "NetCarta WebMap Engine", "NetMechanic", "NetScoop", "newscan-online",
			"NHSE Web Forager", "Nomad", "The NorthStar Robot", "nzexplorer", "ObjectsSearch", "Occam",
			"HKU WWW Octopus", "OntoSpider", "Openfind data gatherer", "Orb Search", "Pack Rat", "PageBoy",
			"ParaSite", "Patric", "pegasus", "The Peregrinator", "PerlCrawler 1.0", "Phantom", "PhpDig",
			"PiltdownMan", "Pimptrain.com's robot", "Pioneer", "html_analyzer", "Portal Juice Spider",
			"PGP Key Agent", "PlumtreeWebAccessor", "Poppi", "PortalB Spider", "psbot", "GetterroboPlus Puu",
			"The Python Robot", "Raven Search", "RBSE Spider", "Resume Robot", "RoadHouse Crawling System",
			"RixBot", "Road Runner: The ImageScape Robot", "Robbie the Robot", "ComputingSite Robi/1.0",
			"RoboCrawl Spider", "RoboFox", "Robozilla", "Roverbot", "RuLeS", "SafetyNet Robot", "Scooter",
			"Sleek", "Search.Aus-AU.COM", "SearchProcess", "Senrigan", "SG-Scout", "ShagSeeker", "Shai'Hulud",
			"Sift", "Simmany Robot Ver1.0", "Site Valet", "Open Text Index Robot", "SiteTech-Rover",
			"Skymob.com", "SLCrawler", "Inktomi Slurp", "Smart Spider", "Snooper", "Solbot", "Spanner",
			"Speedy Spider", "spider_monkey", "SpiderBot", "Spiderline Crawler", "SpiderMan", "SpiderView(tm)",
			"Spry Wizard Robot", "Site Searcher", "Suke", "suntek search engine", "Sven", "Sygol",
			"TACH Black Widow", "Tarantula", "tarspider", "Tcl W3 Robot", "TechBOT", "Templeton",
			"TeomaTechnologies", "TITAN", "TitIn", "The TkWWW Robot", "TLSpider", "UCSD Crawl",
			"UdmSearch", "UptimeBot", "URL Check", "URL Spider Pro", "Valkyrie", "Verticrawl",
			"Victoria", "vision-search", "void-bot", "Voyager", "VWbot", "The NWI Robot", "W3M2",
			"WallPaper (alias crawlpaper)", "the World Wide Web Wanderer", "w@pSpider by wap4.com",
			"WebBandit Web Spider", "WebCatcher", "WebCopy", "webfetcher", "The Webfoot Robot", "Webinator",
			"weblayers", "WebLinker", "WebMirror", "The Web Moose", "WebQuest", "Digimarc MarcSpider",
			"WebReaper", "webs", "Websnarf", "WebSpider", "WebVac", "webwalk", "WebWalker", "WebWatch",
			"Wget", "whatUseek Winona", "WhoWhere Robot", "Wired Digital", "Weblog Monitor", "w3mir",
			"WebStolperer", "The Web Wombat", "The World Wide Web Worm", "WWWC Ver 0.2.5", "WebZinger",
			"XGET", "Jakarta Commons-HttpClient/3.0", "Moreoverbot/5.1", "Faceboot");
		foreach( $botList as $bot ) {
			if( strpos($bot, $AGENT) ){ return $bot; }
		}
		return false;
	}
	
	function OldVersion(){
		global $config;
		if( isset($config['customlang']['%d Visitors and %d robots online currently']) ){
			$string = $config['customlang']['%d Visitors and %d robots online currently'];
			$string = preg_replace('/%d/', '{visitors}', $string, 1);
			$string = preg_replace('/%d/', '{bots}',     $string, 1);
		}else{
			$string = '{visitors} Visitors and {bots} robots online currently';
		}
		$ovTemplateHTML = array('html'=>'<div class="online_visitor">'.$string.'</div>');
		gpFiles::SaveData(self::$ovTemplateFile, 'ovTemplateHTML', $ovTemplateHTML);
		return $ovTemplateHTML;
	}

	function OnlineVisitor(){
		global $langmessage;
		$visitorArray	= array();
		$botArray		= array();
		$visitorsCount	= 0;
		$botCount		= 0;
		$currentTime	= time();
		$visitorIP		= $_SERVER['REMOTE_ADDR'];

		if( file_exists(self::$ovTemplateFile) ){
			$ovTemplateHTML = gpFiles::Get(self::$ovTemplateFile,'ovTemplateHTML');
		}else {
			$ovTemplateHTML = $this->OldVersion();
		}
		if( file_exists($ovVisitorsFile) ){
			$visitorArray = gpFiles::Get(self::$ovVisitorsFile,'visitorArray');
		}
		if( file_exists($ovBotsFile) ){
			$botArray = gpFiles::Get(self::$ovBotsFile,'botArray');
		}
		if( $this->DetectBot($_SERVER['HTTP_USER_AGENT']) ){
			foreach( $botArray as $ip => $lastTime ){
				if( ($currentTime - $lastTime) >= self::$ovSessionTime ){ unset($botArray[$ip]); }
			}
			$botArray[$visitorIP] = $currentTime;
			gpFiles::SaveArray(self::$ovBotsFile, 'botArray', $botArray);
			$botCount = count($botArray);
		}else{
			foreach( $visitorArray as $ip => $lastTime ){
				if( ($currentTime - $lastTime) >= self::$ovSessionTime ){ unset($visitorArray[$ip]); }
			}
			$visitorArray[$visitorIP] = $currentTime;
			gpFiles::SaveArray(self::$ovVisitorsFile, 'visitorArray', $visitorArray);
			$visitorCount = count($visitorArray);
		}
		$ovHTML = str_replace(array('{visitors}','{bots}'), array($visitorCount, $botCount), $ovTemplateHTML['html']);
		echo $ovHTML;
	}
}
