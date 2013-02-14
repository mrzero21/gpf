<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$md || !$group_id) alert('데이터 오류');

if($md == "d") {
	
	if($rb_passwd != $rb['passwd']) {
		alert("비밀번호가 일치하지 않습니다.");
		exit;
	}	
	
	$classes = sql_list("SELECT * FROM {$rb['class_table']} WHERE group_id = $group_id");
	
	sql_query("DELETE FROM {$rb['group_table']} WHERE id = $group_id");
	
	foreach($classes as $k=>$class) {
		$class_id = $class['id'];
		sql_query("DELETE FROM {$rb['class_table']} WHERE id = $class_id");
		sql_query("DELETE FROM {$rb['rollbook_table']} WHERE class_id = $class_id");
		sql_query("DELETE FROM {$rb['student_table']} WHERE class_id = $class_id");
		sql_query("DELETE FROM {$rb['teacher_table']} WHERE class_id = $class_id");
		sql_query("DELETE FROM {$rb['check_table']} WHERE class_id = $class_id");
		$backups = rb_backups($class_id);
		if(!empty($backups)) {
			foreach($backups as $file) {
				@unlink($rb['backup_dir']."/".$file['file']);
				@unlink($rb['backup_dir']."/memo/".$file['file']);
			}
		}		
	}
}

if($md == "u" && $group_name) {
	sql_query("UPDATE {$rb['group_table']} 
						 SET name = '$group_name' WHERE id = $group_id
				    ");
}

goto_url(gpf_rb_url('index'));
?>
