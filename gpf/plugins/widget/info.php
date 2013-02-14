<?
/**
 * 
 * 위젯(Widget) 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoWidget extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		
		parent::__construct('action');

		$this->version = "2013-01-17";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=widget";

		$this->label = "위젯 (Widget)";
	}

	/**
	 * 플러그인 설정이 필요한가
	 */
	public function shouldSetup() { return true; }

	/**
	 * 플러그인 설정
	 */
	public function setup()
	{
		include_once $this->plugin_path . "/config.php";
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
			게시글 보기 하단에 원하는 스크립트를 삽입할 수 있습니다.
EOF;
	}
}
?>
