<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$class_id || !$rollbook_date) alert('데이터 오류');

sql_query("INSERT INTO {$rb['rollbook_table']} SET class_id = $class_id, date = '$rollbook_date'");


if($rb['default_stat'] == 'O' || $rb['default_stat'] == 'X') {
	$rollbook_id = mysql_insert_id();
	
	$students = sql_list("SELECT id as sid FROM {$rb['student_table']} WHERE class_id = $class_id");
	
	foreach($students as $idx=>$student) {
		sql_query("INSERT INTO {$rb['check_table']} 
							SET class_id = $class_id, 
									rollbook_id = $rollbook_id,
									student_id = {$student['sid']},
									stat = '{$rb['default_stat']}'");
	}
}

goto_url(gpf_rb_url('class')."&rb_class=".$class_id);
?>
