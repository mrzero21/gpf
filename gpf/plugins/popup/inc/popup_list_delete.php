<?
if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

$msg = "";
for ($i=0; $i<count($chk); $i++) 
{
    // 실제 번호를 넘김
    $k = $chk[$i];

	$row = sql_fetch(" select * from $g4[popup_table] where po_id = '$po_id[$k]' ");
	if (!$row[po_id]){ 
		$msg ="po_id 값이 제대로 넘어오지 않았습니다.";
    } else {
		sql_query(" delete from $g4[popup_table] where po_id = '$po_id[$k]' ");
    }
}

if ($msg)
    echo "<script type='text/JavaScript'> alert('$msg'); </script>";

goto_url("admin.php?p={$p}&c={$c}{$qstr}");
?>
