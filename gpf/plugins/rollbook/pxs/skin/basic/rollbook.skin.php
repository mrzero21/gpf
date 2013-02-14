<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");
?>
<script type="text/javascript">
jQuery(function($){
	$.datepicker.regional['ko'] = {
		closeText: '닫기',
		prevText: '이전달',
		nextText: '다음달',
		currentText: '오늘',
		monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
		'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월',
		'7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
		dayNamesShort: ['일','월','화','수','목','금','토'],
		dayNamesMin: ['일','월','화','수','목','금','토'],
		weekHeader: 'Wk',
		dateFormat: 'yy-mm-dd',
		firstDay: 0,
		isRTL: false,
		showMonthAfterYear: true,
		yearSuffix: ''};
		
	$.datepicker.setDefaults($.datepicker.regional['ko']);
	
});

function set_datepicker(ele)
{
	ele.datepicker({
		showOn: 'button',
		buttonImage: '<?=$rb['path']?>/imgs/calendar_icon.gif',
		buttonImageOnly: true,
		buttonText: "달력",
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		yearRange: 'c-99:c+99',
		maxDate: '+365d'
	}); 
}		
</script>
<style type="text/css">
#rb_toolbar { float:right; }
#rb_form { border-bottom:1px solid #ccc; padding:5px;}
#rb_books { margin-top:10px; width:320px; border-bottom:1px solid #dddee2;background-color:#ccc; font-size:12px;table-layout:fixed}
#rb_books th { background-color:#eee; padding:5px; text-align:center;}
#rb_books td { background-color:#fff; padding:5px; text-align:center;}
</style>

<h2>'<?=$class['class_name']?>' 클래스에 출석부 추가</h2>

<div id="rb_form">
<form name="studentfrm" action="<?=GPF_PATH?>/px.php" method="post" onsubmit="return check_form(this);">
<input type="hidden" name="m" value="rollbook.exe"/> 
<input type="hidden" name="c" value="add_rollbook"/> 
<input type="hidden" name="class_id" value="<?=$rb_class?>"/> 
날짜선택 : <input type="text" name="rollbook_date" readonly/>
<span class="button black"><input type="submit" id="btn_submit" value="만들기"></span>
<span class="button"><a href="<?=gpf_rb_url('class')?>&rb_class=<?=$rb_class?>">출석부보기</a></span>
</form>
</div>

<table id="rb_books" cellspacing="1" cellpadding="0" border="0">
	<colgroup>
		<col width="80px">
		<col width="50px">
	</colgroup>
<thead>
	<tr>
		<th>날짜</th>
		<th>&nbsp;</th>
	</tr>	
</thead>
<tbody>
	<? foreach($books as $k=>$book) {?>
	<tr>
		<td><?=$book['date']?></td>
		<td><span class="button"><a href="javascript:delete_rb(<?=$book['id']?>);">삭제</a></span></td>
	</tr>
	<? } ?>
</tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {
	set_datepicker($("input[name='rollbook_date']"));
});		

function check_form(f) {	
	if($.trim($("input[name=rollbook_date]").val()) == '') {
		alert('날짜를 선택하세요');
		return false;
	}
	return true;
}

function delete_rb(bid) {	
	if(confirm('삭제하시겠습니까?\n출결상황도 함께 삭제됩니다.')) {
		location.href = "<?=gpf_rb_url('delete_rollbook', true)?>&rb_class=<?=$rb_class?>&bid=" + bid;
	}
}
</script>
