<?
$gpf_adm_menu = array();

$menu["menu717"] = array (
    array("717000", "GPF", "{$g4['admin_path']}/gpf/index.php"),
    array("", "대시보드", "{$g4['admin_path']}/gpf/index.php"),
    array("", "플러그인", "{$g4['admin_path']}/gpf/plugins.php"),
	array("-")
);

$gpf = GPF::getInstance();

if($gpf->hasAdminPlugins())
{
	$gpf_admins = $gpf->getAdminPlugins();
	foreach($gpf_admins as $k=>$v) 
	{
		array_push($menu["menu717"], array("", $v['label'], "{$g4['admin_path']}/gpf/admin.php?p=".$v['obj']->id));
	}
	array_push($menu["menu717"], array("-"));
}

?>