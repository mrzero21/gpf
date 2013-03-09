<?
/**
 * 
 * 리토리(Read History) 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoReatory extends GPFPluginInfo 
{
	var $db_table = 'gpf_reatory';

	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();
	
		$this->version = "2013-02-27";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://lovelyus.net/axis/gpf_plugin.php?plugin=reatory";

		$this->label = "리토리 (Read History)";
	}

	public function shouldInstall()
	{
		return !$this->table_exists($this->db_table);
	}

	public function shouldUninstall()
	{
		return $this->table_exists($this->db_table);
	}

	public function shouldSetup()
	{
		return false;
	}

	public function install()
	{
		$sql="
			CREATE TABLE `".$this->db_table."` (
			`id` int(11) NOT NULL auto_increment,
			`mb_id` varchar(255) NOT NULL default '',
			`bo_table` varchar(255) NOT NULL default '',
			`wr_id` int(11) NOT NULL default '0',
			`bo_subject` varchar(255) NOT NULL default '',
			`wr_subject` varchar(255) NOT NULL default '',
			`reg_date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY (`id`)
			) TYPE=MyISAM ;
		";
		sql_query($sql);
	}

	public function uninstall()
	{
		sql_query("DROP TABLE ". $this->db_table ."");
	}

	/**
	 * DB table이 존재하는가
	 */
	protected function table_exists ($table) {
		$mysql_db = $GLOBALS['mysql_db'];

		$res = sql_query("SHOW TABLES FROM $mysql_db");
		while ($row = mysql_fetch_array ($res)) {
			if ($row[0] == $table) {
				return TRUE;
			}
		}
		return FALSE;
	}

	/**
	 * 
	 * 플러그인 설명
	 * 
	 * @return string 플러그인설명
	 */
	public function getDescription()
	{
		return <<<EOF
			사용자가 게시물을 읽은 기록들을 남깁니다. \$gpf->readers(\$bo_table, \$wr_id, \$count), \$gpf->reads(\$bo_table, \$wr_id, \$count) 두 도움 함수를 이용해 스킨에 적용할 수 있습니다.
EOF;
	}
}
?>
