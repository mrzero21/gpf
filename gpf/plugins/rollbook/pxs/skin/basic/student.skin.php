<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");
?>

<style type="text/css">
#rb_toolbar { float:right; }
#rb_form { border-bottom:1px solid #ccc; padding:5px;}
#rb_student { margin-top:10px; width:320px; border-bottom:1px solid #dddee2;background-color:#ccc; font-size:12px;table-layout:fixed}
#rb_student th { background-color:#eee; padding:5px; text-align:center;}
#rb_student td { background-color:#fff; padding:5px; text-align:center;}
#btn_cancel { display:none; }
</style>

<h2>'<?=$class['class_name']?>' 클래스에 학생 추가</h2>

<div id="rb_form">
<form name="studentfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="add_student"/> 
<input type="hidden" name="class_id" value="<?=$rb_class?>"/> 
<input type="hidden" name="student_id" value="-1"/> 
<input type="hidden" name="md" value="w"/> 
학생 이름 : <input type="text" name="student_name" size="20"/> &nbsp;&nbsp;&nbsp;
성별 : <select name="student_sex"><option value="남">남자</option><option value="여">여자</option></select> &nbsp;&nbsp;&nbsp;
학교/직장 : <input type="text" name="student_school" size="20"/>  &nbsp;&nbsp;&nbsp;
구분 : <select name="student_grade"><? foreach($rb['grade'] as $gr) { ?> <option value="<?=$gr?>"><?=$gr?></option><?}?></select> &nbsp;&nbsp;&nbsp;
<span class="button black"><input type="submit" id="btn_submit" value="만들기"/></span>
<span id="btn_cancel"><span class="button red"><input type="button" value="편집취소"/></span></span>
<span class="button"><a href="<?=gpf_rb_url('class')?>&rb_class=<?=$rb_class?>">출석부보기</a></span>
</form>
</div>

<table id="rb_student" cellspacing="1" cellpadding="0" border="0">
	<colgroup>
		<col width="80px">
		<col width="50px">
		<col width="120px">
		<col width="50px">
		<col width="120px">
	</colgroup>
<thead>
	<tr>
		<th>이름</th>
		<th>성별</th>
		<th>학교/직장</th>
		<th>구분</th>
		<th>&nbsp;</th>
	</tr>	
</thead>
<tbody>
	<? foreach($students as $k=>$student) {?>
	<tr id="rb_s_<?=$student['id']?>">		
		<td id="rb_name_<?=$student['id']?>"><?=$student['name']?></td>
		<td id="rb_sex_<?=$student['id']?>"><?=$student['sex']?></td>
		<td id="rb_school_<?=$student['id']?>"><?=$student['school']?></td>
		<td id="rb_grade_<?=$student['id']?>"><?=$student['grade']?></td>
		<td>
			<span class="button"><a href="javascript:edit_student(<?=$student['id']?>);">수정</a></span>
			<span class="button"><a href="javascript:delete_student(<?=$student['id']?>);">삭제</a></span>
		</td>
	</tr>
	<? }?>
</tbody>
</table>

<script type="text/javascript">

var saved_pos = 0;
	
$(document).ready(function() {
	$("input[name='student_name']").focus();
	$("#btn_cancel input").click(function() {
		cancel_edit();
	});
});	

function check_form(f) {	
	if($.trim($("input[name=student_name]").val()) == '') {
		alert('이름을 입력하세요');
		$("input[name=student_name]").focus();
		return false;
	}
	return true;
}

function delete_student(sid) {	
	if(confirm('삭제하시겠습니까?\n학생의 출결상황도 모두 삭제됩니다.')) {
		location.href = "<?=gpf_rb_url('delete_student', true)?>&rb_class=<?=$rb_class?>&sid=" + sid;
	}
}

function edit_student(sid) {	
	$("#btn_submit").val('수정하기');
	$("#btn_cancel").show();
	$("input[name=md]").val('u');
	$("input[name=student_id]").val(sid);
	$("input[name=student_name]").val($("#rb_name_"+sid).text());
	$("select[name=student_sex]").val($("#rb_sex_"+sid).text());
	$("input[name=student_school]").val($("#rb_school_"+sid).text());
	$("select[name=student_grade]").val($("#rb_grade_"+sid).text());
	saved_pos = $(window).scrollTop();
	$("input[name=student_name]").focus();
}

function cancel_edit() {
	$("#btn_submit").val('만들기');
	$("#btn_cancel").hide();
	$("input[name=md]").val('w');
	$("input[name=student_id]").val(-1);
	$("input[name=student_name]").val('');
	$("select[name=student_sex]").val('남');
	$("input[name=student_school]").val('');
	$("select[name=student_grade]").val(1);	
	$(window).scrollTop(saved_pos);
}

</script>

