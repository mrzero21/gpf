<?
$tpl_path = GPF_PATH."/data/plugins/widget";
?>

<h3>위젯 설정</h3>
<div style="padding:5px 0;">
	관리자 패스워드 : <input type="password" id="admin_password" class="ed" size="20"/>
</div>
<table id="gw_tpl_table" cellspacing="0" cellpadding="0" style="width:100%;" >
<colgroups><col width="100px"/><col/></colgroups>
<tbody>
<tr>
	<th valign="top">
		<ul id="gw_tpls">
			<li id="gw_form" class="selected"><a href="javascript:gw_change('form');">게시물 하단</a></li>
		</ul>
	</th>
	<td id="gw_textareas" style="padding:20px;webkit-border-radius: 0px 10px 10px 10px;-moz-border-radius: 0px 10px 10px 10px;border-radius: 0px 10px 10px 10px;background-color:#EAEAEA;">
			<textarea id="gw_tpl_form" data-type="view.tail" class="selected"><?=@file_get_contents($tpl_path."/view.tail.txt")?></textarea>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<br/>
		<span class="button"><input type="button" id="gw_btn_tpl" value="확인"/></span>
	</td>
</tr>
</tbody>	
</table>

<style type="text/css">
#gw_tpls { list-style:none; padding:0}
#gw_tpls li { padding:8px 5px; margin:0; font-size:10pt;}
#gw_tpls li.selected { webkit-border-radius: 10px 0px 0px 10px;-moz-border-radius: 10px 0px 0px 10px;border-radius: 10px 0px 0px 10px;background-color:#EAEAEA; }
#gw_tpl_table textarea { width:100%;height:400px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('#gw_btn_tpl').click(function() {
		var $tpl = $('#gw_textareas').find('textarea.selected').eq(0);
		var tpl_type = $tpl.attr('data-type');
		var contents = $tpl.val();
		var admin_passwd = $('#admin_password').val();
		if(!admin_passwd) {
			alert('관리자 패스워드를 입력하세요');
			$('#admin_password').focus();
			return;
		}
		$.post('<?=$g4['path']?>/gpf/px.php', { 'm' : 'widget', 'c' : 'update_widget', 'type' : tpl_type, 'contents' : contents, 'admin_password' : admin_passwd }, function(data) {
			var json = $.parseJSON(data);
			alert(json.msg);
		});		
	});
});

function gw_change(t)
{
	$('#gw_tpls').find('li.selected').removeClass('selected');
	$('#gw_'+t).addClass('selected');
	$('#gw_textareas').find('textarea').removeClass('selected').hide();
	$('#gw_tpl_'+t).show().addClass('selected');
}
</script>
