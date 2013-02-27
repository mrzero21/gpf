<?
/**
 * 
 * 검색엔진 최적화 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginSeo extends GPFPlugin 
{	
	/**
	 * 메타태그로 출력할 변수들..
	 */
	var $title = "";
	var $subject = "";
	var $publisher = "";
	var $description = "";
	var $keywords = "";

	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("LOAD", $this, "on_load");
		$gpf->addAction("UNLOAD", $this, "on_unload");

		$gpf->addHelper("seo_keywords", $this, "set_keywords");
		$gpf->addHelper("seo_title", $this, "set_title");
		$gpf->addHelper("seo_subject", $this, "set_subject");
		$gpf->addHelper("seo_description", $this, "set_description");
		$gpf->addHelper("seo_publisher", $this, "set_publisher");
	}

	/**
	 * 문서 로딩시 아웃풋 버퍼링 시작
	 */
	public function on_load($event, $g)
	{
		if(!$g['bo_table'] && !$g['wr_id']) return;
		ob_start();
	}

	/**
	 * 문서 출력시 아웃풋 버퍼 잡아서 메타태그 셋팅
	 */
	public function on_unload($event, $g)
	{
		$view = $g['view'];
		$board = $g['board'];
		$group = $g['group'];

		if(!$view['wr_subject']) return;
		
		$out = ob_get_contents();
		ob_end_clean();
		
		// 브라우저 타이틀 변경
		$write_title = conv_subject(strip_tags($view['wr_subject']), 64) . ' < '. $board['bo_subject'] . ' < ' . $group['gr_subject'];
		$out = preg_replace("/<title>(.*?)<\/title>/", '<title>'.htmlspecialchars($write_title).'</title>', $out);
		
		// 메타태그 데이타 설정
		$subject = ($this->subject != "" ? $this->subject : $view['wr_subject']);
		$title = ($this->title != "" ? $this->title : $view['wr_subject']);
		$description = ($this->description != "" ? $this->description : strip_tags(conv_subject("$group[gr_subject] - $board[bo_subject] - $view[wr_subject]", 255)) );
		$publisher = ($this->publisher != "" ? $this->publisher : $_SERVER['SERVER_NAME']);		
		$keywords = $this->keywords;

		preg_match_all("/(?<!\w)#([a-zA-Z가-힣0-9]+)/", $view['wr_content'], $matched);
		$keys = array();
		
		while (!empty($matched[1])) {
			$val = array_pop($matched[1]);
			if (array_search($val, $keys) === FALSE)
			{
				array_push($keys, $val);
			}
		}

		$keywords = ($keywords == "" ? "" : ", ") . implode(", ", $keys);

		// 본문 쪼개서 메타태그 추가
		$head_tag = '<title>';
		$pos_head = strpos($out, $head_tag);
		$before = substr($out, 0, $pos_head);
		$after = substr($out, $pos_head, strlen($out));

		echo $before;
		?>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="subject" content="<?=htmlspecialchars($subject)?>" />
<meta name="title" content="<?=htmlspecialchars($title)?>" />
<meta name="publisher" content="<?=htmlspecialchars($publisher)?>" />
<meta name="keywords" content="<?=htmlspecialchars($keywords)?>" />
<meta name="description" content="<?=htmlspecialchars($description)?>" />
<meta name="robots" content="index,follow" />
<link rel="canonical" href="<?=$_SERVER['PHP_SELF']?>?bo_table=<?=$g['bo_table']?>&wr_id=<?=$g['wr_id']?>" />
<?	
			echo $after;
	}

	/**
	 * 메타태그 셋팅 헬퍼함수들...
	 */
	public function set_keywords($keywords)
	{
		$this->keywords = $keywords;
	}

	public function set_title($title)
	{
		$this->title = $title;
	}

	public function set_subject($subject)
	{
		$this->subject = $subject;
	}

	public function set_description($desc)
	{
		$this->description = $desc;
	}

	public function set_publisher($pub)
	{
		$this->publisher = $pub;
	}



}
?>
