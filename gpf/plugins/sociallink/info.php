<?
/**
 * 
 * 소셜링크(SocialLink) 플러그인 정보 클래스
 *
 * 소셜링크 버튼 생성 코드는 '테러보이'님 프로그램에서 가져옴 (http://sir.co.kr/bbs/board.php?bo_table=g4_skin&wr_id=124809)
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoSociallink extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();

		$this->version = "2013-02-27";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://lovelyus.net/axis/gpf_plugin.php?plugin=소셜링크";

		$this->label = "소셜링크(Social Link)";
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
		본문 하단에 구글+ 버튼, 페이스북 좋아요, 네이버 북마크, 네이트온, 에버노트, 요즘, 미투데이, 페이스북으로 보내기의 소셜 링크가 생깁니다. 
EOF;
	}
}
?>
