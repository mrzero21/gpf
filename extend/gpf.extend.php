<?
/**
 * 
 * 그누보드용 확장 스크립트
 *
 * @license http://byfun.com
 * @author	byfun (http://byfun.com)
 * @filesource
 */

define("GPF", "Gnuboard Plugin Framework");
define("GPF_VERSION", 20130406);

# G4와 G4S 플러그인 개발시 호환을 위해 G4S와 같이 매크로 선언
define("G4_PATH", $g4['path']);
define("G4_URL", $g4['url']);

define('G4_ADMIN_DIR', $g4['admin']);
define('G4_BBS_DIR', $g4['bbs']);
define('G4_DATA_DIR', 'data');
define('G4_EXTEND_DIR', 'extend');
define('G4_LIB_DIR', 'lib');
define('G4_SKIN_DIR', 'skin');

define('G4_SERVER_TIME', $g4['server_time']);
define('G4_TIME_YMDHIS', $g4['time_ymdhis']);
define('G4_TIME_YMD', $g4['time_ymd']);
define('G4_TIME_HIS', $g4['time_his']);


define('G4_ADMIN_URL', G4_URL.'/'.G4_ADMIN_DIR);
define('G4_BBS_URL', G4_URL.'/'.G4_BBS_DIR);
define('G4_DATA_URL', G4_URL.'/'.G4_DATA_DIR);
define('G4_SKIN_URL', G4_URL.'/'.G4_SKIN_DIR);

define('G4_ADMIN_PATH', G4_PATH.'/'.G4_ADMIN_DIR);
define('G4_BBS_PATH', G4_PATH.'/'.G4_BBS_DIR);
define('G4_DATA_PATH', G4_PATH.'/'.G4_DATA_DIR);
define('G4_LIB_PATH', G4_PATH.'/'.G4_LIB_DIR);
define('G4_SKIN_PATH', G4_PATH.'/'.G4_SKIN_DIR);

define('G4_MYSQL_HOST', $mysql_host);
define('G4_MYSQL_USER', $mysql_user);
define('G4_MYSQL_PASSWORD', $mysql_password);
define('G4_MYSQL_DB', $mysql_db);

define('G4_TABLE_PREFIX', $g4['table_prefix']);

# GPF 매크로
define("GPF_PATH", G4_PATH."/gpf");
define("GPF_URL", G4_URL."/gpf");

define("GPF_ADMIN_PATH", G4_ADMIN_PATH."/gpf");
define("GPF_ADMIN_URL", G4_ADMIN_URL."/gpf");

define("GPF_SKIN_PATH", $board_skin_path);
define("GPF_SKIN_URL", G4_URL."/skin/board/".basename($board_skin_path));

define("GPF_INC_SKIN_PATH", GPF_PATH."/inc/skin");
define("GPF_INC_SKIN_URL", GPF_URL."/inc/skin");

define("GPF_INTERCEPT_SKIN", ".gpf");
define("GPF_PRE_EVENT_PREFIX", "PRE_");
define("GPF_POST_EVENT_PREFIX", "POST_");


if(!defined("NO_GPF")) 
{
	// <g4>/bbs 에서 include 할때만 board_skin_path 를 intercept 함
	if(getcwd() == realpath($g4['bbs_path']) && !defined("NO_GPF_SKIN_INTERCEPT") )
	{
		$board_skin_path = GPF_INC_SKIN_PATH;
	}

	// 관리자 페이지에서는 인터셉트 하지 않음
	if(!file_exists(getcwd() . "/admin.lib.php")) {

		define("GPF_MEMBER_SKIN", $config['cf_member_skin']);	// 회원 스킨 인터셉트를 위해
		define("GPF_MEMBER_SKIN_PATH", G4_PATH."/skin/member/".GPF_MEMBER_SKIN);
		define("GPF_MEMBER_SKIN_URL", G4_URL."/skin/member/".GPF_MEMBER_SKIN);
		$config['cf_member_skin'] = GPF_INTERCEPT_SKIN;


		define("GPF_SEARCH_SKIN", $config['cf_search_skin']);	// 검색 스킨 인터셉트를 위해
		define("GPF_SEARCH_SKIN_PATH", G4_PATH."/skin/search/".GPF_MEMBER_SKIN);
		define("GPF_SEARCH_SKIN_URL", G4_URL."/skin/search/".GPF_MEMBER_SKIN);
		$config['cf_search_skin'] = GPF_INTERCEPT_SKIN;
	}
}

include_once $g4['path'] . "/gpf/gpf.php";

?>
