<?
/**
 * 
 * 썸네일 (Thumbnail) 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoThumbnail extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		
		parent::__construct();

		$this->version = "2013-01-17";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=thumbnail";
		
		$this->label = "썸네일(Thumbnail)";
	}

	/**
	 * 플러그인 설정이 필요한가
	 */
	public function shouldSetup() { return false; }
	
	/**
	 * 설치해야 하나?
	 */
	public function shouldInstall()	{ return !file_exists($this->jsfile); }

	/**
	 * 제거해야 하나?
	 */
	public function shouldUnInstall() { return file_exists($this->jsfile); }

	/**
	 * 플러그인이 활성화 될 때
	 */
	public function onActivated() {	}
	
	/**
	 * 플러그인이 비활성화 될 때
	 */
	public function onDeactivated()	{ }

	/**
	 * 설치 
	 */
	public function install()
	{
		$this->updateJS(file_get_contents($this->plugin_path."/lib/b4.common.js"));
	}

	/**
	 * 플러그인 설정
	 */
	public function setup()
	{
		include_once $this->plugin_path . "/config.php";
	}


	/**
	 * 삭제
	 */
	public function uninstall()
	{
		@unlink($this->jsfile);
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
		썸네일 생성을 돕는 플러그인입니다. 본 플러그인은 <a href="http://opencode.co.kr" target="_blank" style="color:blue">불당썸</a> 레퍼 플러그인입니다. <br/>
EOF;
	}
}
?>
