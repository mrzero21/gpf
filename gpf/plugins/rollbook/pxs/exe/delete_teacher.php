<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$rb_class || !$tid) alert('데이터 오류');

sql_query("DELETE FROM {$rb['teacher_table']} WHERE id = $tid");
goto_url(gpf_rb_url('teacher')."&rb_class=".$rb_class);
?>
