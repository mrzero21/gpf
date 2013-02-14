<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
 

if(!$is_teacher) {
	echo json_encode(array("code"=>-1, "msg"=>"권한 없음"));								
	exit;
}

if(!$cid || !$date || !$sid || !$stat) {
	echo json_encode(array("code"=>-1, "msg"=>"데이터 오류"));								
	exit;
}

$book = sql_fetch("SELECT * FROM {$rb['rollbook_table']} WHERE class_id = $cid AND date = '$date'");
if(!$book) {
	echo json_encode(array("code"=>-1, "msg"=>"존재하지 않는 출석부"));								
	exit;	
}

$bid = $book['id'];

$enum_stat = array("1"=>"O", "-1"=>"X");

if($stat == "1" || $stat == "-1") {
	sql_query("DELETE FROM {$rb['check_table']} WHERE class_id = $cid AND rollbook_id = $bid AND student_id = $sid");
	sql_query("INSERT INTO {$rb['check_table']} 
						SET class_id = $cid, 
								rollbook_id = $bid,
								student_id = $sid,
								stat = '{$enum_stat[$stat]}'");
	echo json_encode(array("code"=>1, "sid"=>$sid, "date"=>$date, "date_n"=>str_replace("-", "", $date), "stat"=>$stat));								
	exit;
}

if($stat == "100") {
	sql_query("DELETE FROM {$rb['check_table']} WHERE class_id = $cid AND rollbook_id = $bid AND student_id = $sid");
	echo json_encode(array("code"=>1, "sid"=>$sid, "date"=>$date, "date_n"=>str_replace("-", "", $date), "stat"=>0));
	exit;
}


echo json_encode(array("code"=>-1, "msg"=>"알수없는 오류"));

?>
