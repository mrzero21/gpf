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
	
<h2>'<?=$rb_group['name']?>' 그룹에 클래스 추가</h2>

<form name="groupfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="add_class"/> 
<input type="hidden" name="group_id" value="<?=$rb_group['id']?>"/> 
클래스명 : <input type="text" name="class_name" size="20"/> 
<span class="button black"><input type="submit" value="만들기"></span>
<span class="button"><a href="javascript:history.go(-1);">취소</a></span>
</form>

<script type="text/javascript">
$(document).ready(function() {
	$("input[name='class_name']").focus();
});	

function check_form(f) {	
	if($.trim($("input[name=class_name]").val()) == '') {
		alert('클래스명을 입력하세요');
		$("input[name=class_name]").focus();
		return false;
	}
	return true;
}
</script>
