<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if(!$rb_group) alert("존재하지 않는 그룹입니다.");

$res = sql_query("SELECT cl.id AS class_id, cl.name AS class_name 
											 FROM {$rb['class_table']} AS cl
											 WHERE cl.group_id = $rb_group");								
$wh = "class_id in ( ";
$classes = array();
while($row = sql_fetch_array($res))
{
	$wh .= " {$row['class_id']}, ";
	array_push($classes, $row);
}
$wh .= " 0)";

if(empty($classes)) rb_alert("그룹내에 클래스가 없습니다.");


$teachers = sql_list("SELECT * FROM {$rb['teacher_table']} WHERE $wh ORDER BY name");

// load student information and sort it
$tmp = sql_list("SELECT * FROM {$rb['student_table']} WHERE $wh ORDER BY name");

$arr = array();
foreach($tmp as $k=>$st) {
	$key = array_search($st['grade'], $rb['grade']);
	if(!$arr[$key]) $arr[$key] = array();
	array_push($arr[$key], $st);
}

$students = array();
for($i=0; $i<count($rb['grade']); $i++) {
	if(is_array($arr[$i])) {
		$students = array_merge($students, $arr[$i]);
	}
}
unset($arr);
unset($tmp);

$dates = sql_list("SELECT date FROM {$rb['rollbook_table']} WHERE $wh GROUP BY date ORDER BY date");

$result = sql_query("SELECT rb.date, ct.student_id, ct.stat FROM {$rb['rollbook_table']} AS rb LEFT JOIN {$rb['check_table']} AS ct ON ct.rollbook_id = rb.id LEFT JOIN {$rb['student_table']} AS st ON st.id = ct.student_id WHERE rb.{$wh} ");	

$book = array();
while($row = sql_fetch_array($result)) {
	$sid = $row['student_id'];
	$date = $row['date'];
	if($row['stat'] == "O") $book[$sid][$date] = 1;
	else if($row['stat'] == "X") $book[$sid][$date] = -1;
	else $book[$sid][$date] = 0;	
}


$date_count = count($dates);
$student_count = count($students);

foreach($students as $idx=>$student)
{
	$sub_total = 0;
	if(!empty($book[$student['id']])) {
		foreach($book[$student['id']] as $item)
		{
			if($item == 1) $sub_total++;
		}
	}

	$students[$idx]['total_attend'] = $sub_total;
}

$year_count = array();
$month_count = array();
for($i=0; $i<$date_count; $i++) {
	$d = $dates[$i]['date'];
	$y = substr($d, 0, 4);
	$m = substr($d, 0, 7);
	$year_count[$y]++;
	$month_count[$m]++;
}



if($ord == 'name,asc') $students = rb_ass_rsort($students, 'name');
else if($ord == 'name,desc') $students = rb_ass_sort($students, 'name');
else if($ord == 'attend,asc') $students = rb_ass_rsort($students, 'total_attend');
else if($ord == 'attend,desc') $students = rb_ass_sort($students, 'total_attend');
else if($ord == 'grade,desc') $students = rb_ass_sort($students, 'grade');
else if($ord == 'grade,asc') $students = rb_ass_rsort($students, 'grade');

$table = array();
$total = array();
$quota = array();
for($c=0; $c<$date_count; $c++) {
	$sub_total = 0;
	$quota[$c] = $student_count;
	for($r=0; $r<$student_count; $r++) {
		$table[$c][$r] = $book[$students[$r]['id']][$dates[$c]['date']];
		if($table[$c][$r] == 1) $sub_total++;
		if(!$table[$c][$r]) {
			$table[$c][$r] = 0;
			$quota[$c]--;
		}
	}
	$total[$c] = $sub_total;
}

include_once $rb['skin_path']."/group.skin.php";


function rb_ass_rsort($a,$subkey) {
	if(empty($a) || !is_array($a)) return $a;
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

function rb_ass_sort($a,$subkey) {
	if(empty($a) || !is_array($a)) return $a;
	$c = rb_ass_rsort($a, $subkey);
	$c = array_reverse($c);
	return $c;
}
?>
