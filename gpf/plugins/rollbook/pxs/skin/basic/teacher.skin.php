<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");
?>

<style type="text/css">
#rb_toolbar { float:right; }
#rb_teacher { margin-top:10px; width:320px; border-bottom:1px solid #dddee2;background-color:#ccc; font-size:12px;table-layout:fixed}
#rb_teacher th { background-color:#eee; padding:5px; text-align:center;}
#rb_teacher td { background-color:#fff; padding:5px; text-align:center;}
</style>

<h2>'<?=$class['class_name']?>' 클래스에 선생님 추가</h2>

<form name="teacherfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="add_teacher"/> 
<input type="hidden" name="class_id" value="<?=$rb_class?>"/> 
선생님 이름 : <input type="text" name="teacher_name" size="20"/> 
<span class="button black"><input type="submit" value="만들기"></span>
<span class="button"><a href="<?=gpf_rb_url('class')?>&rb_class=<?=$rb_class?>">출석부보기</a></span>
</form>

<table id="rb_teacher" cellspacing="1" cellpadding="0" border="0">
	<colgroup>
		<col>
		<col width="50px">
	</colgroup>
<thead>
	<tr>
		<th>이름</th>
		<th>&nbsp;</th>
	</tr>	
</thead>
<tbody>
	<? foreach($teachers as $k=>$teacher) {?>
	<tr>
		<td><?=$teacher['name']?></td>
		<td><span class="button"><a href="javascript:delete_teacher(<?=$teacher['id']?>);">삭제</a></span></td>
	</tr>
	<? }?>
</tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {
	$("input[name='teacher_name']").focus();
});	

function check_form(f) {	
	if($.trim($("input[name=teacher_name]").val()) == '') {
		alert('이름을 입력하세요');
		$("input[name=teacher_name]").focus();
		return false;
	}
	return true;
}

function delete_teacher(tid) {	
	if(confirm('삭제하시겠습니까?')) {
		location.href = "<?=gpf_rb_url('delete_teacher', true)?>&rb_class=<?=$rb_class?>&tid=" + tid;
	}
}
</script>
