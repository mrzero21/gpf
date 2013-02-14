<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');
if(!$group_name) alert('데이터 오류');


$ex_group = sql_fetch("SELECT * FROM {$rb['group_table']} WHERE name = '$group_name'");
if($ex_group) {
	alert("이미 존재하는 그룹입니다.");
}

sql_query("INSERT INTO {$rb['group_table']} SET name = '$group_name'");

goto_url(gpf_rb_url('index'));
?>
