<?
/**
 * 
 * 플러그인 제거 실행
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "w");

if(!isset($p)) alert("잘못된 접근");

$info = $gpf->readPluginInfo($p);
$info->uninstall();

$use_plugins = $gpf->getActivatedPlugins();

$exists = false;
foreach($use_plugins as $idx=>$pid)
{
	if($pid == $p)
	{
		if(!$use) 
		{
			unset($use_plugins[$idx]);
			$obj = $gpf->readPlugin($p);
			$obj->loadPluginInfo();
			if($obj) {
				$obj->info->onDeactivated();	
			}
		}
		$exists = true;
	}
}

$use_plugins = array_values($use_plugins);

$gpf->cfg->update("/activated_plugins", $use_plugins);


goto_url($g4['admin_path']."/gpf/plugins.php");

?>
