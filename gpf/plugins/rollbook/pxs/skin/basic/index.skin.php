<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 */

if(!defined("__RB__")) die("잘못된 접근입니다.");

?>
<style type="text/css">
#rb_toolbar { position:absolute;right:5px;margin-top:-25px; }
.rb_group { width:100%;padding:0 0 10px 0; margin-top:10px; border-top:1px solid #ccc }
.rb_group h2 { margin:0; padding:5px; background-color:#eee; }
.rb_group_tool { float:right; margin-top:5px; margin-right:5px;}
.rb_class li { padding:3px 0; }
</style>

<div id="rb_toolbar">	
	<? if($is_teacher) { ?>
	<span class="button black small"><a href="<?=gpf_rb_url('add_group')?>">그룹추가</a></span>
	<? } ?>
	<? if($is_admin == 'super') { ?>
	<span class="button black small"><a href="<?=$g4['admin_path']?>/gpf/plugin_setup.php?p=rollbook">관리</a></span>
	<? } ?>
</div>
	
<div id="rb_groups">
		<? 
		foreach($rb_groups as $group_name => $gr) { 
		?>
		
		<div class="rb_group clear">
			
			<div class="rb_group_tool">
				<? if($is_teacher) { ?>
				<span class="button"><a href="<?=gpf_rb_url('add_class')?>&rb_group=<?=$gr['group_id']?>">클래스추가</a></span>
				<span class="button"><a href="<?=gpf_rb_url('edit_group')?>&rb_group=<?=$gr['group_id']?>">그룹관리</a></span>
				<? } ?>
				<span class="button"><a href="<?=gpf_rb_url('group')?>&rb_group=<?=$gr['group_id']?>">그룹보기</a></span>
			</div> <!--// rb_group_tool -->
			
			<h2><?=$group_name?></h2>
			
			<ul class="rb_class">			
			<? foreach($gr['classes'] as $i => $class) {			?>
					<li><a href="<?=gpf_rb_url('class')?>&rb_class=<?=$class['class_id']?>"><?=$class['class_name']?></a></li>
			<? } // inner foreach ?>
			</ul> <!--// rb_class -->
						
		</div> <!--// rb_group -->
		
		<? 
		} // foreach
	 ?>
	
</div>

