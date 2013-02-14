<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */
 
if(!defined("__RB__")) die("잘못된 접근입니다.");
?>

<style type="text/css">
h3 {padding:5px; background-color:#ececec; border-bottom:1px solid #ccc;}
#rb_toolbar { text-align:right; }
.rb_section { margin-bottom:30px; }
.desc { position:absolute; margin-left:10px; margin-top:8px; color:red; }
</style>
	
<h2>'<?=$rb_group['name']?>' 그룹 관리</h2>

<h3> 이름 변경 </h3>
<div class="rb_section">
<form name="groupfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="edit_group"/> 
<input type="hidden" name="group_id" value="<?=$rb_group['id']?>"/> 
<input type="hidden" name="md" value="u"/> 
그룹명 : <input type="text" name="group_name" value="<?=$rb_group['name']?>" size="20"/> 
<span class="button black"><input type="submit" value="수정"></span>
</form>
</div>

<h3> 그룹 삭제</h3>
<div class="rb_section">
<span class="button red"><a href="javascript:delete_group();">그룹삭제</a></span>
<span class="desc">그룹삭제를 하면 그룹에 포함된 모든 클래스, 백업, 학생, 출결 정보가 함께 삭제됩니다.</span>
<div id="delete_confirm" style="display:none">
	열쇠글 확인 : <input type="password" id="rb_passwd" size="12"/> <span class="button red"><input type="button" id="rb_btn_del" value="삭제하기"/></span>
</div>
</div>

<div style="border-top:1px solid #ccc;padding:10px 0;">
	<span class="button"><a href="<?=gpf_rb_url('index')?>">처음으로</a></span>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("input[name='group_name']").focus();
	$("#rb_btn_del").click(function() {
		if(confirm("삭제하시겠습니까?")) {
			location.href = "<?=gpf_rb_url('edit_group', true)?>&md=d&group_id=<?=$rb_group['id']?>&rb_passwd="+$("#rb_passwd").val();
		}
	});	
});

function check_form(f) {	
	if($.trim($("input[name=group_name]").val()) == '') {
		alert('그룹명을 입력하세요');
		$("input[name=group_name]").focus();
		return false;
	}
	return true;
}
	
function delete_group() {
	$("#delete_confirm").toggle();
}
</script>
