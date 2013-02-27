<?
/**
 * 
 * 팝업 관리 플러그인 정보
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @original 탑스쿨님의 팝업관리 v 1.7 (http://topschool.co.kr/topboard/bbs/board.php?bo_table=plugin_popup&wr_id=85)
 * @author	byfun (http://byfun.com)
 */
 
if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoPopup extends GPFPluginInfo 
{
	
	var $popup_table;

	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();
		
		$this->version = "2013-02-27";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://lovelyus.net/axis/gpf_plugin.php?plugin=팝업";
		$this->popup_table = $GLOBALS['g4']['table_prefix'] . "topschool_popup"; // 팝업창 관리 테이블
		$this->label = "팝업관리";
	}


	/**
	 * 
	 * 플러그인 설명
	 * 
	 * @return string 플러그인설명
	 */
	public function getDescription()
	{
		return "<a href='http://topschool.co.kr' target='_blank' style='color:blue'>탑스쿨</a>님의 팝업관리 버전 1.7을 GPF에 적용한 플러그인입니다. (<a href='http://topschool.co.kr/topboard/bbs/board.php?bo_table=plugin_popup&wr_id=85' target='_blank'>원본링크</a>)";
	}


	public function shouldInstall()
	{
		return !$this->table_exists($this->popup_table);
	}

	public function shouldUninstall()
	{
		return $this->table_exists($this->popup_table);
	}

	public function shouldSetup()
	{
		return false;
	}

	public function install()
	{
		$sql="
			CREATE TABLE `".$this->popup_table."` (
			`po_id` int(11) NOT NULL auto_increment,
			`po_skin` varchar(255) NOT NULL default '',
			`po_dir` varchar(255) NOT NULL default '',
			`po_popstyle` tinyint(1) NOT NULL default '0',
			`po_openchk` tinyint(1) NOT NULL default '0',
			`po_start_date` varchar(19) NOT NULL default '',
			`po_end_date` varchar(19) NOT NULL default '',
			`po_expirehours` int(4) NOT NULL default '0',
			`po_scrollbar` tinyint(1) NOT NULL default '0',
			`po_leftcenter` tinyint(1) NOT NULL default '0',
			`po_topcenter` tinyint(1) NOT NULL default '0',
			`po_left` int(4) NOT NULL default '0',
			`po_top` int(4) NOT NULL default '0',
			`po_width` int(4) NOT NULL default '0',
			`po_height` int(4) NOT NULL default '0',
			`po_act` varchar(25) NOT NULL default '',
			`po_actc` varchar(25) NOT NULL default '',
			`po_delay` int(11) NOT NULL default '0',
			`po_subject` varchar(255) NOT NULL default '',
			`po_content` text NOT NULL,
			`po_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`po_id`),
			KEY `po_date` (`po_start_date`,`po_end_date`),
			KEY `po_openchk` (`po_openchk`)
			) TYPE=MyISAM ;
		";
		sql_query($sql);
	}

	public function uninstall()
	{
		sql_query("DROP TABLE ". $this->popup_table ."");
	}

	/**
	 * DB table이 존재하는가
	 */
	protected function table_exists ($table) {
		$mysql_db = $GLOBALS['mysql_db'];
		$tables = mysql_list_tables ($mysql_db);
		while (list ($temp) = mysql_fetch_array ($tables)) {
			if ($temp == $table) {
				return TRUE;
			}
		}
		return FALSE;
	}

}
?>
