<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
?>
<style>
#pop<?=$rs['po_id']?>{
	position:absolute;
	z-index:<?=$zindex?>;
	width:<?=$rs['po_width']?>px;
	height:<?=$rs['po_height']?>px;
	filter:alpha(opacity=100);
	overflow : hidden;
}
</style>

<div id="pop<?=$rs['po_id']?>">
	<div style="width:{po_width}px;overflow:hidden;">
	<table cellpadding="0" cellspacing="0" bgcolor="#edf2fc" width="100%" height="100%">
		<tr style="background: url('<?=$popup_skin_path;?>/img/pop_l_t.gif') top repeat-x;">
			<td width="11" valign="top" height="11"><img src="<?=$popup_skin_path;?>/img/pop_l_tl.gif"></td>
			<td></td>
			<td width="11" align="right" valign="top"><img src="<?=$popup_skin_path;?>/img/pop_l_tr.gif"></td>
		</tr>
		<tr>
			<td style="background: url('<?=$popup_skin_path;?>/img/pop_l_l.gif') left repeat-y;" height="11"></td>
			<td>
			<div style="overflow:{overflow};">
			<table cellspacing="0" cellpadding="0" bgcolor="#ffffff" width="100%" height="<?=$rs[po_height] - 42;?>">
				<tr style="background: url('<?=$popup_skin_path;?>/img/pop_w_bg.gif') top repeat-x;">
					<td width="7" height="7"><img src="<?=$popup_skin_path;?>/img/pop_w_tl.gif"></td>
					<td></td>
					<td align="right"><img src="<?=$popup_skin_path;?>/img/pop_w_tr.gif"></td>
				</tr>
				<tr>
					<td style="background: url('<?=$popup_skin_path;?>/img/pop_w_bg.gif') left repeat-y;"></td>
					<td valign="top">
						<div style="color:#657db9;font-weight:bold;border-bottom:1px #cccccc solid;margin:10px;height:30px"><?=$rs[po_subject];?></div>
						<div style="margin:10px;"><?=$rs[po_content];?></div>
					</td>
					<td style="background: url('<?=$popup_skin_path;?>/img/pop_w_bg.gif') right repeat-y;"></td>
				</tr>
				<tr style="background: url('<?=$popup_skin_path;?>/img/pop_w_bg.gif') bottom repeat-x;">
					<td height="7"><img src="<?=$popup_skin_path;?>/img/pop_w_bl.gif"></td>
					<td></td>
					<td align="right"><img src="<?=$popup_skin_path;?>/img/pop_w_br.gif"></td>
				</tr>
			</table>
			</div>
			<div style="width:100%;background:#000000;color:#FFFFFF;text-align:left;padding-right:5px;font-size:12px;">
				<input type="checkbox" id="expirehours<?=$rs['po_id']?>" name="expirehours<?=$rs['po_id']?>" value="<?=$rs[po_expirehours];?>"><?=$rs[po_expirehours];?>시간 동안 이 창을 다시 열지 않음
				<a href="javascript:layer_close(<?=$rs[po_id];?><?=($rs[po_actc])?",'{$rs[po_actc]}'":"";?>)"><img src="<?=$popup_skin_path;?>/img/close.jpg" width="11" height="11" border="0"></a>
			</div>
			</td>
			<td style="background: url('<?=$popup_skin_path;?>/img/pop_l_r.gif') right repeat-y;"></td>
		</tr>
		<tr style="background: url('<?=$popup_skin_path;?>/img/pop_l_b.gif') bottom repeat-x;">
			<td valign="bottom"><img src="<?=$popup_skin_path;?>/img/pop_l_bl.gif"></td>
			<td></td>
			<td align="right" valign="bottom"><img src="<?=$popup_skin_path;?>/img/pop_l_br.gif"></td>
		</tr>
	</table>
	</div>
</div>
<script language='JavaScript'>
function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat" && !window.opera)? document.documentElement : document.body
}

<?if($rs[po_leftcenter]){?>
document.getElementById("pop<?=$rs['po_id']?>").style.left = (ietruebody().clientWidth / 2) + {po_left} + "px";
<?}else{?>
document.getElementById("pop<?=$rs['po_id']?>").style.left = {po_left} + "px";
<?}?>
<?if($rs[po_topcenter]){?>
document.getElementById("pop<?=$rs['po_id']?>").style.top = (ietruebody().clientHeight / 2) + {po_top} + "px";
<?}else{?>
document.getElementById("pop<?=$rs['po_id']?>").style.top = {po_top} + "px";
<?}?>

<?if(!$rs[po_act]){?>
document.getElementById("pop<?=$rs['po_id']?>").style.display = "";
<?}?>

selectbox_hidden("pop<?=$rs['po_id']?>");
<?if($rs[po_act] != "" && $rs[po_popstyle] == 1){?>
<?=$rs[po_act];?>(document.getElementById("pop<?=$rs['po_id']?>"),<?=$rs[po_delay];?>);
<?}?>
</script>
