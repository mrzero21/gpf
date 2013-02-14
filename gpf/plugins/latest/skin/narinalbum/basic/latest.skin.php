<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>
<div class='simple_latest'>

	<div class='sl_head'>
		<a href="<?=$na_url?>" class="sl_fr">more</a>
		<a href="<?=$na_url?>"><b><?=$label?></b></a>
	</div>

	<hr style='border:1px solid black;'/>
	
	<div class='sl_clear'>
	<? for($i=0, $to=count($list); $i<$to; $i++) { ?>
		<div style="float:left;margin-right:5px;;width:<?=$list[$i][$thumb.'_width']?>px;">
			<a href="<?=$na_url?>/photo.php?pid=<?=$list[$i]['photo_id']?>">
				<img src="<?=$list[$i][$thumb]?>" style="border:0"/>
			</a>
			<p style="text-align:center; font-size:9pt; color:#888;"><?=$list[$i]['title']?></p>
		</div>
	<? } ?>
	</div>

</div>
