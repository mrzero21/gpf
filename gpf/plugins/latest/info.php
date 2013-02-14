<?
/**
 * 
 * 최신글 도우미 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoLatest extends GPFPluginInfo 
{
	var $default_css;

	/**
	 * 생성자
	 */
	public function __construct() {				
		
		parent::__construct();

		$this->version = "2013-01-17";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=latest";

		$this->label = "최신글 도우미";

		$this->default_css =<<<EOF
.simple_latest li, .simple_latest ul, .simple_latest span, .simple_latest td, .simple_latest div, { margin: 0; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; color:#333; }
.simple_latest { padding:0;margin:0;}
.simple_latest a {color:#000; }
.simple_latest .sl_head:after {display:block;clear:both;content:""}
.simple_latest .sl_fl { float:left; }
.simple_latest .sl_fr { float:right; }
.simple_latest ul { list-style:none; padding-left:0;}
.simple_latest ul li { width:100%; padding:5px}
.simple_latest ul li:after {display:block;clear:both;content:""}
.simple_latest ul li .sl_cmt { font-size:0.8em; color:#888; }
.simple_latest .sl_clear:after { content: "."; display: block; clear: both; visibility: hidden; line-height: 0; height: 0; }
.simple_latest .sl_clear { display: inline-block; }
html[xmlns] .simple_latest .sl_clear { display: block; }
* html .simple_latest .sl_clear { height: 1%; }
EOF;
	}


	public function shouldInstall() 
	{ 
		return !file_exists($this->cssfile); 
	}

	public function shouldUninstall() 
	{ 
		return file_exists($this->cssfile); 
	}

	public function install()
	{
		$this->updateCSS($this->default_css);
	}

	public function uninstall()
	{
		$this->clearCSS();
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
			각종 최신글 스킨.. 여러게시판, 최근 댓글달린 글, 나린위키, 나린앨범, 피카사.. 의 최신글
EOF;
	}
}
?>
