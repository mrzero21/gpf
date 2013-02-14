<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
include_once("_common.php");

if($md != 'doit') die('-1');

sql_query("DROP TABLE {$rb['group_table']}");
sql_query("DROP TABLE {$rb['class_table']}");
sql_query("DROP TABLE {$rb['rollbook_table']}");
sql_query("DROP TABLE {$rb['student_table']}");
sql_query("DROP TABLE {$rb['teacher_table']}");
sql_query("DROP TABLE {$rb['check_table']}");


remove_files($rb['backup_dir']);

@unlink($rb['path']."/rollbook.config.php");

echo "0";

function remove_files($dir)
{
	$handle = opendir($dir);
	while ($file = readdir($handle))
	{
		if($file{0} == ".") continue;
		if (is_dir($dir."/".$file)) remove_files($dir."/".$file);
		else @unlink($dir."/".$file);
	}
	closedir($handle);
}

?>
