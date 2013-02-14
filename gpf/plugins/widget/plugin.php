<?
/**
 * 
 * 위젯(Widget) 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginWidget extends GPFPlugin 
{	
	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("PRE_VIEW", $this, "on_view");
		$gpf->addPx("widget", $this, "widget_control");
	}


	/**
	 *
	 * 위젯 PX 공용 핸들러
	 *
	 */
	public function widget_control($event, $g)
	{
		$g4 = $g['g4'];
		$config = $g['config'];
		$member = $g['member'];
		$c = $g['c'];
		$plugin_path = $this->getPluginPath();
		$return_array = array();
		$shared = array();

		$include_file = $this->getPluginPath()."/pxs/".strtolower(basename($c).'.php');
		if(file_exists($include_file)) include_once $include_file;
		else gpf_die("Invalid access to widget plugin");
		// included_file 에서 $shared 에 값을 할당했다면 저장
		if(!empty($shared)) foreach($shared as $k => $v) $this->shared[$k] = $v;

		return $return_array;
	}

	/**
	 * 핸들러
	 */
	public function on_view($event, $g)
	{
		$view = $g['view'];
		$tail = @file_get_contents(GPF_PATH."/data/plugins/".$this->id."/view.tail.txt");
		$view['content'] = $view['content'].$tail;
		return array('view'=>$view);
	}
}
?>
