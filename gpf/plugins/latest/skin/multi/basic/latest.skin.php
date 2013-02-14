<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
$title = ( isset($options['title']) ? $options['title'] : '최신글' );
?>
<div class='simple_latest'>

	<div class='sl_head'>
		<b><?=$title?></b>
	</div>

	<hr style='border:1px solid black;'/>

	<ul>
	<? for ($i=0, $to=count($list); $i<$to; $i++) { ?>
	<li>
		<div class="sl_fl">
		<?
		echo $list[$i]['icon_reply'] . " ";
		echo "<a href='{$list[$i]['href']}'>";
		if ($list[$i]['is_notice']) echo "<b>{$list[$i]['subject']}</b>";
		else echo "{$list[$i]['subject']}";
		echo "</a>";

		if ($list[$i]['comment_cnt'])  echo " <a href=\"{$list[$i]['comment_href']}\"><span class='sl_cmt'>{$list[$i]['comment_cnt']}</span></a>";

		echo " " . $list[$i]['icon_new'];
		?>
		</div>
		<div class="sl_fr" style="margin-right:5px"><?=$list[$i]['datetime2']?></div>
	</li>
	<? } ?>
	</ul>

</div>


