<?
/**
 * 
 * 관리자 플러그인 실행
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if(!isset($p)) alert("잘못된 접근");

$plugin = null;
$admin_plugins = $gpf->getAdminPlugins();
foreach($admin_plugins as $idx => $pl)
{
	if($pl['obj']->id == $p)
	{
		$plugin = $pl;
	}
}

if(!$plugin) {
	alert("잘못된 접근");
}


$g4['title'] = "플러그인설정 - " . $plugin['label'];

$handler = $plugin['handler'];

gpf_trigger("GPF_ADMIN_HEAD");

include_once("./gpf.head.php");
?>

<h2><?=$plugin['label']?></h2>

<?=$plugin['obj']->$handler()?>

<?
include_once("./gpf.tail.php");

gpf_trigger("GPF_ADMIN_TAIL");
?>
