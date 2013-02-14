<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

$rb_group = sql_fetch("SELECT * FROM {$rb['group_table']} WHERE id = $rb_group");
if(!$rb_group) alert("존재하지 않는 그룹입니다");

include_once $rb['skin_path']."/edit_group.skin.php";

?>
