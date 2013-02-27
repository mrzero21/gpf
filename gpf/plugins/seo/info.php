<?
/**
 * 
 * 검색엔진 최적화 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoSeo extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();
	
		$this->version = "2013-02-27";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://lovelyus.net/axis/gpf_plugin.php?plugin=seo";

		$this->label = "검색엔진최적화 (SEO)";
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
			검색 엔진 최적화 도구입니다.
EOF;
	}
}
?>
