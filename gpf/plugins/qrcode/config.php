<?
/**
 * 
 * QR코드 플러그인 환경설정 스크립트
 * 
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

@include_once GPF_PATH."/data/plugins/qrcode/config.php";
if(!isset($qrcode_config['matrix_point_size'])) $qrcode_config['matrix_point_size'] = "2";
if(!isset($picasa_account['regcode'])) $picasa_account['regcode'] = "";
$tpl_path = GPF_PATH."/plugins/qrcode/tpl";
?>
<h3>템플릿 수정</h3>
<table id="gq_tpl_table" cellspacing="0" cellpadding="0" style="width:100%;" >
<colgroups><col width="100px"/><col/></colgroups>
<tbody>
<tr>
	<th valign="top">
		<ul id="gq_tpls">
			<li id="gq_view" class="selected"><a href="javascript:gq_change('view');">출력형태</a></li>
		</ul>
	</th>
	<td id="gq_textareas" style="padding:20px;webkit-border-radius: 0px 10px 10px 10px;-moz-border-radius: 0px 10px 10px 10px;border-radius: 0px 10px 10px 10px;background-color:#EAEAEA;">
			<textarea id="gq_tpl_view" data-type="view" class="selected" style="overflow: auto;overflow-x: hidden;"><?=htmlspecialchars(file_get_contents($tpl_path."/view.txt"))?></textarea>
	</td>
</tr>
<tr>
	<td colspan="2" align="center">
		<br/>
		<span class="button"><input type="button" id="gq_btn_tpl" value="확인"/></span>
	</td>
</tr>
</tbody>	
</table>

<style type="text/css">
#gq_tpls { list-style:none; padding:0;margin:0;}
#gq_tpls li { padding:8px 5px; margin:0; font-size:10pt; }
#gq_tpls li.selected { webkit-border-radius: 10px 0px 0px 10px;-moz-border-radius: 10px 0px 0px 10px;border-radius: 10px 0px 0px 10px;background-color:#EAEAEA; }
#gq_tpl_table textarea { width:100%;height:400px; }
.gq_lb {position:absolute;margin-top:5px;color:#888;font-size:0.9em;}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('#gq_btn_check').click(function() {
		$.post('<?=GPF_PATH?>/px.php', { 'm' : 'picasa', 'c' : 'check_account', 'email' : $('#gq_email').val(), 'passwd' : $('#gq_passwd').val(), 'regcode' : $('#gq_regcode').val() }, function(data) {
			try
			{
				var json = $.parseJSON(data);
				alert(json.msg);				
			}
			catch (ex)
			{
				alert(data);
			}
		});
	});
	$('#gq_btn_tpl').click(function() {
		var $tpl = $('#gq_textareas').find('textarea.selected').eq(0);
		var tpl_type = $tpl.attr('data-type');
		var contents = $tpl.val();

		$.post('<?=GPF_PATH?>/px.php', { 'm' : 'qrcode', 'c' : 'update_tpl', 'type' : tpl_type, 'contents' : contents }, function(data) {
			try
			{
				var json = $.parseJSON(data);
				alert(json.msg);				
			}
			catch (ex)
			{
				alert(data);
			}
		});		
	});
});

function gq_change(t)
{
	$('#gq_tpls').find('li.selected').removeClass('selected');
	$('#gq_'+t).addClass('selected');
	$('#gq_textareas').find('textarea').removeClass('selected').hide();
	$('#gq_tpl_'+t).show().addClass('selected');
}
</script>
