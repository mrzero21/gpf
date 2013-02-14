<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");
?>
<style type="text/css">
#rb_toolbar { text-align:right; }
</style>
	
<h2>그룹 추가</h2>

<form name="groupfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="add_group"/> 
그룹명 : <input type="text" name="group_name" size="20"/> 
<span class="button black"><input type="submit" value="만들기"></span>
<span class="button"><a href="javascript:history.go(-1);">취소</a></span>
</form>

<script type="text/javascript">
$(document).ready(function() {
	$("input[name='group_name']").focus();
});	

function check_form(f) {	
	if($.trim($("input[name=group_name]").val()) == '') {
		alert('그룹명을 입력하세요');
		$("input[name=group_name]").focus();
		return false;
	}
	return true;
}
</script>
