<?
/**
 * 
 * 소셜링크(Social Link) 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginSociallink extends GPFPlugin 
{	
	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("PRE_VIEW", $this, "on_view");
	}

	/**
	 * 핸들러
	 */
	public function on_view($event, $g)
	{
		$view = $g['view'];
		$bo_table = $g['bo_table'];
		$wr_id = $g['wr_id'];
		$host = (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') > 0 ? 'https' : 'http'). "://". $_SERVER['SERVER_NAME'];
		$g4_path = str_replace("\\", "/", dirname(dirname($_SERVER['SCRIPT_NAME'])));
		$g4_url = $host.$g4_path."/";
		$plugin_url = $g4_url."gpf/plugins/".$this->id;
		$subject_con = $view['wr_subject'];
		$board_url = $g4_url."bbs/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;
		// twitter
		$url= urlencode($subject_con."   ".$board_url);
		// facebook
		$face_url = urlencode($board_url);
		$face_subject = urlencode($subject_con);
		$face_content = strip_tags($view['wr_content']); 
		$face_content = substr($face_content,0,150)."...";
		$face_content = urlencode($face_content);

		if($view['file'][0]['file']){
			$face_img = $g4_url . "data/file/".$bo_table."/".$view['file'][0]['file']; // 1번째 사진을 기본 썸네일로 지정
			$face_img = urlencode($face_img);
		}else{
			//$face_img = urlencode("https://graph.facebook.com/Terrorboy/picture"); // <-- 이미지가 없을경우 강제로 이미지 띄움. 사이트 로고 URL로 변경 바람
			unset($face_img);
		}
		// me2day
		$me2_url = urlencode($board_url);
		$me2_subject = urlencode($subject_con);
		$me2_url_text = $g['config']['cf_title']; // 홈페이지 제목으로 출력
		$me2_url_text = str_replace("\"","˝","$me2_url_text"); // 사이트 명에 따온표 들어 가면 출력 안되던것 수정 // 2010 10 19 수정
		$me2_url_text = urlencode($me2_url_text); // 인코딩
		$me2_teg = $g['g4']['title']; // 테그 부분에 현제글 위치 표기
		$me2_teg = urlencode($me2_teg); // 인코딩
		// yozm
		$yozm_url = urlencode($board_url);
		$yozm_subject = urlencode($subject_con);
		// google & naver
		$subject = urlencode($subject_con);
		// like (facebook, google)
		$facebook_like = $g4_url."bbs/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;
		$google_p = $g4_url."bbs/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;
		ob_start();
		include_once "button.skin.php";
		$buttons = ob_get_contents();
		ob_end_clean();
		$view['content'] = $view['content'].$buttons;

		return array('view'=>$view);
	}
}
?>
