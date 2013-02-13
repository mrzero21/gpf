<?
/**
 * 
 * GPF 메인 클레스
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

include_once GPF_PATH."/lib/gpf.Config.class.php";

class GPF
{
	/**
	 *
	 * @var 싱글톤 인스턴스
	 */
	protected static $instance = NULL;

	/**
	 *
	 * @var object GPFConfig 인스턴스
	 */
	public $cfg;

	/**
	 * 
	 * @var array 플러그인 저장 배열
	 */
	protected $plugins = array();
	protected $actions = array();
	protected $admins = array();
	protected $helpers = array();

	/**
	 * 생성자
	 */
	protected function __construct() {
		$this->cfg = GPFConfig::getInstance();
		$this->_loadPlugins();
	}


	/**
	 * Singleton
	 */
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GPF();
		}
		return self::$instance;
	}


	/**
	 * 
	 * 플러그인 로드
	 * 
	 */
	protected function _loadPlugins()
	{
		include_once GPF_PATH."/lib/gpf.Plugin.class.php";

		$use_plugins = $this->getActivatedPlugins();
		foreach($use_plugins as $p) 
		{
			$p = $this->readPlugin($p);
			if($p) $p->regist($this);					
		}
		// 플러그인 정렬
		$this->afterLoadActionPlugins();
		$this->afterLoadAdminPlugins();
	}

	//////////////////////////////////////////////////////////
	//
	// 액션 플러그인
	//
	/////////////////////////////////////////////////////////
	/**
	 * 
	 * 액션 추가
	 *
	 * @param string $event 이벤트명
	 * @param obj $obj {@link GPFPlugin} 객체
	 * @param string $handler $obj 내에 구현된 이벤트 핸들러
	 */
	public function addAction($event, $obj, $handler)
	{
		if(!is_a($obj, "GPFPlugin")) gpf_die("GPF 에는 GPFPlugin 클래스를 상속한 인스턴스만 사용가능합니다.");
		$id = $obj->id;

		$filter_file = $obj->getDataPath()."/filter.php";
		$filter = null;
		if($obj->use_filter && file_exists($filter_file))
		{
			include $filter_file;		
			$filter = unserialize($filter);
		}

		if( !$this->check_filter($filter) ) return;

		$order = ($this->cfg->action_order[$id] ? $this->cfg->action_order[$id] : 99999);
		$this->actions[strtoupper($event)][] = array("id"=>$id, "obj"=>$obj, "handler"=>$handler, "order"=>$order);
	}

	/**
	 * 
	 * 이벤트 핸들러 실행
	 * 
	 * @param string $type 이벤트 타입 (PRE_VIEW, POST_WRITE_UPDATE ..)
	 */
	public function trigger($type, $params=array()) {
		$returns = array();
		if(isset($this->actions[$type]) && is_array($this->actions[$type])) {
			foreach($this->actions[$type] as $idx => $p) {
				$ret = $p['obj']->$p['handler']($type, $GLOBALS, $params);
				if(is_array($ret)) {
					foreach($ret as $k=>$v) { $returns[$k] = $GLOBALS[$k] = $v; }
				}
			}
		}
		return $returns;
	}

	/**
	 * 
	 * 플러그인 정렬 및 시스템 액션 등록
	 * 이벤트 trigger 시에 플러그인 순서에 따라 실행됨
	 * 
	 */
	protected function afterLoadActionPlugins()
	{
		// 이벤트를 order 순으로 정렬
		foreach($this->actions as $k=>$v) {
			$this->actions[$k] = $this->_subval_asort($this->actions[$k], 'order');
		}		
		// 시스템 액션
		include_once GPF_PATH."/system/gpf.actions.php";
		$p = new GPFSystemPlugin();
		$p->regist($this);
	}

	/**
	 *
	 * 플러그인을 register 해야할지 말아야할지 결정
	 * 사용할 플러그인이면 true, 아니면 false
	 */
	private function check_filter($filter)
	{
		if(!$filter) return true;
		return ($this->_check_apply($filter['apply']) && $this->_check_except($filter['except']));
	}

	/**
	 *
	 * 플러그인 사용을 허용할것이면 true, 아니면 false
	 */
	private function _check_apply($filter)
	{
		$bo_table = $GLOBALS['bo_table'];
		$member = $GLOBALS['member'];
		$empty_user = empty($filter['user']);
		$empty_board = empty($filter['board']);

		if( $empty_user && ( $empty_board ||  (!$empty_board && !$bo_table ) ) ) return true;

		if(!$empty_user) foreach($filter['user'] as $idx => $mb_id) if($member['mb_id'] == $mb_id) return true;
		if(!$empty_board) foreach($filter['board'] as $idx => $table) if($bo_table == $table) return true;
		
		return false;
	}

	/**
	 *
	 * 플러그인 사용을 허용할것이면 true, 아니면 false
	 */
	private function _check_except($filter)
	{
		$bo_table = $GLOBALS['bo_table'];
		$member = $GLOBALS['member'];
		$empty_user = empty($filter['user']);
		$empty_board = empty($filter['board']);
		
		if($empty_user && $empty_board) return true;

		if(!$empty_user) foreach($filter['user'] as $idx => $mb_id) if($member['mb_id'] == $mb_id) return false;
		if(!$empty_board) foreach($filter['board'] as $idx => $table) if($bo_table == $table) return false;
		
		return true;
	}

	//////////////////////////////////////////////////////////
	//
	// 관리 플러그인
	//
	/////////////////////////////////////////////////////////
	/**
	 * 
	 * 관리자 메뉴 추가
	 *
	 * @param string $label 관리자 메뉴 텍스트
	 * @param obj $obj {@link GPFPluginAdmin} 객체
	 * @param string $handler $obj 내에 구현된 이벤트 핸들러
	 */
	public function addAdmin($label, $obj, $handler)
	{
		if(!is_a($obj, "GPFPlugin")) gpf_die("GPF 에는 GPFPlugin 클래스를 상속한 인스턴스만 사용가능합니다.");
		$id = $obj->id;
		$order = ($this->cfg->plugin_order[$id] ? $this->cfg->plugin_order[$id] : 99999);
		$this->admins[] = array("label"=>$label, "obj"=>$obj, "handler"=>$handler, "order"=>$order);
	}

	/**
	 *
	 * 관리자 플러그인이 있나?
	 */
	public function hasAdminPlugins()
	{
		return !empty($this->admins);
	}

	/**
	 *
	 * 관리자 플러그인 목록 반환
	 */
	public function getAdminPlugins()
	{
		return $this->admins;
	}

	/**
	 *
	 * 관리자 플러그인이 하나 반환
	 */
	public function getAdminPlugin($plugin_id)
	{
		foreach($this->admins as $idx => $p) {
			if($plugin_id == $p['obj']->id) return $p['obj'];
		}
	}

	/**
	 * 
	 * 플러그인 정렬 : 그누보드 관리자 페이지 > 플러그인 에 정렬된 순서로 메뉴가 보임
	 * 
	 */
	protected function afterLoadAdminPlugins()
	{
		if(!empty($this->admins)) $this->_subval_asort($this->admins, 'order');
	
	}

	//////////////////////////////////////////////////////////
	//
	// 헬퍼 플러그인
	//
	/////////////////////////////////////////////////////////
	/**
	 *
	 * 헬퍼 추가 함수
	 *
	 * @param string $name 사용할 함수명
	 * @param obj $obj {@link GPFPluginHelper} 객체
	 * @param string $help_function 헬퍼 객체의 실제 함수
	 */
	public function addHelper($name, $obj, $help_function)
	{
		if(!is_a($obj, "GPFPlugin")) gpf_die("GPF 에는 GPFPlugin 클래스를 상속한 인스턴스만 사용가능합니다.");
		if(method_exists($this, $name)) gpf_die("GPF 내의 멤버함수와 같은 이름으로 등록할 수 없습니다. (함수명 : $name)");
		if(isset($this->helpers[$name])) gpf_die("GPF 에 이미 등록된 헬프함수가 존재합니다 (함수명 : $name)");
		$this->helpers[$name] = array('obj'=>$obj, 'func'=>$help_function);
		return true;
	}

	/**
	 *
	 * 동적 호출
	 */
	public function __call($method, $args)
	{
        if(method_exists($this, $method)) call_user_func_array(array($this, $method), $args);		
		$h = $this->helpers[$method];		
		if(is_array($h)) return call_user_func_array(array($h['obj'],$h['func']), $args);		
		echo("GPF 에 등록되지 않은 메소드를 호출하였습니다 : '$method'");
	}	


	//////////////////////////////////////////////////////////
	//
	// PX
	//
	/////////////////////////////////////////////////////////
	/**
	 * 
	 * PX 추가
	 *
	 * @param string $event 이벤트명
	 * @param obj $obj {@link GPFPlugin} 객체
	 * @param string $handler $obj 내에 구현된 이벤트 핸들러
	 */
	public function addPx($event, $obj, $handler)
	{
		if(!defined("GPF_PX")) return false;
		include_once GPF_PATH."/lib/gpf.GPFPx.class.php";
		$px = GPFPx::getInstance();
		$px->addPx($event, $obj, $handler);
	}


	//////////////////////////////////////////////////////////
	//
	// 플러그인 공통
	//
	/////////////////////////////////////////////////////////

	/**
	 *
	 * 활성화된 플러그인 목록 반환
	 *
	 */
	public function getActivatedPlugins()
	{
		return $this->cfg->activated_plugins;
	}


	/**
	 *
	 * 모든 플러그인 정보 반환 (사용되지 않는 플러그인 포함)
	 */
	public function readPluginInfos()
	{
		include_once GPF_PATH."/lib/gpf.PluginInfo.class.php";
		$path = GPF_PATH."/plugins";
		$plugins = array();

		// 플러그인 로드
		$d = dir($path);
		while ($entry = $d->read()) {	
			if(substr($entry, 0, 1) == ".") continue;
			$p = $this->readPluginInfo($entry);
			if($p) $plugins[$p->id] = $p;				
		} // while	

		return $this->_sort_plugins($plugins);
	}

	/**
	 *
	 * 플러그인 정보 반환
	 */
	public function readPluginInfo($plugin_id)
	{
		include_once GPF_PATH."/lib/gpf.PluginInfo.class.php";
		$classFile = GPF_PATH."/plugins/".$plugin_id."/info.php";
		$realClassName = "GPFPluginInfo".ucfirst($plugin_id);
		include_once $classFile;			
		if(class_exists($realClassName)) {
			$p = new $realClassName();
			if(!is_a($p, "GPFPluginInfo")) return null;
			return $p;
		}			
		return null;
	}

	/**
	 *
	 * 모든 플러그인 반환 (사용되지 않는 플러그인 포함)
	 */
	public function readPlugins()
	{
		$path = GPF_PATH."/plugins";
		$plugins = array();

		// 플러그인 로드
		$d = dir($path);
		while ($entry = $d->read()) {				
			if(substr($entry, 0, 1) == ".") continue;
			$p = $this->readPlugin($entry);
			if($p) $plugins[$p->id] = $p;						
		} // while
		
		return $this->_sort_plugins($plugins);
	}

	/**
	 *
	 * 플러그인 반환
	 */
	public function readPlugin($plugin_id)
	{
		include_once GPF_PATH."/lib/gpf.Plugin.class.php";
		$classFile = GPF_PATH."/plugins/".$plugin_id."/plugin.php";
		if(!file_exists($classFile)) return null;				
		$realClassName = "GPFPlugin".ucfirst($plugin_id);
		include_once $classFile;				
		if(!class_exists($realClassName)) return null;
		$p = new $realClassName();
		if(!is_a($p, "GPFPlugin")) return null;
		return $p;
	}

	/**
	 *
	 * 연관배열 키 기준으로 정렬 (asort)
	 *
	 * @param array $a 연관배열
	 * @param string $subkey 정렬기준키
	 * @return array 정렬된 배열
	 */
	function _subval_asort($a,$subkey) {
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}

	/**
	 *
	 * 플러그인을 plugin_order 로 정렬하여 반환
	 */
	function _sort_plugins($plugins)
	{
		$tmp = array();
		foreach($plugins as $id => $p) 
		{
			$order = ( $this->cfg->plugin_order[$p->id] ? $this->cfg->plugin_order[$p->id] : 99999 );
			array_push($tmp, array('id'=>$id, 'plugin'=>$p, 'order'=>$order));
		}
		if(empty($tmp)) return array();
		$tmp = $this->_subval_asort($tmp, 'order');
		$res = array();
		foreach($tmp as $pi) $res[$pi['id']] = $pi['plugin'];
		return $res;
	}
}
?>