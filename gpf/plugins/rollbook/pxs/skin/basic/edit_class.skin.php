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
.desc {  margin-left:10px; margin-top:8px; color:red; }
</style>
	
<h2>'<?=$class['class_name']?>' 관리</h2>

<h3> 이름 변경 </h3>
<div class="rb_section">
<form name="groupfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="edit_class"/> 
<input type="hidden" name="class_id" value="<?=$rb_class?>"/> 
<input type="hidden" name="md" value="u"/> 
클래스명 : <input type="text" name="class_name" value="<?=$class['class_name']?>" size="20"/> 
<span class="button black"><input type="submit" value="수정"></span>
</form>
</div>

<h3> 새 클래스로 복사 </h3>
<div class="rb_section">
그룹 : <select id="new_group_id">
	<?
	foreach($groups as $k=>$gr) {
		echo "<option value=\"{$gr['id']}\">{$gr['name']}</option>";		
	}
	?>
</select> <br/>
새 클래스명 : <input type="text" id="new_class_name" size="20"/> 
<span class="button blue"><a href="javascript:copy_class();">클래스복사</a></span>
<span class="desc">클래스의 학생정보를 복사해서 새로운 클래스를 만듭니다.</span>
</div>

<h3> 백업 및 복원 </h3>
<div class="rb_section">
<span class="button green"><a href="javascript:backup_class();">클래스백업 및 복원</a></span>
<span class="desc">클래스의 현재 학생정보, 교사정보, 출석정보를 백업하거나 복원합니다. </span>
</div>

<h3> 삭제</h3>
<div class="rb_section">
<span class="button red"><a href="javascript:delete_class();">클래스삭제</a></span>
<span class="desc">클래스 삭제를 하면 클래스에에 포함된 모든 학생, 출결 정보, 백업이 함께 삭제됩니다.</span>
<div id="delete_confirm" style="display:none">
	열쇠글 확인 : <input type="password" id="rb_passwd" size="12"/> <span class="button red"><input type="button" id="rb_btn_del" value="삭제하기"/></span>
</div>
</div>

<div style="border-top:1px solid #ccc;padding:10px 0;">
	<span class="button"><a href="<?=gpf_rb_url('class')?>&rb_class=<?=$rb_class?>">출석부 보기</a></span>
</div>

<script type="text/javascript">
$(document).ready(function() {
	$("input[name='group_name']").focus();
	$("#new_class_name").keypress(function(evt) {
		if(evt.which == 13){
			copy_class();
		}
	});
	$("#rb_btn_del").click(function() {
		if(confirm("삭제하시겠습니까?")) {
			location.href = "<?=gpf_rb_url('edit_class', true)?>&md=d&class_id=<?=$rb_class?>&rb_passwd="+$("#rb_passwd").val();
		}		
	});
});	

function check_form(f) {	
	if($.trim($("input[name=class_name]").val()) == '') {
		alert('클래스명을 입력하세요');
		$("input[name=class_name]").focus();
		return false;
	}
	return true;
}

function delete_class() {
	$("#delete_confirm").toggle();
}

function backup_class() {
		location.href = "<?=gpf_rb_url('backup_class')?>&rb_class=<?=$rb_class?>";
}

function copy_class() {
	cele = $("#new_class_name");
	cname = $.trim(cele.val());
	new_group_id = $("#new_group_id").val();
	if(!cname) {
		alert('새 클래스명을 입력하세요');
		return;
	}

	if(confirm("클래스를 복사하시겠습니까?")) {
		location.href = "<?=gpf_rb_url('edit_class', true)?>&md=cp&class_id=<?=$rb_class?>&gr_id="+new_group_id+"&class_name="+cname;
	}	
}
</script>
