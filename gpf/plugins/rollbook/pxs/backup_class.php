<?
/**
 * ���α׷��� : ��ȸ �⼮��
 * ������ : ���Ѹ� (chongmyung.park@gmail.com)
 * �� ���α׷��� ������ ������� ���մϴ�.
 */
if(!defined("__RB__")) die("�߸��� �����Դϴ�.");

if(!$rb_class) rb_alert("�������� �ʴ� Ŭ�����Դϴ�.");

$class = sql_fetch("SELECT cl.name AS class_name 
											 FROM {$rb['class_table']} AS cl
											 WHERE cl.id = $rb_class
											 ");								
											 			 
if(!$class) rb_alert("�������� �ʴ� Ŭ�����Դϴ�.");
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
