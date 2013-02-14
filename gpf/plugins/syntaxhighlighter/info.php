<?
/**
 * 
 * 문법강조(Syntax Highlighter) 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoSyntaxhighlighter extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();

		$this->version = "2013-01-17";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=syntaxhighlighter";

		$this->label = "문법강조(SyntaxHighlighter)";
	}


	/**
	 * 
	 * 플러그인 설명
	 * 
	 * @return string 플러그인설명
	 */
	public function getDescription()
	{
		return "'[code 언어] 프로그램코드 [/code]' 형식으로 글을 작성하면 해당 코드에 syntax highlighting 을 하는 플러그인입니다. 형식의 '언어'에는 php, vb, sql, ruby, python, plain, perl, js, java, css, cpp, c#, xml 을 사용할 수 있습니다.";
	}
}
?>
