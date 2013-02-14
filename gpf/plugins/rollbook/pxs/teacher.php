<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$rb_class) rb_alert("존재하지 않는 클래스입니다.");

$class = sql_fetch("SELECT cl.name AS class_name 
											 FROM {$rb['class_table']} AS cl
											 WHERE cl.id = $rb_class
											 ");								
											 			 
if(!$class) rb_alert("존재하지 않는 클래스입니다.");

$teachers = sql_list("SELECT * FROM {$rb['teacher_table']} 
											WHERE class_id = $rb_class");

include_once $rb['skin_path']."/teacher.skin.php";
?>
