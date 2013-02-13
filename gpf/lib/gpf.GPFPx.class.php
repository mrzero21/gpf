<?
/**
 * 
 * GPFPx 클래스 : <gpf>/px.php 에서 플러그인의 지정된 메소드를 실행시킴
 * (PX : Plugin eXecution)
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPx
{
	/**
	 *
	 * @var 싱글톤 인스턴스
	 */
	protected static $instance = NULL;

	/**
	 * 
	 * @var array PX 배열
	 */
	protected $plugins = array();

	/**
	 * Singleton
	 */
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GPFPx();
		}
		return self::$instance;
	}

	/**
	 * 
	 * PX 핸들러 추가
	 *
	 * @param string $event 이벤트명
	 * @param obj $obj {@link GPFPlugin} 객체
	 * @param string $handler $obj 내에 구현된 이벤트 핸들러
	 */
	public function addPx($event, $obj, $handler)
	{
		if(!is_a($obj, "GPFPlugin")) gpf_die("GPFPx 에는 GPFPlugin 클래스를 상속한 인스턴스만 사용가능합니다.");
		$id = $obj->id;
		$this->plugins[strtoupper($event)][] = array("id"=>$id, "obj"=>$obj, "handler"=>$handler);
	}

	/**
	 *
	 * PX가 존재하는가?
	 */
	public function hasPx($event)
	{
		return isset($this->plugins[$event]);
	}

	/**
	 * 
	 * PX 핸들러 실행
	 * 
	 * @param string $type 메소드 (px.php 에 파라미터로 넘어오는 m 값)
	 */
	public function trigger($type) {
		if(isset($this->plugins[$type]) && is_array($this->plugins[$type])) {
			foreach($this->plugins[$type] as $idx => $p) {
				$ret = $p['obj']->$p['handler']($type, $GLOBALS);
				if(is_array($ret)) {
					foreach($ret as $k=>$v) { $GLOBALS[$k] = $v;}
				}
			}
		}
	}
}
?>