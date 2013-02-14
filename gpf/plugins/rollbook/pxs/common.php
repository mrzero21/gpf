<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */

$rb = gpf_get_option('/rollbook_config');
if(!$rb) alert('출석부를 설치후 사용하세요');

$rb['db_prefix'] = $rb['db_prefix'].'rb_';
$rb['group_table'] = $rb['db_prefix'] . 'group';
$rb['class_table'] = $rb['db_prefix'] . 'class';
$rb['rollbook_table'] = $rb['db_prefix'] . 'rollbook';
$rb['student_table'] = $rb['db_prefix'] . 'student';
$rb['teacher_table'] = $rb['db_prefix'] . 'teacher';
$rb['check_table'] = $rb['db_prefix'] . 'checked';

$rb['path'] = $plugin_path."/pxs";
$rb['backup_dir'] = $rb['path'] . '/backups';
$rb['skin_path'] = $rb['path'].'/skin/'.$rb['skin'];

$is_teacher = $member['mb_level'] >= $rb['teacher_level'];

if($member['mb_level'] < $rb['read_level']) 
{
	alert("출석부 열람 권한이 없습니다. ({$member['mb_level']} < {$rb['read_level']})");
}

$GLOBALS['rb'] = $rb;




function sql_list($sql) {	
	$result = sql_query($sql);
	$list = array();	
	while ($row = sql_fetch_array($result))
	{	
		array_push($list, $row);
	}
	return $list;		
}

function trim_array(&$arr) {
	foreach($arr as $k=>$v) {
		if(is_array($v)) trim_array($arr[$k]);
		else $arr[$k] = stripcslashes(trim($v));
	}
}


function rb_backups($rb_class) {
	global $rb;
	$backups = array();
	$filelist = glob($rb['backup_dir']."/".$rb_class."_*");
	foreach($filelist as $file) {
		$filename = basename($file);
		$tmp = explode("_", $filename);	
		array_push($backups, array('file'=>$filename, 'date'=>date("Y-m-d h:i:s", $tmp[1])));
	}
	unset($filelist);	
	return $backups;
}
?>
