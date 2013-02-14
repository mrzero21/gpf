<?
/**
 * 
 * 썸네일 (THumbnail) 플러그인 클래스
 *
 * 본 플러그인에 사용된 불당썸의 저작권은 http://opencode.co.kr 에 있습니다.
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginThumbnail extends GPFPlugin 
{	
	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addHelper("thumbnail", $this, "thumbnail");
	}

	
	/**
	 * 썸네일 함수
	 */
	public function thumbnail($file_name, $width=0, $height=0, $is_create=false, $is_crop=2, $quality=90, $small_thumb=1, $watermark="", $filter="", $noimg="", $thumb_type="")
	{
		include_once $this->getPluginPath()."/lib/thumb.lib.php";
		return thumbnail($file_name, $width, $height, $is_create, $is_crop, $quality, $small_thumb, $watermark, $filter, $noimg, $thumb_type);
	}
}
?>
