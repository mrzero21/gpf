<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */
 
if(!defined("__RB__")) die("잘못된 접근입니다.");
?>

<style type="text/css">
#rb_backups #rb_teacher { padding:5px;text-align:left; }
#rb_backups { width:100%; margin-top:8px;border-bottom:1px solid #dddee2;background-color:#ccc; font-size:12px;table-layout:fixed}
#rb_backups th { background-color:#eee; padding:5px 2px; text-align:center;}
#rb_backups td { background-color:#fff; padding:5px;text-align:center;}
#rb_backups tbody th { background-color:#fff;}
#rb_backups .rb_num,
#rb_backups .rb_grade { font-weight:normal}
#rb_backups .rb_link { display:block;  padding:5px 2px;}
#rb_backups .rb_link:hover { background-color:#ccc; text-decoration:none;}
#rb_backups .rb_year { background-color:#eee; font-weight:bold}
#rb_backups .rb_month {background-color:#f5f5f5}
#rb_backups .rb_date {}
#rb_backups .rb_alt {background-color:#f5f5f5;}
.rb_red { color:red; }
</style>

<h2>'<?=$class['class_name']?>' 클래스 백업/복원</h2>

<table style="width:100%">
<tr>
	<td><span class="button"><a href="<?=gpf_rb_url('edit_class')?>&rb_class=<?=$rb_class?>">출석부관리</a></span></td>
	<td align="right"><span class="button black"><a href="javascript:backup_class();">출석부 백업</a></span></td>
</tr>
</table>

<table id="rb_backups" cellspacing="1" cellpadding="0" border="0">
<colgroup>
	<col width="150px">
	<col>
	<col width="160px">
</colgroup>
<thead>
<tr>
	<th>백업 시간</th>
	<th>메모</th>
	<th>명령</th>
</tr>
</thead>
<tbody>
<? foreach($backups as $backup) { $file = $backup['file']; ?>	
<tr>
	<td><?=$backup['date']?></td>
	<td>
		<table width="100%"><tr>
				<td><input type="text" class="memo" code="<?=$file?>" id="memo_<?=$file?>" value="<?=htmlspecialchars($memos[$file])?>" style="width:100%"/></td>
				<td width="50px"><span class="button small"><a href="javascript:update_memo('<?=$file?>');">적용</a></span></td>
		</tr></table>
		</div>
	</td>
	<td>
		<span class="button green"><a href="javascript:restore('<?=$file?>');">복원</a></span>
		<span class="button"><a href="javascript:delete_backup('<?=$file?>');">삭제</a></span>
	</td>
</tr>		
<?} ?>
<? if(empty($backups)) {?>
<tr>
	<td colspan="3">출석부 백업이 없습니다.</td>
</tr>
<? } ?>
</tbody>
</table>

<script type="text/javascript">
	
$(document).ready(function() {
	$.ajaxSetup({
		cache: false,
  	error:function(x,e){
	    if(x.status==0){ alert('네트워크를 체크해주세요.'); }
			else if(x.status==404){ alert('페이지를 찾을수없습니다.'); }
			else if(x.status==500){ alert('서버에러 발생하였습니다.'); }
			else if(e=='parsererror'){ alert('JSON 데이터 처리 에러가 발생하였습니다.'); }
			else if(e=='timeout'){ alert('시간을 초과하였습니다.'); }
			else { alert('알수없는 에러가 발생하였습니다.\n'+x.responseText); }
  	}
	});	
	$(".memo").keypress(function(evt) {
		if(evt.which == 13) {
			update_memo($(this).attr('code'));
		}
	});	
});	
	
function backup_class() {
	if(confirm("백업하시겠습니까?")) {
		location.href = "<?=gpf_rb_url('edit_class', true)?>&md=backup&class_id=<?=$rb_class?>";
	}
}
function delete_backup(fileName) {
	if(confirm("백업을 삭제하시겠습니까?")) {
		location.href = "<?=gpf_rb_url('edit_class', true)?>&md=backup_delete&class_id=<?=$rb_class?>&file="+fileName;
	}
}

function restore(fileName) {
	if(confirm("이 백업으로 복원하시겠습니까?\n현재 클래스의 선생님,학생,출결 정보는 모두 삭제됩니다.")) {
		location.href = "<?=gpf_rb_url('edit_class', true)?>&md=backup_restore&class_id=<?=$rb_class?>&file="+fileName;
	}	
}

function update_memo(fileName) {	
	$ele = $("#memo_"+fileName);
	var memo = $.trim($ele.val());
	$ele.val('업데이트중입니다.').addClass('rb_red');
	
	if(memo == '') {
		alert('메모를 입력하세요');
		return;
	}
	$.getJSON('<?=GPF_PATH?>/px.php', { m : 'rollbook.exe', c : 'edit_class', md : 'backup_memo', file : fileName, class_id : <?=$rb_class?>, memo : memo }, function(json) {
		if(json.code != '1') {
			alert('업데이트 실패');
			location.reload();
			return;
		}
		
		setTimeout(function() { $ele.val(json.memo).removeClass('rb_red'); }, 600);
	});
}

</script>
