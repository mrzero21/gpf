<?
/**
 * 
 * 출석부 플러그인 정보
 *
 * 본 프로그램의 수정후 재배포를 금합니다.
 * @author	byfun (http://byfun.com)
 */
 
if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

define("__RB__", "ROLLBOOK");

class GPFPluginInfoRollbook extends GPFPluginInfo 
{	
	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();
		
		$this->version = "2013-01-18";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=rollbook";
		$this->label = "출석부";
	}


	/**
	 * 
	 * 플러그인 설명
	 * 
	 * @return string 플러그인설명
	 */
	public function getDescription()
	{
		$add = ( $this->shouldUninstall() ? "<br/>출석부 주소 : <a href=\"{$GLOBALS['g4']['url']}/gpf/px.php?m=rollbook\">{$GLOBALS['g4']['url']}/gpf/px.php?m=rollbook</a>" : "" );
		return "교회에서 사용할 목적으로 만든 출석부 프로그램입니다. $add";
	}

	/**
	 * 설치해야 하나 ?
	 */
	public function shouldInstall()
	{
		return ( gpf_get_option('/rollbook_config') == null );
	}

	/**
	 * 제거해야 하나 ?
	 */
	public function shouldUninstall()
	{
		return ( gpf_get_option('/rollbook_config') != null );
	}

	/**
	 * 설치하자
	 */
	public function install()
	{
		$rb_prefix = 'gpf_';
		$query =<<<EOF

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_checked` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `class_id` int(11) NOT NULL,
		  `rollbook_id` int(11) NOT NULL,
		  `student_id` int(11) NOT NULL,
		  `stat` enum('X','O') NOT NULL DEFAULT 'O',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_class` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `group_id` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_group` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) NOT NULL,
		  `archived` tinyint(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_rollbook` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `class_id` int(11) NOT NULL,
		  `date` date NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_student` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `class_id` int(11) NOT NULL COMMENT '클래스 아이디',
		  `name` varchar(255) NOT NULL COMMENT '이름',
		  `sex` enum('남','여') NOT NULL COMMENT '성별',
		  `school` varchar(128) NOT NULL COMMENT '학교명',
		  `grade` varchar(10) NOT NULL COMMENT '학년',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

		CREATE TABLE IF NOT EXISTS `{$rb_prefix}rb_teacher` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `class_id` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
			
			  
EOF;

		$f = explode(";", $query);
		for ($i=0; $i<count($f); $i++) {
			if (trim($f[$i]) == "") continue;
			sql_query($f[$i]);
		}

		$default_config = array(
			'passwd'=>'christ', 
			'title'=>'출석부', 
			'head'=>'head.php', 
			'tail'=>'tail.php', 
			'teacher_level'=>'9', 
			'read_level'=>'5', 
			'default_stat'=>'X', 
			'enum_stat'=>array("1"=>"■", "-1"=>"/", "0"=>"ㆍ"), 
			'grade'=>array('유', '초1', '초2', '초3', '초4', '초5', '초6', '중1', '중2', '중3', '고1', '고2', '고3', '대학', '청년', '중년', '장년', '새가족'),
			'skin'=>'basic',
			'db_prefix'=>$rb_prefix);
		gpf_set_option('/rollbook_config', $default_config);			

	}

	/**
	 * 제거하자
	 */
	public function uninstall()
	{
		$config = gpf_get_option('/rollbook_config');
		$rb_prefix = $config['db_prefix'];
		sql_query("DROP TABLE {$rb_prefix}rb_checked", false);
		sql_query("DROP TABLE {$rb_prefix}rb_class", false);
		sql_query("DROP TABLE {$rb_prefix}rb_group", false);
		sql_query("DROP TABLE {$rb_prefix}rb_rollbook", false);
		sql_query("DROP TABLE {$rb_prefix}rb_student", false);
		sql_query("DROP TABLE {$rb_prefix}rb_teacher", false);

		gpf_del_option('/rollbook_config');
	}
	
	/**
	 * 플러그인 설정이 필요한가?
	 */
	public function shouldSetup()
	{
		return true;
	}

	/**
	 * 플러그인 설정
	 */
	public function setup()
	{
		extract($GLOBALS);
		if(!$c) $c = 'index';

		$plugin_path = GPF_PATH."/plugins/".$this->id;
		$inc_file = $plugin_path."/pxs/adm/".basename($c).".php";
		if(!file_exists($inc_file)) gpf_die('Invalid access to rollbook plugin');
		
		include_once $plugin_path."/pxs/common.php";
		include_once $inc_file;
	}
}

function gpf_rb_adm_url($c) 
{
	return GPF_ADMIN_PATH."/plugin_setup.php?p=rollbook&c=".$c;
}
?>
