<?
/**
 * 
 * 리토리(Read History) 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginReatory extends GPFPlugin 
{	
	var $db_table = 'gpf_reatory';

	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("PRE_VIEW", $this, "on_view");
		$gpf->addHelper("readers", $this, "readers");
		$gpf->addHelper("reads", $this, "reads");
	}

	/**
	 * 게시물을 본 사용자들
	 */
	public function readers($bo_table, $wr_id, $limit = 30)
	{
		$g4 = $GLOBALS['g4'];
		$member = $GLOBALS['member'];
		$readers = array();
		$res = sql_query("SELECT rt.*, mt.mb_nick, mt.mb_name, mt.mb_email, mt.mb_homepage FROM {$this->db_table} AS rt LEFT JOIN {$g4['member_table']} AS mt ON rt.mb_id = mt.mb_id WHERE bo_table = '$bo_table' AND wr_id = '$wr_id' AND rt.mb_id <> '{$member['mb_id']}' ORDER BY id DESC LIMIT $limit");
		while($row = sql_fetch_array($res))
		{
			array_push($readers, $row);
		}
		return $readers;
	}

	/**
	 * 게시물을 본 사용자들이 본 최근 게시물
	 */
	public function reads($bo_table, $wr_id, $limit = 5)
	{
		$g4 = $GLOBALS['g4'];
		$member = $GLOBALS['member'];
		$reads = array();
		$res = sql_query("SELECT rt.bo_table, rt.wr_id, rt.bo_subject, rt.wr_subject FROM {$this->db_table} AS rt LEFT JOIN {$g4['board_table']} AS bt ON rt.bo_table = bt.bo_table WHERE mb_id !=  '{$member['mb_id']}' AND bt.bo_read_level <= {$member['mb_level']} AND ( rt.bo_table <> '$bo_table' AND rt.wr_id <> '$wr_id' ) ORDER BY id DESC LIMIT $limit");

		while($row = sql_fetch_array($res))
		{
			array_push($reads, $row);
		}
		return $reads;
	}


	/**
	 * 글 보기시 로그 생성
	 */
	public function on_view($event, $g)
	{
		$member = $g['member'];
		$view = $g['view'];
		$bo_table = $g['bo_table'];
		$wr_id = $g['wr_id'];
		$g4 = $g['g4'];
		$board = $g['board'];
		
		if(!$member['mb_id']) return;
		
		$bo_subject = mysql_real_escape_string($board['bo_subject']);
		$wr_subject = mysql_real_escape_string($view['wr_subject']);

		sql_query("DELETE FROM {$this->db_table} WHERE bo_table = '$bo_table' AND mb_id = '{$member['mb_id']}' AND wr_id = {$wr_id}");
		sql_query("INSERT INTO {$this->db_table} SET bo_table = '$bo_table', mb_id = '{$member['mb_id']}', wr_id = {$wr_id}, bo_subject = '$bo_subject', wr_subject = '$wr_subject', reg_date = '{$g4['time_ymdhis']}'");
		
	}

}
?>
