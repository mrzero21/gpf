<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$member = $g['member'];
$is_admin = $g['is_admin'];
$type = $g['type'];
$contents = stripslashes($g['contents']);
$tpl_path = GPF_PATH."/data/plugins/widget/".$type.".txt";

if(!$is_admin) die( json_encode(array('code'=>-1, 'msg'=>'잘못된 접근입니다 : ' . $type)) );

if ($member['mb_password'] != sql_password($_POST['admin_password'])) {
	die( json_encode(array('code'=>-1, 'msg'=>'패스워드가 다릅니다.')) );
}

$fp = fopen($tpl_path, "w");
fwrite($fp, $contents);
fclose($fp);

die( json_encode(array('code'=>1, 'msg'=>'업데이트 완료')) );

?>
