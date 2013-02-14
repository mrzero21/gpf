<?
include_once("$g4[path]/head.sub.php");
?>

<table cellpadding="0" cellspacing="0" bgcolor="#edf2fc" width="100%" height="100%">
	<tr style="background: url('<?=$popup_skin_path?>/img/pop_l_t.gif') top repeat-x;">
		<td width="11" valign="top" height="11"><img src="<?=$popup_skin_path?>/img/pop_l_tl.gif"></td>
		<td></td>
		<td width="11" align="right" valign="top"><img src="<?=$popup_skin_path?>/img/pop_l_tr.gif"></td>
	</tr>
	<tr>
		<td style="background: url('<?=$popup_skin_path?>/img/pop_l_l.gif') left repeat-y;" height="11"></td>
		<td>
		<table cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="100%" height="<?=$rs[po_height] - 42;?>">
			<tr style="background: url('<?=$popup_skin_path?>/img/pop_w_bg.gif') top repeat-x;">
				<td width="7" height="7"><img src="<?=$popup_skin_path?>/img/pop_w_tl.gif"></td>
				<td></td>
				<td align="right"><img src="<?=$popup_skin_path?>/img/pop_w_tr.gif"></td>
			</tr>
			<tr>
				<td style="background: url('<?=$popup_skin_path?>/img/pop_w_bg.gif') left repeat-y;"></td>
				<td valign="top">
					<div style="color:#657db9;font-weight:bold;border-bottom:1px #cccccc solid;margin:10px;height:30px"><?=$rs[po_subject];?></div>
					<div style="margin:10px;"><?=$rs[po_content];?></div>
				</td>
				<td style="background: url('<?=$popup_skin_path?>/img/pop_w_bg.gif') right repeat-y;"></td>
			</tr>
			<tr style="background: url('<?=$popup_skin_path?>/img/pop_w_bg.gif') bottom repeat-x;">
				<td height="7"><img src="<?=$popup_skin_path?>/img/pop_w_bl.gif"></td>
				<td></td>
				<td align="right"><img src="<?=$popup_skin_path?>/img/pop_w_br.gif"></td>
			</tr>
		</table>
		<div style="width:100%;background:#000000;color:#FFFFFF;text-align:right;padding-right:5px;font-size:12px;">
			<input type="checkbox" id="expirehours<?=$rs[po_id];?>" name="expirehours<?=$rs[po_id];?>" value="<?=$rs[po_expirehours];?>"><?=$rs[po_expirehours];?>시간 동안 이 창을 다시 열지 않음
			<a href="javascript:popup_close(<?=$rs[po_id];?>)"><img src="<?=$popup_skin_path?>/img/close.jpg" width="11" height="11" border="0"></a>
		</div>
		</td>
		<td style="background: url('<?=$popup_skin_path?>/img/pop_l_r.gif') right repeat-y;"></td>
	</tr>
	<tr style="background: url('<?=$popup_skin_path?>/img/pop_l_b.gif') bottom repeat-x;">
		<td valign="bottom"><img src="<?=$popup_skin_path?>/img/pop_l_bl.gif"></td>
		<td></td>
		<td align="right" valign="bottom"><img src="<?=$popup_skin_path?>/img/pop_l_br.gif"></td>
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
