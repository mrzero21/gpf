<?
/**
 * 
 * 시스템 액션
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFSystemPlugin extends GPFPlugin 
{
	/**
	 *
	 * 시스템 액션들끼리 공유해야할 필요가 있을 때 사용
	 *
	 */
	var $shared = array();

	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($p)
	{
		$d = dir(dirname(__FILE__)."/actions");
		while ($entry = $d->read()) {
			if(substr($entry, 0, 3) != 'on_' || substr($entry, -4) != '.php') continue;
			$event = strtoupper(substr($entry, 3, strlen($entry)-7));
			$p->addAction($event, $this, "common_event_handler");
		}
	}

	/**
	 *
	 * 공통 이벤트 핸들러
	 *
	 */
	public function common_event_handler($event, $g) {

		$return_array = array();
		$shared = array();

		$include_file = "on_".strtolower($event.'.php');
		include_once dirname(__FILE__)."/actions/$include_file";

		// included_file 에서 $shared 에 값을 할당했다면 저장
		if(!empty($shared)) foreach($shared as $k => $v) $this->shared[$k] = $v;

		return $return_array;
	}

}
?>
