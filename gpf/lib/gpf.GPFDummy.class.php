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

	public function addAction($event, $obj, $handler) { }
	public function trigger($type, $params=array()) { } 
	public function addAdmin($menu_id, $label, $obj, $handler) { }
	public function hasAdminPlugins() { return false; }
	public function getAdminPlugins() { return $this->admins; }
	public function getAdminPlugin($plugin_id) { return null; }
	public function addHelper($name, $obj, $help_function) { return true; }
	public function __call($method, $args) { if(method_exists($this, $method)) return call_user_func_array(array($this, $method), $args); }	
	public function hasHelper($name) { return false; }
	public function addPx($event, $obj, $handler) { } 
	public function getActivatedPlugins() { return $this->cfg->activated_plugins; }
	public function readPluginInfos() { return array(); }
	public function readPluginInfo($plugin_id) { return null; }
	public function readPlugins() { return array(); }
	public function readPlugin($plugin_id) { return null; }
}
?>
