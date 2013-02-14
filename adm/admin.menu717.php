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
	$admin_cnt = 0;
	for($i=0, $to=count($gpf_admins); $i<$to; $i++, $admin_cnt++)
	{
		$v = $gpf_admins[$i];
		$prev = $gpf_admins[$i-1];
		$next = $gpf_admins[$i+1];
		
		array_push($menu["menu717"], array("", $v['label'], "{$g4['admin_path']}/gpf/admin.php?p=".$v['obj']->id."&c=".$v['id']));
	
		if( ($admin_cnt > 3 && $prev['obj']->id != $v['obj']->id && $next && $v['obj']->id != $next['obj']->id) || ($next && $v['obj']->id != $next['obj']->id && gpf_same_admin_count($gpf_admins, $i+1) >= 3) ) 
		{
			array_push($menu["menu717"], array("-"));
			$admin_cnt = 0;
		}
	}
	array_push($menu["menu717"], array("-"));
}

function gpf_same_admin_count($gpf_admins, $from)
{
	if(!$gpf_admins[$from]) return 0;
	$id = $gpf_admins[$from]['obj']->id;
	$same_count = 1;
	for($i=$from+1, $to=count($gpf_admins); $i<$to; $i++)
	{
		if($id == $gpf_admins[$i]['obj']->id) $same_count++;
		else break;
	}
	return $same_count;
}

?>