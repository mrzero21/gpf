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
<script language='JavaScript'>
$(document).ready(function() {
	$('body').prepend(['<div id="pop<?=$rs['po_id']?>" >',
						'<div style="width:<?=$rs['po_width']?>px;overflow:hidden;">',
							'<table cellpadding="0" cellspacing="0" bgcolor="#edf2fc" width="100%" height="100%">',
								'<tr><td>',							
									'<table cellspacing="0" cellpadding="0" width="100%" height="<?=$rs[po_height] - 20;?>">',
									'<tr><td valign="top" style="padding:10px"><div style="overflow:{overflow};"><?=addslashes(preg_replace('/\s\s+/', ' ', $rs[po_content]))?></div></td></tr>',
									'</table>',
									'<div style="background:#000000;color:#FFFFFF;text-align:left;padding-right:5px;;font-size:12px;">',
									'<input type="checkbox" id="expirehours<?=$rs['po_id']?>" name="expirehours<?=$rs['po_id']?>" value="<?=$rs[po_expirehours];?>"><?=$rs[po_expirehours];?>시간 동안 이 창을 다시 열지 않음',
									'<a href="javascript:layer_close(<?=$rs[po_id];?><?=($rs[po_actc])?",\'$rs[po_actc]\'":"";?>)"><img src="<?=$popup_skin_path;?>/img/close.jpg" width="11" height="11" border="0"></a>',
									'</div>',
								'</td></tr>',
							'</table>',
						'</div>',
					'</div>'].join(''));

	function ietruebody(){
		return (document.compatMode && document.compatMode!="BackCompat" && !window.opera)? document.documentElement : document.body
	}

	<?if($rs[po_leftcenter]){?>
	document.getElementById("pop<?=$rs['po_id']?>").style.left = (ietruebody().clientWidth / 2) + <?=$rs['po_left']?> + "px";
	<?}else{?>
	document.getElementById("pop<?=$rs['po_id']?>").style.left = <?=$rs['po_left']?> + "px";
	<?}?>
	<?if($rs[po_topcenter]){?>
	document.getElementById("pop<?=$rs['po_id']?>").style.top = (ietruebody().clientHeight / 2) + <?=$rs['po_top']?> + "px";
	<?}else{?>
	document.getElementById("pop<?=$rs['po_id']?>").style.top = <?=$rs['po_top']?> + "px";
	<?}?>

	<?if(!$rs[po_act]){?>
	document.getElementById("pop<?=$rs['po_id']?>").style.display = "";
	<?}?>

	selectbox_hidden("pop<?=$rs['po_id']?>");
	<?if($rs[po_act] != "" && $rs[po_popstyle] == 1){?>
	<?=$rs[po_act];?>(document.getElementById("pop<?=$rs['po_id']?>"),<?=$rs[po_delay];?>);
	<?}?>

});


</script>