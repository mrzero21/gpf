<?
/**
 * 
 * GPFJsCss 클래스 : 플러그인들의 js, css 파일들을 병합하여 <gpf>/data/gpf.css, gpf.js 파일 생성
 *
 * @author	chongmyung.park (http://byfun.com)
 */

class GPFJsCss {

	/**
	 *
	 * @var string <gpf>/data
	 */
	public $data_path;

	/**
	 *
	 * @var string minify 한 js 내용을 저장할 파일 경로
	 */	
	public $js;

	/**
	 *
	 * @var string minify 한 css 내용을 저장할 파일 경로
	 */	
	public $css;
	

	/**
	 * 생성자
	 */
	public function __construct() {

		$this->data_path = GPF_PATH.'/data';
		$this->js = $this->data_path .'/gpf.js';
		$this->css = $this->data_path .'/gpf.css';
	}

	/**
	 *
	 * js 파일을 읽고, minify 해서 하나의 파일로 저장
	 */
	public function updateJs() {
		$this->_update('js');
	}

	/**
	 *
	 * css 파일을 읽고, minify 해서 하나의 파일로 저장
	 */
	public function updateCss() {
		$this->_update('css');
	}
	
	/**
	 * js 또는 css 업데이트
	 */
	protected function _update($type) {
		$contents = $this->get_files_contents($this->data_path."/".$type, $type);		
		include_once GPF_PATH."/lib/Minifier/".$type."min.php";		
		try {
			if($type == "css") $contents = CssMin::minify($contents);
			if($type == "js") $contents = JsMin::minify($contents);
		} catch(Exception $ex) {}
		if(!$contents) {
			@unlink($this->$type);
			return;
		}
		$fp = fopen($this->$type, "w");
		fwrite($fp, $contents);
		fclose($fp);		
	}

	/**
	 *
	 * 주어진 파일 경로에서 파일 목록 읽어오기
	 */
	protected function get_files_contents($path, $extension) {
		$cfg = GPFConfig::getInstance();
		$content = "";
		$active_plugins = $cfg->activated_plugins;
		foreach($active_plugins as $p)
		{
			$file = $path ."/". $p . ".". $extension;
			if(file_exists($file)) 
			{
				$content .= file_get_contents($file);
			}
		}

		return $content;
	}

}
?>
