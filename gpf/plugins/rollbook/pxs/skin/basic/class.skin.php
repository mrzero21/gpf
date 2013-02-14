<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");
?>

<style type="text/css">
#rb_toolbar { position:absolute;right:5px;margin-top:-30px;}
#rb_book #rb_teacher { padding:5px;text-align:left; }
#rb_book { width:100%; border-bottom:1px solid #dddee2;background-color:#ccc; font-size:12px;table-layout:fixed}
#rb_book th { background-color:#eee; padding:5px 2px; text-align:center;}
#rb_book td { background-color:#fff; text-align:center;}
#rb_book tbody th { background-color:#fff;}
#rb_book .rb_num,
#rb_book .rb_grade { font-weight:normal}
#rb_book .rb_link { display:block;  padding:5px 2px;}
#rb_book .rb_link:hover { background-color:#ccc; text-decoration:none;}
#rb_book .rb_year { background-color:#eee; font-weight:bold}
#rb_book .rb_month {background-color:#f5f5f5}
#rb_book .rb_date {}
#rb_book .rb_alt {background-color:#f5f5f5;}
</style>

<h2><?=$class['class_name']?> 출석부 </h2>

<div id="rb_toolbar">	
	<? if($is_teacher) { ?>
	<span class="button"><a href="javascript:check_state();" id="btn_check">출결상황체크</a></span>
	<span class="button"><a href="<?=gpf_rb_url('teacher')?>&rb_class=<?=$rb_class?>">교사관리</a></span>
	<span class="button"><a href="<?=gpf_rb_url('student')?>&rb_class=<?=$rb_class?>">학생관리</a></span>
	<span class="button"><a href="<?=gpf_rb_url('rollbook')?>&rb_class=<?=$rb_class?>">출석부관리</a></span>
	<span class="button"><a href="<?=gpf_rb_url('edit_class')?>&rb_class=<?=$rb_class?>">클래스관리</a></span>
	<? } ?>
	<select id='order_select' onchange="change_order();">
		<option value="">기본정렬</option>
		<option value="name,asc">이름순 (ㄱ->ㅎ)</option>
		<option value="name,desc">이름순 (ㅎ->ㄱ)</option>
		<option value="grade,asc">구분순 (ㄱ->ㅎ)</option>
		<option value="grade,desc">구분순 (ㅎ->ㄱ)</option>
		<option value="attend,asc">출석순 (1->9)</option>
		<option value="attend,desc">출석순 (9->1)</option>
	</select>

</div>

<table id="rb_book" cellspacing="1" cellpadding="0" border="0">
<colgroup>
	<col width="30px">
	<col width="50px">
	<col width="30px">
	<col width="30px">
	<? for($i=0;$i<$date_count;$i++) {?><col width="28px"><?}?>
	<col width="40px">
	<col>
</colgroup>
<thead>	
	<tr>
		<td id="rb_teacher" colspan="<?=($date_count+6)?>">
			<? if(count($teachers)) { ?>
				<b>선생님</b> : 
				<? 
				for($i=0; $i<count($teachers); $i++) {
					echo $teachers[$i]['name']; 
					if($i<count($teachers)-1) echo ", "; 
				} 
				?>
			<?}?>			
			<span style="float:right">(<?=$rb['enum_stat']['1']?> : 출석, <?=$rb['enum_stat']['-1']?> : 결석, <?=$rb['enum_stat']['0']?> : 정원에 포함되지 않음)</span>
		</td>
	</tr>
		
	<tr>
		<th rowspan="3" colspan="3" class="bt">구분</th>	
		<th>연</th>	
		<? foreach($year_count as $year => $count) { ?>
		<td class="rb_year" <?=($count>1?" colspan=".($count):"")?>><?=$year?></td>	
		<? } ?>
		<th rowspan="3" class="bt">계</th>	
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th>월</th>	
		<? foreach($month_count as $month => $count) { ?>
		<td class="rb_month"<?=($count>1?" colspan=".($count):"")?>><?=substr($month, 5, 2)?></td>	
		<? } ?>
		<td>&nbsp;</td>
	</tr>	
	<tr>
		<th class="bt">일</th>	
		<? for($c=0; $c<$date_count; $c++) { ?>
			<td class="bt rb_date"><?=substr($dates[$c]['date'], -2)?></td>
		<? } // col ?>
		<td class="bt">&nbsp;</td>
	</tr>
</thead>

<tbody>	
	<? for($r=0; $r<$student_count; $r++) { $rb_style = ($r%2 == 0 ? "rb_line" : " rb_alt"); ?>
	<tr>
		<th class="rb_num <?=$rb_style?>"><?=($r+1)?></th>
		<th class="rb_num <?=$rb_style?>"><?=$students[$r]['grade']?></th>
		<th class="<?=$rb_style?>" colspan="2"><?=$students[$r]['name']?></th>
		<? $sub_total = 0; for($c=0; $c<$date_count; $c++) { ?>
			<td class="<?=$rb_style?>">
				<? 
				echo "<a class='rb_link' title=\"".addslashes($students[$r]['name']).", ". $dates[$c]['date']."\" id='rb_link_{$students[$r]['id']}_".(str_replace("-", "", $dates[$c]['date']))."' href='javascript:".($is_teacher ? "rollbook()":"").";' code='{\"sid\":\"{$students[$r]['id']}\", \"date\":\"{$dates[$c]['date']}\", \"sname\":\"".addslashes($students[$r]['name'])."\", \"stat\":\"{$table[$c][$r]}\"}'>{$rb['enum_stat'][$table[$c][$r]]}</a>"; 
				if($table[$c][$r] == 1) $sub_total++; 
				?>
			</td>
		<? } // col ?>
		<td class="<?=$rb_style?>" id="rb_stotal_<?=$students[$r]['id']?>"><?=$sub_total?></td>
		<td class="<?=$rb_style?>">&nbsp;</td>
	</tr>		
	<? } // row ?>
</tbody>

<tfoot>
	<tr>
		<th colspan="3" rowspan="3" style="line-height:160%">
			계<br/>
			(총<?=$student_count?>명, <?=$date_count?>일)
		</th>
		<th>출석</th>
		<? 
		$all_total = 0; 
		for($c=0; $c<$date_count; $c++) { 
			$all_total += $total[$c]; 
			$d = str_replace("-", "", $dates[$c]['date']);
		?>
			<td class="rb_dtotal" id="rb_dtotal_<?=$d?>"><?=$total[$c]?></td>
		<? } // col ?>
		<th id="rb_all_total"><?=$all_total?></th>
		<td>&nbsp;</td>
	</tr>		
	<tr>
		<th>결석</th>
		<? 
		for($c=0; $c<$date_count; $c++) { 
			$d = str_replace("-", "", $dates[$c]['date']);
		?>
			<td class="rb_abtotal" id="rb_abtotal_<?=$d?>" code="<?=$d?>">&nbsp;</td>
		<? } // col ?>
		<th id="rb_aball_total">&nbsp;</th>
		<td>&nbsp;</td>		
	</tr>	
	<tr>
		<th>정원</th>
		<? 
		$all_total = 0;
		for($c=0; $c<$date_count; $c++) { 
			$all_total += $quota[$c]; 
			$d = str_replace("-", "", $dates[$c]['date']);
		?>
			<td class="rb_qtotal" id="rb_qtotal_<?=$d?>"><?=$quota[$c]?></td>
		<? } // col ?>
		<th id="rb_qall_total"><?=$all_total?></th>
		<td>&nbsp;</td>		
	</tr>
</tfoot>

</table><!--// rb_book -->

<script type="text/javascript">
	
	var check_mode = false;
	$(document).ready(function() {
		//check_state();
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
	});

	function bind_check_link() {
		
		$(".rb_link").click(function(evt) {
			
			evt.preventDefault();
			
			j = $.parseJSON($(this).attr('code'));
			
			$('.rb_popup').remove();
			
			var pop = $('<div></div>').attr('class', 'rb_popup')
											.attr('style', 'position:absolute;background-color:#fff;padding:5px;border:1px solid #333;width:220px;');
			
			$(this).before(pop);											
											
			$('<div></div>').attr('style', 'padding:5px; background-color:#efefef;').text(j.sname + ' @ ' + j.date + '').appendTo(pop);
			
			$('<div></div>').attr('style', 'padding:10px; background-color:#fff;').append(			
				$('<span></span>').attr('class', 'button green').attr('style', 'margin-right:5px').append(
					$('<a></a>').attr('href', 'javascript:;').text('출석').click(function() {
						do_update_status(j, 1);
					})
				)				
			).append(
				$('<span></span>').attr('class', 'button red').attr('style', 'margin-right:5px').append(
					$('<a></a>').attr('href', 'javascript:;').text('결석').click(function() {
						do_update_status(j, -1);
					})
				)				
			).append(
				$('<span></span>').attr('class', 'button').attr('style', 'margin-right:5px').append(
					$('<a></a>').attr('href', 'javascript:;').text('미정').click(function() {
						do_update_status(j, 100);
					})
				)				
			).append(
				$('<span></span>').attr('class', 'button black').append(
					$('<a></a>').attr('href', 'javascript:;').text('취소').click(function() {
						setTimeout(function() { $('.rb_popup').remove(); }, 50);
					})
				)				
			).appendTo(pop);
			
		});	
	}
	
	function do_update_status(j, stat) {	
			
			$('.rb_popup').remove();
			
			$.getJSON('<?=gpf_rb_url('update_checked', true)?>&cid=<?=$rb_class?>&sid='+j.sid+'&date='+j.date+'&stat='+stat, function(json) {

				if(json.code != 1) {
					alert('업데이트 실패 : ' + json.msg);
					return;
				}
				
				rlink = $("#rb_link_"+json.sid+"_"+json.date_n);		
				j = $.parseJSON(rlink.attr('code'));
				
				if(json.stat == 1) rlink.text('<?=$rb['enum_stat']['1']?>');
				else if(json.stat == 0) rlink.text('<?=$rb['enum_stat']['0']?>');
				else rlink.text('<?=$rb['enum_stat']['-1']?>');						
					
				new_stat = parseInt(json.stat);
				addon_present = 0;
				addon_total = 0;
				
				if(j.stat == '1' && new_stat != 1) {
					addon_present = -1;
				} else if(j.stat != '1' && new_stat == 1) {
					addon_present = 1
				} 
				
				if(j.stat == '0' && new_stat != 0) {
					addon_total = 1;
				} else if(j.stat != '0' && new_stat == 0 ) {
					addon_total = -1;
				} 
								
				rlink.attr('code', '{"sid":"'+json.sid+'", "date":"'+json.date+'", "sname":"' + j.sname +'", "stat":"'+json.stat+'"}');
				
				// 학생 개인 출석 합
				rsubtotal = $("#rb_stotal_"+json.sid);
				rsubtotal.text(parseInt(rsubtotal.text()) + addon_present);
				
				// 날짜별 출석 합
				rdtotal = $("#rb_dtotal_"+json.date_n);
				rdtotal.text(parseInt(rdtotal.text()) + addon_present);
				
				// 날짜별 출석 합의  총합
				rtotal = $("#rb_all_total");
				rtotal.text(parseInt(rtotal.text()) + addon_present);					
				
				// 날짜별 정원 합
				rqdtotal = $("#rb_qtotal_"+json.date_n);
				rqdtotal.text(parseInt(rqdtotal.text())+addon_total);
								
				// 날짜별 정원 합의 총합
				rqtotal = $("#rb_qall_total");
				rqtotal.text(parseInt(rqtotal.text())+addon_total);
				
				setTimeout(function() { update_absence_count(); }, 30);
				
			});				
	}
	
	function update_absence_count() {
		$(".rb_abtotal").each(function() {
			var d = $(this).attr('code');
			var a = parseInt($("#rb_dtotal_"+d).text());
			var t = parseInt($("#rb_qtotal_"+d).text());
			$(this).text(t-a);
		});
		var a = parseInt($("#rb_all_total").text());
		var t = parseInt($("#rb_qall_total").text());
		$("#rb_aball_total").text(t-a);
	}
			
	function rollbook() {
		alert('출결상황을 업데이트 하시려면\n상단의 "출결상황체크" 버튼을 클릭하시고 사용하세요.');
	}			
			
	function check_state() {
		
		ele = $("#btn_check");
		
		if(check_mode) {
			ele.text('출결상황체크');
			$(".rb_link").unbind('click');
			ele.parent().removeClass('red');
		} else {
			bind_check_link();
			ele.parent().addClass('red');			
			ele.text('출결상황보기');
		}
		
		check_mode = (check_mode ? false : true);		
	}

	function change_order()
	{
		location.href = '<?=gpf_rb_url('class')?>&rb_class=<?=$rb_class?>&ord='+$('#order_select').val();
	}

	$(document).ready(function() {
		update_absence_count();
		$('#order_select').val('<?=$ord?>');
	});
</script>
