<?
/**
 * 
 * 출석부 플러그인
 *
 * 본 프로그램의 수정후 재배포를 금합니다.
 * @author	byfun (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

define("__RB__", "ROLLBOOK");

class GPFPluginRollbook extends GPFPlugin 
{	
	/**
	 * 액션 필터 안보이게 설정
	 */
	public function __construct()
	{
		parent::__construct();
		$this->use_filter = false;
	}

	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addPx($px = 'rollbook', $obj = $this, $handler = "px_control");
		$gpf->addPx($px = 'rollbook.exe', $obj = $this, $handler = "px_exe_control");
	}
	
	/** 
	 * 출석부 UI 실행
	 */
	public function px_control($m, $g)
	{
		extract($g);
		if(!$c) $c = 'index';

		$plugin_path = $this->getPluginPath();
		$inc_file = $plugin_path."/pxs/".basename($c).".php";
		if(!file_exists($inc_file)) gpf_die('Invalid access to rollbook plugin');
		
		include_once $plugin_path."/pxs/common.php";
		include_once $g['g4']['path']."/".$rb['head'];
		include_once $plugin_path."/pxs/head.php";
		include_once $inc_file;
		include_once $plugin_path."/pxs/tail.php";
		include_once $g['g4']['path']."/".$rb['tail'];
	}

	/**
	 * 출석부 exe 실행
	 */
	public function px_exe_control($m, $g)
	{
		extract($g);
		$plugin_path = $this->getPluginPath();
		$inc_file = $plugin_path."/pxs/exe/".basename($c).".php";
		if(!file_exists($inc_file)) gpf_die('Invalid access to rollbook plugin');
		include_once $plugin_path."/pxs/common.php";
		include_once $inc_file;
	}
}

function gpf_rb_url($c, $isExe = false) 
{
	$add = ( $isExe ? ".exe" : "" );
	return GPF_PATH."/px.php?m=rollbook{$add}&c=".$c;
}

?>
