<?
/**
 * 
 * 팝업 관리 플러그인
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @original 탑스쿨님의 팝업관리 v 1.7 (http://topschool.co.kr/topboard/bbs/board.php?bo_table=plugin_popup&wr_id=85)
 * @author	byfun (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginPopup extends GPFPlugin 
{	
	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAdmin($menu_id = "popup", $label = "팝업관리", $obj = $this, $handler = "popup_admin");
		$gpf->addAction("HEAD_SCRIPT", $this, "on_head");
		$gpf->addPx($px = 'popup', $obj = $this, $handler = "on_popup");
		$GLOBALS['g4']['popup_table'] = $GLOBALS['g4']['table_prefix'] . "topschool_popup"; // 팝업창 관리 테이블
	}

	/**
	 * 페이지 로드 시
	 */
	public function on_head($event, $g)
	{
		extract($g);
		include_once $this->getPluginPath()."/lib/popup.lib.php";
	}

	/**
	 * 관리자 뷰 페이지
	 */
	public function popup_admin()
	{
		extract($GLOBALS);
		extract($_GET);
		extract($_POST);
		if(!$m) $m = "popup_list";
		$plugin_path = $this->getPluginPath();
		$inc_file = $plugin_path."/inc/".basename($m).".php";
		if(file_exists($inc_file)) include_once $inc_file;
		else alert('잘못된 접근입니다.');
	}

	public function on_popup($m)
	{
		extract($GLOBALS);
		$add = ( $preview == "1" ? "" : " AND po_openchk = '1'" );
		$rs = sql_fetch("SELECT * FROM {$g4['popup_table']} WHERE po_id = '$po_id' $add");
		if(!$rs) {
			?>
			<script type="text/javascript">
				self.close();
			</script>
			<?
		}
		$popup_skin_path = $this->getPluginPath()."/skin/{$rs['po_skin']}";
		$g4['title'] = $rs['po_subject'];
		include_once $popup_skin_path . "/viewpop.skin.php";
	}


}
?>
