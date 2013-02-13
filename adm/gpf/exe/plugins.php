<?
/**
 * 
 * 플러그인 관리 실행 스크립트
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("_common.php");

if($md == "update_use" && $p ) {

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

	if($use && !$exists)
	{
		array_push($use_plugins, $p);
		$obj = $gpf->readPlugin($p);
		$obj->loadPluginInfo();
		$obj->info->onActivated();	
	}

	$use_plugins = array_values($use_plugins);

 	$data_path = GPF_PATH."/data/plugins/".$p;
	@mkdir($data_path, 0707);
	@chmod($data_path, 0707);

	$gpf->cfg->update("/activated_plugins", $use_plugins);
	
	gpf_trigger("ACTIVATED_PLUGIN_CHANGED");

	include_once GPF_PATH."/lib/gpf.JSCSS.class.php";
	$gpfjc = new GPFJsCss();
	$gpfjc->updateCss();
	$gpfjc->updateJs();

	die ( json_encode(array('code'=>1, 'use'=>$use, 'plugin_id'=>$p)) );
}


if($md == "sort" && $gpf_plugins)
{
	$orders = array();
	foreach($gpf_plugins as $idx => $p) $orders[$p] = $idx+1;

	$gpf->cfg->update("/plugin_order", $orders);

	gpf_trigger("PLUGIN_ORDER_CHANGED");

	die( json_encode(array('code'=>1, 'msg'=>'Success')) );
}

die( json_encode(array('code'=>-1, 'msg'=>'Bad Request')) );
?>


