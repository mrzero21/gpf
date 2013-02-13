<?
/**
 * 
 * 플러그인의 환경 설정 기능 실행
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if(!isset($p)) alert("잘못된 접근");

$info = $gpf->readPluginInfo($p);
if(!$info) {
	alert("잘못된 접근");
}

$g4['title'] = "플러그인설정 - " . $info->id;

$cfg = GPFConfig::getInstance();
$active_plugins = $cfg->activated_plugins;
$activated = false;
foreach($active_plugins as $plugin)
{
	if($p == $plugin) $activated = true;
}

if(!$activated) alert('플러그인을 활성화 후 설정할 수 있습니다.');

include_once("./gpf.head.php");
?>
<h2>GPF : <?=$info->label?> 설정</h2>
<?
$info->setup();

include_once("./gpf.tail.php");
?>
