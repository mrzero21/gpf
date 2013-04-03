<?
/**
 * 
 * GPFPlugin 클래스
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPlugin 
{	
	/**
	 * 
	 * @var 플러그인 고유 id (플러그인 directory 명과 동일)
	 */	
	public $id;
	
	/**
	 * 
	 * @var GPFPluginInfo 플러그인 정보 클래스 인스턴스
	 */
	public $info;

	/**
	 * 
	 * @var 액션 필터를 사용할지 안할지 (기본값 : 사용함)
	 */
	public $use_filter = true;

	/**
	 * 
	 * @var 플러그인 경로
	 */
	public $plugin_path;

	/**
	 * 
	 * @var 플러그인 URL
	 */
	public $plugin_url;

	/**
	 * 
	 * @var 데이터 저장 경로
	 */
	public $data_path;

	/**
	 * 
	 * @var 데이터 저장 URL
	 */
	public $data_url;

	/**
	 * 생성자
	 */
	public function __construct() {
		$class_name = substr(get_class($this), 9);
		$class_name{0} = strtolower($class_name{0});
		$this->id = $class_name;
		$this->plugin_path = GPF_PATH."/plugins/".$this->id;
		$this->plugin_url = GPF_URL."/plugins/".$this->id;
		$this->data_path = GPF_PATH."/data/plugins/".$this->id;
		$this->data_url = GPF_URL."/data/plugins/".$this->id;
	}

	public function regist($p) {}

	/**
	 *
	 * 플러그인 데이터 저장 경로 반환 (<gpf>/data/plugins/plugin_id)
	 * @deprecated
	 */
	public function getDataPath()
	{	
		return $this->data_path;
	}

	/**
	 *
	 * 플러그인 경로 반환 (<gpf>/plugins/plugin_id)
	 * @deprecated
	 */
	public function getPluginPath()
	{
		return $this->plugin_path;
	}


	/**
	 *
	 * 플러그인 정보 클래스 로드
	 */
	public function loadPluginInfo()
	{
		include_once GPF_PATH."/lib/gpf.PluginInfo.class.php";
		$classFile = GPF_PATH."/plugins/".$this->id."/info.php";
		if(!file_exists($classFile)) return null;
		include_once $classFile;
		$realClassName = "GPFPluginInfo".ucfirst($this->id);
		if(!class_exists($realClassName)) return null;
		$instance = new $realClassName();
		$this->info = $instance;
		return $this->info;
	}
}
?>
