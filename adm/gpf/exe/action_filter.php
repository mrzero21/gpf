<?
/**
 * 
 * 액션 필터 업데이트
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("_common.php");

if($md != 'action_filter' || !$p) die('Bad Request');

$info = $gpf->readPluginInfo($p);

if(!$info) {
	alert("Bad Request");
}

$gpf_filters = array(
				'apply'=>array('user'=>$gpf_apply_users, 'board'=>$gpf_apply_boards),
				'except'=>array('user'=>$gpf_except_users, 'board'=>$gpf_except_boards)
				);


$plugin_data_path = GPF_PATH."/data/plugins/".$p;
if(!file_exists($plugin_data_path)) 
{
	@mkdir($plugin_data_path, 0707);
	@chmod($plugin_data_path, 0707);
}

$filter_code = "<? \$filter = \"".addslashes(serialize($gpf_filters))."\"; ?>";
$fp = fopen($plugin_data_path."/filter.php", "w");
fwrite($fp, $filter_code);
fclose($fp);

header("location:".GPF_ADMIN_PATH."/action_filter.php?p=$p");

?>


