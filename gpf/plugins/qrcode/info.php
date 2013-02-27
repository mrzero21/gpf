<?
/**
 * 
 * QR코드 플러그인 정보 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfoQrcode extends GPFPluginInfo 
{
	/**
	 * 생성자
	 */
	public function __construct() {				
		parent::__construct();
	
		$this->version = "2013-01-24";
		$this->author_name = "byfun";
		$this->author_homepage = "http://byfun.com";
		$this->plugin_link = "http://byfun.com/axis/gpf_plugin.php?plugin=qrcode";

		$this->label = "QR코드";
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
	 * 플러그인이 활성화 될 때
	 */
	public function onActivated()	
	{ 
		@mkdir($this->data_path."/qrcode_images", 0707);
		@chmod($this->data_path."/qrcode_images", 0707);
	}

	/**
	 * 플러그인이 비활성화 될 때
	 */
	public function onDeactivated()	
	{ 
		$this->remove_all_qrcodes($this->data_path."/qrcode_images");
	}

	/**
	 * data 디렉토리에 생성되어있는 모든 qrcode 이미지 삭제
	 */
	protected function remove_all_qrcodes($directory)
	{
		// 안전하게 삭제하자 : 플러그인 data 디렉토리의 하위가 아니면 실행하지 않음
		if(!$this->is_sub_directory($directory, $this->data_path)) { return; }

		foreach(glob("{$directory}/*") as $file)
		{
			if(is_dir($file)) { 
				$this->remove_all_qrcodes($file);
			} else {
				// 안전하게 삭제하자 : png 파일이 아니면 삭제하지 않음
				if(substr($file, -strlen(".png")) == ".png") {
					@unlink($file);
				}
			}
		}
		@rmdir($directory);
	}
	
	/**
	 * 하위 디렉토리인지 검사
	 */
	protected function is_sub_directory($dir, $parent)
	{
		return (strpos(realpath($dir), realpath($parent)) === 0);
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
		본문 하단에 QR 코드를 생성합니다.
EOF;
	}
}
?>
