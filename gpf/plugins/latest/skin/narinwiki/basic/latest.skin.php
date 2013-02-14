<?
if (!defined("_GNUBOARD_")) exit;

$options[new_day] = ($options[new_day] ? $options[new_day] : 2);
?>

<div class='simple_latest'>

	<div class='sl_head'>
		<a href="<?=$g4['bbs_path']?>/board.php?bo_table=<?=$bo_table?>" class="sl_fr">more</a>
		<a href="<?=$g4['bbs_path']?>/board.php?bo_table=<?=$bo_table?>"><b><?=$label?></b></a>
	</div>

	<hr style='border:1px solid black;'/>

	<ul>
	<? for($i=0, $to=count($list); $i<$to; $i++) { //$list as $k=>$v) { 
		$row = $list[$i];
		$doc = ($row['ns'] == "/" ? "" : $row['ns']) ."/". $row['docname']; 
	?>				

	<li>
		<div class="sl_fl">
			<a href="<?=$row['href']?>" title="<?=addslashes($doc)?>" ><?=$row['docname']?></a>
		</div>
		<div class="sl_fr" style="margin-right:5px"><?=substr($row['reg_date'],5,5)?></div>
	</li>
	<? } ?>
	</ul>

</div>
