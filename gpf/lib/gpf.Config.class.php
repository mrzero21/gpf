<?
/**
 * 
 * 환경설정(config) 클래스
 *
 *
 * <b>사용 예제</b>
 * <code>
 *
 * $gpfcfg->update("/using_plugins", array("html", "code"));
 *
 * // 위 코드는 레지스트리 "/config/using_plugins" 에 값 설정
 * // 결과적으로 'gpf_options' table에 name = /config/using_plugins, content = ["html", "code"] 형태로 저장된다. 
 * //array("html", "code") 가 json_encode 된 형태로 저장됨
 *  
 * // 레지스트리 "/config/using_plugins" 읽어오기
 * $using_plugins = $gpfcfg->using_plugins;	// 프로퍼티 형식으로 접근하여 사용
 * foreach($using_plugins as $plugin_name) {
 *  echo "플러그인명 : " . $plugin_name . "<br/>";
 * }
 * 
 * // 레지스트리에서 삭제하기
 * $gpfcfg->delete("/using_plugins");
 * </code>
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFConfig 
{
	/**
	 *
	 * @var GPFConfig 싱글톤 인스턴스
	 */
	protected static $instance = NULL;

	/**
	 *
	 * gpf_options 테이블의 /config/* 에 저장된 설정을 저장하기 위한 배열
	 * @var array 환경설정 정보
	 */
	protected $config;

	/**
	 *
	 * @var string 환경설정 저장 위치 : gpf_options의 /config/* 에 저장
	 */
	protected $reg;

	/**
	 * 생성자
	 */
	protected function __construct() {
		$this->reg = "/config";
		$this->_loadConfig();
	}

	/**
	 * Singleton
	 */
	public static function getInstance() {
		if(!isset(self::$instance)) {
			self::$instance = new GPFConfig();
		}
		return self::$instance;
	}

	/**
	 *
	 * 환경설정 업데이트
	 *	 
	 * @param string $path 레지스트리 패스
	 * @param mixed $value 저장할 값
	 */
	public function update($path, $value) {
		$name = mysql_real_escape_string($this->reg.$path);
		$json = mysql_real_escape_string(json_encode($value));
		$opt = sql_fetch("SELECT content FROM gpf_options WHERE name = '".$name."'");
		if($opt) {
			sql_query("UPDATE gpf_options SET content = '$json' WHERE name = '".$name."'");
		} else {
			sql_query("INSERT INTO gpf_options VALUES ( '".$name."', '$json' )");
		}
		$this->_loadConfig();
	}
	
	/**
	 *
	 * 레지스트리 로드
	 */
	protected function _loadConfig()
	{
		$this->config = array();

		$result = sql_query("SELECT * FROM gpf_options WHERE name LIKE '{$this->reg}/%'", false);

		if(mysql_error()) {
			$this->_install();
			return;
		}

		for($i=0; $row = sql_fetch_array($result); $i++) {
			$value = json_decode($row['content'], $assoc=true);
			$path = explode("/", $row['name']);
			array_shift($path);array_shift($path);
			$this->pathToArray($this->config, $path, $value);
		}
	}
	
	/**
	 * 
	 * 환경설정 삭제
	 * 
	 * @param string $path 래지스트리 패스
	 */
	public function delete($path) {
		$path = mysql_real_escape_string($this->reg.$path);
		sql_query("DELETE FROM gpf_options WHERE name = '".$path."'");
		$this->_loadConfig();
	}
	
	/**
	 * 
	 * 프로퍼티 매소드
	 * 
	 * @param string $key 프로퍼티 필드명
	 */
	public function __get($key)
	{
		if($this->config[$key]) return $this->config[$key];
		else return array();
	}

	/**
	 * 
	 * 레지스트리 패스를 배열에 담음
	 * 
	 * @param array $array 저장할 배열
	 * @param array $keys 키 배열 (e.g. /plugin_setting/pdf/ 을 나타내는 배열 => array('plugin_setting', 'pdf')
	 * @param mixed $value 값
	 */
	protected function pathToArray(&$array, array $keys, $value) {
		$last = array_pop($keys);
		foreach($keys as $key) {
			if(!@array_key_exists($key, $array) ||
			@array_key_exists($key, $array) && !is_array($array[$key])) {
				$array[$key] = array();
			}
			$array = &$array[$key];
		}
		$array[$last] = $value;
	}
	
	/**
	 * 
	 * 두 배열을 병합 ($default 배열에 $arr을 합침)
	 * @param array $default
	 * @param array $arr
	 */
	protected function _extend($default, &$arr) {
		foreach($default as $k=>$v) {
			if(!isset($arr[$k])) $arr[$k] = $v;
		}
	}

	/**
	 *
	 * gpf_options 테이블 설치
	 */
	protected function _install()
	{
		$query =<<<EOF
CREATE TABLE IF NOT EXISTS `gpf_options` (
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
EOF;

		$f = explode(";", $query);
		for ($i=0; $i<count($f); $i++) {
			if (trim($f[$i]) == "") continue;
			sql_query($f[$i], false);
		}
	}
}

?>