<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$selected[$pageid] = " class='selected'";
?>

<style type="text/css">
/* tab */
.rb_tab { width:100%;margin:auto auto; margin-bottom:10px; }
.rb_tab ul {list-style: none;padding: 0;margin: 0; border-bottom:1px solid #ccc; width:100%;}
.rb_tab li {float: left; margin-right:2px; border: 1px solid #fff;border-bottom-width: 0;margin: 0;}
.rb_tab a {text-decoration: none;display: block;;background-color:#f0f0f0;padding: 5px 8px;color: #888;text-align: center;}
.rb_tab a:hover {background:#C0C0C0; color:#555;}
.rb_tab .selected { border-color: #ccc;}
.rb_tab .selected a {position: relative;top: 1px;background:#fff;color:#555; ;font-weight: bold;}
</style>

<div class="rb_tab"> 
	<ul class="clearfix"> 
		<li<?=$selected['front']?>><a href="<?=gpf_rb_adm_url('index')?>">출석부 프로그램</a></li>	
		<li<?=$selected['config']?>><a href="<?=gpf_rb_adm_url('config')?>">설정</a></li>	
		<li><a href="<?=gpf_rb_url('index')?>">출석부보기</a></li>	
	</ul> 
</div> 

<div id="rb_admin">
