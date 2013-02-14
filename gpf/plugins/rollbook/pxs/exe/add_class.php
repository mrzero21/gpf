<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$group_id || !$class_name) alert('데이터 오류');

$ex_class = sql_fetch("SELECT * FROM {$rb['class_table']} WHERE group_id = {$group_id} AND name = '{$class_name}' ");
if(!empty($ex_class)) {
	alert("이미 존재하는 클래스입니다. : " . $ex_class['name']);
	exit;
}

sql_query("INSERT INTO {$rb['class_table']} SET name = '$class_name', group_id = $group_id");
goto_url(gpf_rb_url('index'));
?>
