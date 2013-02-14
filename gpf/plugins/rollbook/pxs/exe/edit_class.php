<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$is_teacher) alert('권한 없음');

if(!$md || !$class_id) alert('데이터 오류');

$class = sql_fetch("SELECT * FROM {$rb['class_table']} WHERE id = $class_id");							

if(!$class) {
	alert("존재하지 않는 클래스입니다.");
	exit;		
}

if($md == "d") {
	if($rb_passwd != $rb['passwd']) {
		alert("비밀번호가 일치하지 않습니다.");
		exit;
	}
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

if($md == "backup") {
	$class_data = array();
	$class_data['teachers'] = sql_list("SELECT * FROM {$rb['teacher_table']} WHERE class_id = $class_id");
	$class_data['students'] = sql_list("SELECT * FROM {$rb['student_table']} WHERE class_id = $class_id");	
	$class_data['rollbooks'] = sql_list("SELECT * FROM {$rb['rollbook_table']} WHERE class_id = $class_id");	
	$class_data['checked_lists'] = sql_list("SELECT * FROM {$rb['check_table']} WHERE class_id = $class_id");		
	$backup_file = $rb['backup_dir']."/".$class_id . "_" . time();
	$fp = fopen($backup_file, "w");
	fwrite($fp, serialize($class_data));
	fclose($fp);	
	goto_url(gpf_rb_url('backup_class')."&rb_class=".$class_id);
	exit;
}

if($md == "backup_restore" && $file) {
	$content = file_get_contents($rb['backup_dir']."/".$file);
	$class_data = unserialize($content);

	if(!isset($class_data['teachers']) || !isset($class_data['students']) || !isset($class_data['rollbooks']) || !isset($class_data['checked_lists'])) {
		alert("잘못된 백업파일입니다.");
	}

	sql_query("DELETE FROM {$rb['rollbook_table']} WHERE class_id = $class_id");
	sql_query("DELETE FROM {$rb['student_table']} WHERE class_id = $class_id");
	sql_query("DELETE FROM {$rb['teacher_table']} WHERE class_id = $class_id");
	sql_query("DELETE FROM {$rb['check_table']} WHERE class_id = $class_id");

	foreach($class_data['teachers']	as $row) sql_query(rb_insert_sql($rb['teacher_table'], $row));
	foreach($class_data['students']	as $row) sql_query(rb_insert_sql($rb['student_table'], $row));
	foreach($class_data['rollbooks']	as $row) sql_query(rb_insert_sql($rb['rollbook_table'], $row));
	foreach($class_data['checked_lists']	as $row) sql_query(rb_insert_sql($rb['check_table'], $row));
	
	goto_url(gpf_rb_url('class')."&rb_class=".$class_id);
	exit;
}

if($md == "backup_delete" && $file) {
	@unlink($rb['backup_dir']."/".$file);
	@unlink($rb['backup_dir']."/memo/".$file);
	goto_url(gpf_rb_url('backup_class')."&rb_class=".$class_id);
	exit;
}

if($md == "backup_memo" && $file && $memo) {
	$memo = stripcslashes($memo);
	$memo_file = $rb['backup_dir'].'/memo/' . $file;
	$fp = fopen($memo_file, "w");
	fwrite($fp, stripcslashes($memo));
	fclose($fp);
	if(file_get_contents($memo_file) == $memo) {
		echo json_encode(array('code'=>1, 'memo'=>$memo));
	}	else {
		echo json_encode(array('code'=>-1, 'msg'=>'업데이트 실패'));
	}
	
	exit;
}

if($md == "u" && $class_name) {
	sql_query("UPDATE {$rb['class_table']} 
						 SET name = '$class_name' WHERE id = $class_id
				    ");
}

if($md == "cp" && $class_name && $gr_id) {

	$ex_class = sql_fetch("SELECT * FROM {$rb['class_table']} WHERE group_id = {$gr_id} AND name = '{$class_name}' ");
	if(!empty($ex_class)) {
		alert("이미 존재하는 클래스입니다. : " . $class_name);
		exit;
	}
	
	sql_query("INSERT INTO {$rb['class_table']} SET name = '$class_name', group_id = {$gr_id}");
	$new_class_id = mysql_insert_id();
	
	$students = sql_list("SELECT * FROM {$rb['student_table']} WHERE class_id = $class_id ORDER BY name");
	foreach($students as $k=>$student) {
		sql_query("INSERT INTO {$rb['student_table']} 
							SET name = '{$student['name']}', 
							    class_id = $new_class_id, 
									sex = '{$student['sex']}', 
									school = '{$student['school']}', 
									grade = '{$student['grade']}'");
	}
	
	$teachers = sql_list("SELECT * FROM {$rb['teacher_table']} WHERE class_id = $class_id");	
	foreach($teachers as $k=>$teacher) {
		sql_query("INSERT INTO {$rb['teacher_table']} SET name = '{$teacher['name']}', class_id = $new_class_id");
	}
		
}

goto_url(gpf_rb_url('index'));



function rb_insert_sql($table, $row) {
	
	$keys = array_keys($row);
	$sql = "INSERT INTO $table SET ";
	for($i=0; $i<count($keys); $i++) {
		$k = $keys[$i];
		$sql .= " {$k} = '{$row[$k]}'";
		if($i<count($keys)-1) $sql .= ", ";
	}
	return $sql;
}
?>
