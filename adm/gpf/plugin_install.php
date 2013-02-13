<?
/**
 * 
 * 플러그인 설치 실행
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if(!isset($p)) alert("잘못된 접근");

$info = $gpf->readPluginInfo($p);
$info->install();

goto_url($g4['admin_path']."/gpf/plugins.php");

?>
