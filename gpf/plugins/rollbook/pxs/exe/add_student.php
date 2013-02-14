<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$md || !$student_name || !$class_id) alert('데이터 오류');

if($md == "w") {
	sql_query("INSERT INTO {$rb['student_table']} 
						SET name = '$student_name', 
						    class_id = $class_id, 
								sex = '$student_sex', 
								school = '$student_school', 
								grade = '$student_grade'");
}

if($md == "u") {
	sql_query("UPDATE {$rb['student_table']} 
						 SET name = '$student_name', 
								 class_id = $class_id, 
								 sex = '$student_sex', 
								 school = '$student_school', 
								 grade = '$student_grade'
				    WHERE id = $student_id
				    ");
}

goto_url(gpf_rb_url('student')."&rb_class=".$class_id);
?>
