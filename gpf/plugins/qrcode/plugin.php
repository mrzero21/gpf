<?
/**
 * 
 * QR코드 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginQrcode extends GPFPlugin 
{	
	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("PRE_VIEW", $this, "on_view");

		$gpf->addAction("POST_DELETE.TAIL", $this, "on_delete");
		$gpf->addAction("POST_DELETE_ALL.TAIL", $this, "on_delete");

		$gpf->addHelper("qrcode", $this, "qrcode");

		$gpf->addPx("qrcode", $this, "px_handler");
	}

	/**
	 * 글 보기시 QR코드 생성
	 */
	public function on_view($event, $g)
	{
		$view = $g['view'];
		$bo_table = $g['bo_table'];
		$wr_id = $g['wr_id'];

		$qrcode = $this->qrcode($bo_table, $wr_id);
		
		$image = "<img src='$qrcode' border='0'/>";
		$tpl = file_get_contents($this->getPluginPath()."/tpl/view.txt");
		$tpl = str_replace("[QRCODE]", $image, $tpl);
		$view['qrcode'] = $qrcode;
		$view['content'] = $view['content'] . $tpl;

		return array('view'=>$view);
	}

	/**
	 * 글 삭제시 QR코드 삭제
	 */
	public function on_delete($event, $g)
	{
		@unlink($this->qrcode_image_path($g['bo_table'], $g['wr_id'], false));
	}

	/**
	 * QR코드 생성 함수
	 */
	public function qrcode($bo_table, $wr_id)
	{
		$file_path = $this->qrcode_image_path($bo_table, $wr_id);
		if(file_exists($file_path)) return $file_path;

		$error_correction_level	= 'H';
		$matrix_point_size = 2;
		$margin = 2;

		$host = (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') > 0 ? 'https' : 'http'). "://". $_SERVER['SERVER_NAME'];
		$g4_path = str_replace("\\", "/", dirname(dirname($_SERVER['SCRIPT_NAME'])));
		$g4_url = $host.$g4_path."/";
		$qrurl = $g4_url."bbs/board.php?bo_table=".$bo_table."&wr_id=".$wr_id;

		include_once("lib/qrlib.php");
		QRcode::png($qrurl, $file_path, $error_correction_level, $matrix_point_size, $margin);
		return $file_path;
	}

	/**
	 * QR코드 이미지 저장 경로
	 */
	protected function qrcode_image_path($bo_table, $wr_id, $createDir = true)
	{
		$save_path = $this->getDataPath() . "/qrcode_images/". $bo_table;
		if($createDir && !file_exists($save_path))
		{
			@mkdir($save_path, 0707);
			@chmod($save_path, 0707);
		}
		$filename = $wr_id .".png";
		$file_path = $save_path . "/". $filename;
		return $file_path;
	}

	/**
	 * PX 핸들러 : 템플릿 업데이트용
	 */
	public function px_handler($m, $g)
	{
		$c = $g['c'];
		
		if($c != 'update_tpl') die(json_encode(array('code'=>-1, 'msg'=>'잘못된 연결')));
		
		$member = $g['member'];
		$is_admin = $g['is_admin'];
		$type = $g['type'];
		$contents = stripslashes($g['contents']);
		$tpl_path = GPF_PATH."/plugins/".$this->id."/tpl/".$type.".txt";
		if(!$is_admin || !file_exists($tpl_path)) die( json_encode(array('code'=>-1, 'msg'=>'잘못된 접근입니다 : ' . $type)) );
		$fp = fopen($tpl_path, "w");
		fwrite($fp, $contents);
		fclose($fp);

		die( json_encode(array('code'=>1, 'msg'=>'업데이트 완료')) );
					
	}

}
?>
