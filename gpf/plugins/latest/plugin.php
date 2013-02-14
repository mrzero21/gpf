<?
/**
 * 
 * 최신글 도우미 헬퍼 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginLatest extends GPFPlugin
{
	public function regist($gpf)
	{
		$gpf->addHelper($name = "latest", $obj = $this, $func = "latest");
		$gpf->addHelper($name = "latest_array", $obj = $this, $func = "latest_array");
		$gpf->addHelper($name = "latest_array_comment", $obj = $this, $func = "latest_array_comment");
		$gpf->addHelper($name = "latest_narinwiki", $obj = $this, $func = "narinwiki_latest");		
		$gpf->addHelper($name = "latest_narinalbum", $obj = $this, $func = "narinalbum_latest");		
	}

	// 최신글 추출
	function latest($skin_dir="", $bo_table, $rows=10, $subject_len=40, $options="")
	{
		$g4 = $GLOBALS['g4'];

		if ($skin_dir)
			$latest_skin_path =  GPF_PATH."/plugins/".$this->id."/skin/single/$skin_dir";
		else
			$latest_skin_path =  GPF_PATH."/plugins/".$this->id."/skin/single/basic";

		$list = array();

		$sql = " select * from $g4[board_table] where bo_table = '$bo_table'";
		$board = sql_fetch($sql);

		$tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
		//$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_id desc limit 0, $rows ";
		// 위의 코드 보다 속도가 빠름
		$sql = " select * from $tmp_write_table where wr_is_comment = 0 order by wr_num limit 0, $rows ";
		//explain($sql);
		$result = sql_query($sql);
		for ($i=0; $row = sql_fetch_array($result); $i++) 
			$list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);
		
		ob_start();
		include "$latest_skin_path/latest.skin.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	} 

	// 최신글 추출
	function latest_array($skin_dir="", $bo_tables=array(), $rows=10, $subject_len=40, $options="")
	{
		return $this->_latest_array($skin_dir, $bo_tables, $rows, $subject_len, $options, false);
	}

	public function latest_array_comment($skin_dir="", $bo_tables, $rows=10, $subject_len=40, $options="")
	{
		return $this->_latest_array($skin_dir, $bo_tables, $rows, $subject_len, $options, true);
	}

	protected function _latest_array($skin_dir="", $bo_tables=array(), $rows=10, $subject_len=40, $options="", $is_comment = false)
	{
		$g4 = $GLOBALS['g4'];

		if ($skin_dir)$latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/multi/$skin_dir";
		else $latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/multi/basic";

		$list = array();
	
		$qry_bo_search=" bo_table in(";
		for($i=0; $i<count($bo_tables); $i++) {
			$bo_table=$bo_tables[$i];
			$qry_bo_search .= "'$bo_table'";
			if($i<count($bo_tables)-1) $qry_bo_search .= ", ";
		  }
		$qry_bo_search .= ")";

		$add_where = ( $is_comment ? " wr_id <> wr_parent " : " wr_id = wr_parent" );
		$sql = "SELECT bo_table, wr_parent as wr_id FROM {$g4['board_new_table']} WHERE $add_where AND $qry_bo_search GROUP BY bo_table, wr_parent ORDER BY bn_id DESC LIMIT 0,$rows";
		$result = sql_query($sql);

		for ($i=0; $row = sql_fetch_array($result); $i++) {
			$bo_table = $row['bo_table'];
			$write_table=$g4['write_prefix'].$bo_table;			
			$board_sql = " select * from {$g4['board_table']} where bo_table = '$bo_table'";
			$board = sql_fetch($board_sql);			
			$row = sql_fetch("select * from $write_table where wr_id='$row[wr_id]' ");			
			$list[$i] = get_list($row, $board, $latest_skin_path, $subject_len);
			$list[$i]['bo_table'] = $bo_table;
			$list[$i]['bo_subject'] = $board['bo_subject'];
		}

		ob_start();
		include "$latest_skin_path/latest.skin.php";
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}

	// 나린위키 최신글 추출
	function narinwiki_latest($skin_dir="", $wiki_path, $wiki_url, $label, $bo_table, $rows=10, $subject_len=40, $options="")
	{
		$g4 = $GLOBALS['g4'];
		
		include_once "lib/narinwiki.lib.php";

		// 나린위키 라이브러리 객체 생성
		$narinLib = new NarinWikiLib($wiki_path, $bo_table);

		if ($skin_dir) $latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/narinwiki/$skin_dir";
		else $latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/narinwiki/basic";

		$sql = " SELECT * FROM {$g4['board_table']} WHERE bo_table = '$bo_table'";

		$board = sql_fetch($sql);

		$tmp_write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
			
		$list = $narinLib->recentUpdate($wiki_path, $bo_table, $rows, $subject_len=40);
		
		ob_start();
		include "$latest_skin_path/latest.skin.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	} 

	function narinalbum_latest($skin_dir, $label, $na_url, $rows = 5, $thumb = 'thumb2')
	{
		global $g4;

		if ($skin_dir)
			$latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/narinalbum/$skin_dir";
		else
			$latest_skin_path = GPF_PATH."/plugins/".$this->id."/skin/narinalbum/basic";

		$sql =<<<EOF
	SELECT *, na.album_id AS album_picasa_id FROM np_picasa_photo AS np
			 LEFT JOIN np_picasa_album AS na 
				ON np.album_id = na.id AND na.display = 1 
			 ORDER BY np.updated_date DESC
			LIMIT $rows
EOF;
		$res = sql_query($sql);
		$list = array();
		while($row = sql_fetch_array($res))
		{
			array_push($list, $row);
		}

		ob_start();
		include_once $latest_skin_path . "/latest.skin.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

?>