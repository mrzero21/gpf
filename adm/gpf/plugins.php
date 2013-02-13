<?
/**
 * 
 * 플러그인 관리
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

define("_GPF_PLUGINS_", "");


auth_check($auth[$sub_menu], "w");

$g4['title'] = "플러그인관리";

include_once("gpf.head.php");

$plugins = $gpf->readPlugins();
foreach($gpf->getActivatedPlugins() as $k=>$v) $using_plugins[$v] = $v;
?>
<style type="text/css">
#plugin_table { table-layout:fixed; word-break:break-all; }
#plugin_table td { background-color:#FFF; }
#plugin_table a { color:#486D82; }
.gpf_desc { padding-bottom:5px; line-height:160%}
.gpf_btns { margin-top:10px; padding-left:20px; font-size:0.9em }
.gpf_handle { position:absolute; width:14px; margin-top:-1px}
.gpf_name { margin-left:20px;  }
.gpf_active { font-weight:bold; }
.gpf_author_info { margin:5px 0;color:#888; }
.gpf_auth { padding-top:5px; }
.gpf_auth div { float:left; font-size:8pt; background-color:#eaeaea; padding:2px 5px; -moz-border-radius: 10px; border-radius: 10px; margin-right:5px; margin-bottom:5px;}
.gpf_hide { display:none; }
</style>
<h2>플러그인</h2>
<br/>
<a href="javascript:;" id="gpf_show_all" class="gpf_active">모두보기</a> | <a href="javascript:;" id="gpf_show_actiated">사용중인 플러그인 보기</a>

<table id="plugin_table" class="gpf_table" cellspacing="0" cellpadding="0">
<colgroups><col width="220px"/><col/></colgroups>
<thead>
<tr>
	<th align="left">플러그인</th>
	<th align="left">설명</th>
</tr>
</thead>
<tbody>
<? 
foreach($plugins as $id => $plugin) { 
	$info = $plugin->loadPluginInfo();
	$label = ($info->label ? $info->label : $id);
	$btns = array();
	$active_class = "";
	if(!$info->shouldInstall()) {
		if(!$using_plugins[$id]) {		
			array_push($btns, "<a href=\"javascript:;\" id=\"gpf_active_{$id}\" data-id=\"$id\" data-active=\"0\" class=\"gpf_active_link\">활성화</a>");
		} else {
			$active_class = "gpf_active";
			array_push($btns, "<a href=\"javascript:;\" id=\"gpf_active_{$id}\" data-id=\"$id\" data-active=\"1\" class=\"gpf_active_link\">비활성화</a>");
		}
		if($plugin->use_filter) array_push($btns, "<a href='{$g4['admin_path']}/gpf/action_filter.php?p={$id}'>액션필터</a>");
		if($info->shouldSetup()) array_push($btns, "<a href='{$g4['admin_path']}/gpf/plugin_setup.php?p={$id}'>설정</a>");
		if($info->shouldUnInstall()) array_push($btns, "<a href=\"javascript:plugin_uninstall('{$id}', '{$label}');\">제거</a>");
	} else {
		array_push($btns, "<a href=\"javascript:plugin_install('{$id}', '{$label}');\">설치</a>");
	}

	$btns = implode(" | ", $btns);

	$author_info = array();
	array_push($author_info, "버전 : " . $info->version);
	if($info->author_homepage) array_push($author_info, "제작자 : <a href='".$info->author_homepage."'>" . $info->author_name."</a>");
	else array_push($author_info, "제작자 : ". $info->author_name);
	if($info->plugin_link) array_push($author_info, "<a href='".$info->plugin_link."'>플러그인 페이지 방문</a>");
	$author_info = implode(" | ", $author_info);
?>
<tr id="gpf_plugins_<?=$id?>" <?=($using_plugins[$id] ? "class=\"gpf_active_plugin\"" : "class=\"gpf_inactive_plugin\"")?>>
	<td valign="top">
		<img src="<?=GPF_ADMIN_PATH?>/imgs/move.png" class="gpf_handle" />
		<span id="gpf_label_<?=$id?>" class="gpf_name <?=$active_class?>">
			<?=$label?>
		</span>
		<div class="gpf_btns">
			<?=$btns?>
		</div>
	</td>
	<td>
		<div class="gpf_desc">
			<?=$info->getDescription()?>
		</div><!--// gpf_desc -->
		<div class="gpf_author_info">
			<?=$author_info?>
		</div>
		<div class="gpf_auth clearfix">
		<? $fs = $info->getFunctions(); for($i=0, $to=count($fs); $i<$to; $i++) { echo "<div><a href='http://byfun.com/axis/gpf_help.php?plugin=".$info->id."&item=".$fs[$i]."' target='_blank'>".$fs[$i]."</a></div>";  } ?>
		</div>
	</td>
</tr>
<? } ?>
</tbody>
</table>

<script type="text/javascript" src="js/jquery-ui-1.8.22.custom.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	$(".gpf_active_link").click(function() {
		$id = $(this).attr('data-id');
		$use = ( $(this).attr('data-active') == 0 ? 1 : 0 );		
		$.get("exe/plugins.php?md=update_use&p="+$id+"&use="+$use, function(json) {
			try
			{
				json = $.parseJSON(json);
			if(json.code == 1) {
				$tr = $("#gpf_plugins_"+json.plugin_id);
				$lb = $("#gpf_label_"+json.plugin_id);
				$al = $("#gpf_active_"+json.plugin_id);
				if(json.use == 1) {
					$lb.addClass('gpf_active');
					$tr.addClass('gpf_active_plugin').removeClass('gpf_inactive_plugin');
					$al.text('비활성화');
				} else {
					$lb.removeClass('gpf_active');
					$tr.addClass('gpf_inactive_plugin').removeClass('gpf_active_plugin');
					$al.text('활성화');
				}
				$al.attr('data-active', json.use);
			}
			else alert('Fail to update');
			}
			catch (exs)
			{
				alert(json);
			}

		});
	});

	$("#plugin_table tbody").sortable({
		handle : '.gpf_handle',
		helper : function(e, ui) {
			ui.children().each(function() {
			$(this).width($(this).width());
			});
			return ui;
		},
		update : function () {
			var order = $('#plugin_table tbody').sortable('serialize');
			$.getJSON("exe/plugins.php?md=sort&"+order, function(json) {
				if(json.code != 1) alert('Fail to update! ');
			});
		}
	}).disableSelection();
	
	$("#gpf_show_all").click(function() {
		$(".gpf_inactive_plugin").show();
		$("#gpf_show_actiated").removeClass('gpf_active');
		$(this).addClass('gpf_active');
	});

	$("#gpf_show_actiated").click(function() {
		$(".gpf_inactive_plugin").hide();
		$("#gpf_show_all").removeClass('gpf_active');
		$(this).addClass('gpf_active');
	});
});

function plugin_install(id, name)
{
	if(confirm('"'+name+'" 플러그인을 설치하시겠습니까?')) location.href = "<?=$g4['admin_path']?>/gpf/plugin_install.php?p="+id;
}

function plugin_uninstall(id, name)
{
	if(confirm('"'+name+'" 플러그인을 삭제하시겠습니까?')) location.href = "<?=$g4['admin_path']?>/gpf/plugin_uninstall.php?p="+id;
}
</script>

<?
include_once("gpf.tail.php");
?>
