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
$backups = rb_backups($rb_class);
$memos = array();
foreach($backups as $backup) {
	$memo_file = $rb['backup_dir'].'/memo/'.$backup['file'];
	if(file_exists($memo_file)) {
		$tmp = file_get_contents($memo_file);			
		if($tmp) $memos[$backup['file']] = $tmp;
	}
}

include_once $rb['skin_path'].'/backup_class.skin.php';

?>
