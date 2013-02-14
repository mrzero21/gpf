<?
/* http://topschool.co.kr */
// 제작 : 정진호(topschool)
// 제작일 : 2008.08.10  //
// 팝업창 관리 라이브러리  //
// 해당 스킨은 수정후        //
// 재배포 하실수없습니다. //
// 자신이 제작하는 사이트를 위해서만 사용하세요 //

if (!defined('_GNUBOARD_')) exit;

function get_popup_contents($content){
	global $zindex, $rs;
	$content = str_replace("{zindex}", $zindex, $content);
	$content = str_replace("{title}", $rs[po_subject], $content);
	$content = str_replace("{content}", $rs[po_content], $content);
	$content = str_replace("{expirehours}", $rs[po_expirehours], $content);
	$content = str_replace("{id}", $rs[po_id], $content);
	$content = str_replace("{po_left}", $rs[po_left], $content);
	$content = str_replace("{po_top}", $rs[po_top], $content);
	$content = str_replace("{po_width}", $rs[po_width], $content);
	$content = str_replace("{po_height}", $rs[po_height], $content);
	
	if($rs[po_scrollbar] == "1"){
		$content = str_replace("{overflow}", "auto", $content);
	}else{
		$content = str_replace("{overflow}", "hidden", $content);
	}
	return $content;

}


// 팝업창
$zindex = 100;
$popcnt = 1;
$jscnt = 1;
$sql = "select * from $g4[popup_table] where po_start_date < '$g4[time_ymdhis]' and po_end_date > '$g4[time_ymdhis]' and po_openchk = '1'";
$result = sql_query($sql);
if ($result) {
	while($rs = sql_fetch_array($result)) {
		if ( ( $rs[po_dir] == $_SERVER[PHP_SELF] || !$rs[po_dir] || ($bo_table == $rs[po_dir] && strstr($_SERVER[PHP_SELF],"/bbs/board.php")) ) && !strstr($_SERVER[PHP_SELF],"/viewpop.skin.php") ) {
			if($jscnt == 1){
				echo "<script src=\"".GPF_PATH."/plugins/popup/skin/{$rs[po_skin]}/popup_control.js\"></script>";
				$jscnt++;
			}
			if (trim($_COOKIE["it_ck_pop_".$rs[po_id]]) != "done") {
				$popup_skin_path = GPF_PATH."/plugins/popup/skin/$rs[po_skin]";
				if($rs[po_popstyle] == "1"){
					ob_start("get_popup_contents");
					include("$popup_skin_path/viewlayer.skin.php");
					ob_end_flush();
				}else{
					echo "<script>\n";
					if($popcnt == 1){
						echo "function popup(url,scroll,po_left,po_top,po_width,po_height,popname) {\n";
						if($rs[po_leftcenter])
						echo "po_left = (screen.width / 2) + po_left;";
						if($rs[po_topcenter])
						echo "po_top = (screen.height / 2) + po_top;";
						echo "var settings = 'left='+po_left+','\n";
						echo "settings += 'top='+po_top+','\n";
						echo "settings += 'width='+po_width+','\n";
						echo "settings += 'height='+po_height+','\n";
						echo "settings += 'scrollbars='+scroll+','\n";
						echo "window.open(url,popname,settings);";
						echo "\n}\n";
						$popcnt++;
					}
					echo "if(!opener) popup(\"".GPF_PATH."/px.php?m=popup&po_id={$rs[po_id]}\",$rs[po_scrollbar],$rs[po_left],$rs[po_top],$rs[po_width],$rs[po_height],\"pop{$zindex}\");\n";
					echo "</script>";
				}
				$zindex++;
			}
		}
	}
}

?>