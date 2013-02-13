<?
/**
 * 
 * ajax 를 이용한 get 에 대한 응답
 *
 * @author	chongmyung.park (http://byfun.com)
 */


include_once("_common.php");

if($md == 'user_search' && $mb_info)
{
	$users = array();
	$res = sql_query("SELECT mb_id, mb_name FROM {$g4['member_table']} WHERE mb_name LIKE '%{$mb_info}%' OR mb_id LIKE '%{$mb_info}%'");
	while($row = sql_fetch_array($res))
	{
		array_push($users, $row);
	}

	die(json_encode(array('code'=>1, 'users'=>$users)));
}

if($md == 'user_info' && $mb_info)
{
	$row = sql_fetch("SELECT mb_id, mb_name FROM {$g4['member_table']} WHERE mb_id = '{$mb_info}'");
	die(json_encode(array('code'=>1, 'user'=>$row)));
}

if($md == 'board_info' && $btable)
{
	$row = sql_fetch("SELECT bo_table, bo_subject FROM {$g4['board_table']} WHERE bo_table = '{$btable}'");
	die(json_encode(array('code'=>1, 'board'=>$row)));
}

die(json_encode(array('code'=>-1, 'msg'=>'Bad Request')));

?>


