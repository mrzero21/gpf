<?
/**
 * 
 * 액션 플러그인의 필터 설정
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

if(!isset($p)) alert("잘못된 접근");

$info = $gpf->readPluginInfo($p);
if(!$info) {
	alert("잘못된 접근");
}

$g4['title'] = "플러그인 필터 설정 - " . $info->id;
include_once("./gpf.head.php");

$result = sql_query("SELECT gt.gr_id, gt.gr_subject, bt.bo_table, bt.bo_subject FROM {$g4['group_table']} AS gt LEFT JOIN {$g4['board_table']} AS bt ON gt.gr_id = bt.gr_id");
$groups = array();
while($row = sql_fetch_array($result))
{
	$gr_id = $row['gr_id'];	
	$board_info = array('bo_table'=>$row['bo_table'], 'bo_subject'=>$row['bo_subject']);
	if(!isset($groups[$gr_id])) $groups[$gr_id] = array('gr_id'=>$gr_id, 'gr_subject'=>$row['gr_subject'], 'board_list'=>array());	
	array_push($groups[$gr_id]['board_list'], $board_info);
}

unset($filter);
$filter_file = GPF_PATH."/data/plugins/".$info->id."/filter.php";
if(file_exists($filter_file))
{
	include $filter_file;		
	$filter = unserialize($filter);
}
?>
<style type="text/css">
h3 { margin-top:20px; padding-left:10px; border-left:5px solid #cccc99; }
</style>
<h2>플러그인 필터 설정 : <?=$info->label?></h2>

<h3>게시판 필터</h3>
<div style="margin:5px;padding:5px;border:1px solid #eee;line-height:150%;color:#888;">
게시판 필터를 설정하지 않을 경우, 모든 게시판에 적용됩니다. <br/>
적용 게시판으로 설정하고 제외 게시판에도 설정할 경우 플러그인 적용에서 제외됩니다.
</div>
<form name="frmfltboard" action="<?=$g4['admin_path']?>/gpf/exe/action_filter.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="md" value="action_filter"/>
<input type="hidden" name="p" value="<?=$p?>"/>

<table class="gpf_table" cellpadding="0" cellspacing="0">
<colgroup><col width="50%"/><col width="50%"/></colgroup>
<tr>
	<th>적용게시판 설정</th>
	<th>제외게시판 설정</th>
</tr>
<tr>
	<td style="border-bottom:0">
		<table cellspacing="0" cellpadding="0" border="0" class="gpf_board_manage" style="border-top:0">
		<colgroup><col width="120px"/><col width=""/></colgroup>
		<tr>
			<th>그룹</th>
			<td><select class="gpf_group_list" style="width:100%"></select></td>
		</tr>
		<tr>
			<th>게시판</th>
			<td><select class="gpf_board_list" style="width:100%"></select></td>
		</tr>
		<tr>
			<th>적용게시판</th>
			<td>
				<select class="gpf_board" name="gpf_apply_boards[]" id="gpf_apply_boards" multiple='multiple' style="width:100%;height:200px"></select>
				<div style="margin-top:5px;text-align:right">
					<span class="button small"><input type="button" class="gpf_del_board" value="선택 게시판 삭제"/></span>
				</div>
			</td>
		</tr>
		</table>
	</td>

	<td style="border-bottom:0">
		<table cellspacing="0" cellpadding="0" border="0" class="gpf_board_manage" style="border-top:0">
		<colgroup><col width="120px"/><col width=""/></colgroup>
		<tr>
			<th>그룹</th>
			<td><select class="gpf_group_list" style="width:100%"></select></td>
		</tr>
		<tr>
			<th>게시판</th>
			<td><select class="gpf_board_list" style="width:100%"></select></td>
		</tr>
		<tr>
			<th>제외게시판</th>
			<td>
				<select class="gpf_board" name="gpf_except_boards[]" id="gpf_except_boards" multiple='multiple' style="width:100%;height:200px"></select>
				<div style="margin-top:5px;text-align:right">
					<span class="button small"><input type="button" class="gpf_del_board" value="선택 게시판 삭제"/></span>
				</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<br/><br/>

<h3>사용자 필터</h3>
<div style="margin:5px;padding:5px;border:1px solid #eee;line-height:150%;color:#888;">
사용자 필터를 설정하지 않을 경우, 모든 사용자에 적용됩니다. <br/>
적용 사용자로 설정하고 제외 사용자에도 설정할 경우 플러그인 적용에서 제외됩니다. <br/>
</div>

<table class="gpf_table" cellpadding="0" cellspacing="0">
<colgroup><col width="50%"/><col width="50%"/></colgroup>
<tr>
	<th>적용사용자 설정</th>
	<th>제외사용자 설정</th>
</tr>
<tr>
	<td style="border-bottom:0">
		<table cellspacing="0" cellpadding="0" border="0" class="gpf_user_manage" style="border-top:0">
		<colgroup><col width="120px"/><col width=""/></colgroup>
		<tr>
			<th>사용자</th>
			<td>
				<input type="text" class="gpf_user_search" style="width:140px"/>
				<span class="button"><input type="button" class="gpf_search_btn" value="검색"/></span>
				<div class="gpf_search_result" style="position:absolute;margin-top:5px;border:1px solid #ccc;padding:5px 20px 5px 20px;background-color:#fff;line-height:150%;z-index:999"></div>
			</td>
		</tr>
		<tr>
			<th>적용사용자</th>
			<td>
				<select class="gpf_user" name="gpf_apply_users[]" id="gpf_apply_users" multiple='multiple' style="width:100%;height:200px"></select>
				<div style="margin-top:5px;text-align:right">
					<span class="button small"><input type="button" class="gpf_del_user" value="선택 사용자 삭제"/></span>
				</div>
			</td>
		</tr>
		</table>
	</td>

	<td style="border-bottom:0">
		<table cellspacing="0" cellpadding="0" border="0" class="gpf_user_manage" style="border-top:0">
		<colgroup><col width="120px"/><col width=""/></colgroup>
		<tr>
			<th>사용자</th>
			<td>
				<input type="text" class="gpf_user_search" style="width:140px"/>
				<span class="button"><input type="button" class="gpf_search_btn" value="검색"/></span>
				<div class="gpf_search_result" style="position:absolute;margin-top:5px;border:1px solid #ccc;padding:5px 20px 5px 20px;background-color:#fff;line-height:150%;z-index:999"></div>
			</td>
		</tr>
		<tr>
			<th>제외사용자</th>
			<td>
				<select class="gpf_user" name="gpf_except_users[]" id="gpf_except_users" multiple='multiple' style="width:100%;height:200px"></select>
				<div style="margin-top:5px;text-align:right">
					<span class="button small"><input type="button" class="gpf_del_user" value="선택 사용자 삭제"/></span>
				</div>
			</td>
		</tr>
		</table>
	</td>
</tr>

<tr>
	<td colspan="2" align="center">
		<span class="button"><input type="submit" value="확인"/></span>
	</td>
</tr>

</table>
</form>

<script type="text/javascript">

var $info = <?=json_encode($groups)?>;

function check_form(f)
{
	$(f).find('select option').each(function(){
		$(this).attr('selected', 'selected');
    });
	return true;
}

(function($){
  $.fn.manage_user = function(opts) {
	  return this.each(function() {
		var obj = $(this);
		var $us = obj.find('.gpf_user_search');
		var $sb = obj.find('.gpf_search_btn');
		var $gsr = obj.find('.gpf_search_result');
		var $gab = obj.find('.gpf_add');
		var $gdb = obj.find('.gpf_del');
		var $u = obj.find('.gpf_user');
		var $gdu = obj.find('.gpf_del_user');
		
		var check_unique = function(slt, v) {
			if(slt.find('option[value='+v+']').length > 0) return false;
			return true; 
		};

		var search_user = function() {
			$.getJSON('<?=$g4['admin_path']?>/gpf/exe/g.php?md=user_search&mb_info='+$us.val(), function(json) {
				if(json.code == 1) {
					if(json.users.length > 0) {
						for(i=0; i<json.users.length; i++) 
						{
							$gsr.append('<a href="javascript:;" class="gpf_searched" mb_id="'+json.users[i].mb_id+'" mb_name="'+json.users[i].mb_name+'">'+json.users[i].mb_name+' ('+json.users[i].mb_id+')</a><br/>');
						}

						$gsr.find('.gpf_searched').click(function() {
							var mb_id = $(this).attr('mb_id');
							var mb_name = $(this).attr('mb_name');
							if(!check_unique($u, mb_id)) return;
							$(this).next().remove();
							$(this).remove();
							if($gsr.find('.gpf_searched').length == 0) $gsr.html('').hide();
							$u.append('<option value="'+mb_id+'">'+mb_name+' ('+mb_id+')</option>');
						});
					} else {
						$gsr.append('검색 결과가 없습니다.');
					}

					$gsr.append('<div style="margin-top:5px;padding:5px 0;border-top:1px dotted #ccc;text-align:center;"><span class="button small"><a href="javascript:;" class="gpf_close_searched">닫기</a></span></div>');
					$gsr.find('.gpf_close_searched').click(function() {
						$gsr.html('').hide();
					});
					$gsr.show();
				}
			});
		};

		$gsr.hide();

		$sb.click(search_user);
		$us.keypress(function(e) {
			if(e.which == 13) {
				search_user();
				e.preventDefault();
			}
		});

		$gdu.click(function() {
			var mb_id = $u.val();
			if(mb_id == null) return;
			for(i=0; i<mb_id.length; i++) $u.find('option[value='+mb_id[i]+']').remove();			
		});

	  });
  };

  $.fn.manage_board = function(opts) {
		
	var check_unique = function(slt, v) {
		if(slt.find('option[value='+v+']').length > 0) return false;
		return true; 
		};
	
	return this.each(function() {
		var obj = $(this);
		var $gl = obj.find('.gpf_group_list');
		var $bl = obj.find('.gpf_board_list');
		var $b = obj.find('.gpf_board');
		var $gdb = obj.find('.gpf_del_board');

		$gl.append("<option value=''>그룹선택</option>");
		for(var gr in $info) {
			$gl.append('<option value="'+$info[gr].gr_id+'">'+$info[gr].gr_subject+' ('+$info[gr].gr_id+')</option>');
		}
		
		$bl.append('<option value="">게시판 선택</option>');

		$gl.change(function() {
			var gr_id = $gl.val();
			if(gr_id == '') return;
			var gr_info = eval('$info.'+gr_id);
			$bl.html('');
			$bl.append('<option value="">게시판 선택</option>');
			for(i=0; i<gr_info.board_list.length; i++)
			{
				var board_info = gr_info.board_list[i];
				$bl.append('<option value="'+board_info.bo_table+'">'+board_info.bo_subject+' ('+board_info.bo_table+')</option>');
			}
		});

		$bl.change(function() {
			var gr_id = $gl.val();
			var bo_table = $bl.val();
			if(gr_id == '' || bo_table == '') return;
			if(!check_unique($b, bo_table)) return;
			var bo_text = $bl.find(":selected").text();
			$b.append('<option value="'+bo_table+'">'+bo_text+'</option>');
		});

		$gdb.click(function() {
			var bo_table = $b.val();
			if(bo_table == null) return;
			for(i=0; i<bo_table.length; i++) $b.find('option[value='+bo_table[i]+']').remove();
		});
    });
 };
})(jQuery);

function add_user(users, $slt)
{
	for(var i=0; i<users.length; i++)
	{
		$.getJSON('<?=$g4['admin_path']?>/gpf/exe/g.php?md=user_info&mb_info='+users[i], function(json) {
			if(json.code == 1) {
				$slt.append('<option value="'+json.user.mb_id+'">'+json.user.mb_name+' ('+json.user.mb_id+')</option>');
			}
		});		
	}
}

function add_board(bo_tables, $slt)
{
	for(var i=0; i<bo_tables.length; i++)
	{
		$.getJSON('<?=$g4['admin_path']?>/gpf/exe/g.php?md=board_info&btable='+bo_tables[i], function(json) {
			if(json.code == 1) {
				$slt.append('<option value="'+json.board.bo_table+'">'+json.board.bo_subject+' ('+json.board.bo_table+')</option>');
			}
		});		
	}
}

$(document).ready(function() {
	$('.gpf_board_manage').manage_board();
	$('.gpf_user_manage').manage_user();

	<? if(isset($filter)) { ?>
	var filters = <?=json_encode($filter)?>;
	if(filters.apply.user != null) add_user(filters.apply.user, $("#gpf_apply_users"));
	if(filters.except.user != null) add_user(filters.except.user, $("#gpf_except_users"));
	if(filters.apply.board != null) add_board(filters.apply.board, $("#gpf_apply_boards"));
	if(filters.except.board != null) add_board(filters.except.board, $("#gpf_except_boards"));
	<? } ?>
});

</script>

<?
include_once("./gpf.tail.php");
?>

