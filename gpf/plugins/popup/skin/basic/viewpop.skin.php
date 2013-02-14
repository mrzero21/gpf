<?
include_once("$g4[path]/head.sub.php");
$g4['popup_table'] = $g4['table_prefix'] . "topschool_popup"; // 팝업창 관리 테이블
$sql = "select * from $g4[popup_table] where po_id = '$po_id'";
$rs = sql_fetch($sql);
?>

<table cellpadding="0" cellspacing="0" bgcolor="#edf2fc" width="100%" height="100%">
	<tr>
		<td>
		<table cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="100%" height="<?=$rs[po_height] - 20;?>">
			<tr>
				<td valign="top" style="padding:10px"><?=$rs[po_content];?></td>
			</tr>
		</table>
		<div style="width:100%;background:#000000;color:#FFFFFF;text-align:right;padding-right:5px;;font-size:12px;">
			<input type="checkbox" id="expirehours<?=$rs[po_id];?>" name="expirehours<?=$rs[po_id];?>" value="<?=$rs[po_expirehours];?>"><?=$rs[po_expirehours];?>시간 동안 이 창을 다시 열지 않음
			<a href="javascript:popup_close(<?=$rs[po_id];?>)"><img src="<?=$popup_skin_path?>/img/close.jpg" width="11" height="11" border="0"></a>
		</div>
		</td>
	</tr>
</table>
<?
include_once("$g4[path]/tail.sub.php");
?>
<script>
function popup_close(id) {
	var obj = document.getElementById("expirehours"+id);
	if (obj.checked == true) {
		set_cookie("it_ck_pop_"+id, "done", obj.value, window.location.host);
	}
	self.close();
}
</script>