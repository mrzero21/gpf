<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */

$result = sql_query("SELECT gr.id AS group_id, gr.name AS group_name, cl.name AS class_name, cl.id AS class_id FROM {$rb['group_table']} AS gr LEFT JOIN {$rb['class_table']} AS cl ON gr.id = cl.group_id ORDER BY gr.name DESC ");											 

$rb_groups = array();
while($row = sql_fetch_array($result)) {
	$gr_name = $row['group_name'];
	if(!is_array($rb_groups[$gr_name])) {
		$rb_groups[$gr_name]['group_id'] = $row['group_id'];
		$rb_groups[$gr_name]['classes'] = array();
	}
	if($row['class_name']) array_push($rb_groups[$gr_name]['classes'], $row);
}

include_once $rb['skin_path']."/index.skin.php";

?>
