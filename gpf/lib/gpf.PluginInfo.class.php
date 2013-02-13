<?
/**
 * 
 * GPFPluginInfo 클래스 
 *
 * 플러그인 저자, 버전, 설치, 설정 등의 정보를 제공해서
 * <g4>/adm/gpf 에서 플러그인을 관리할 수 있도록함
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginInfo 
{
	/**
	 * 
	 * @var 플러그인 아이디 (자동설정됨)
	 */
	public $id;

	/**
	 * 
	 * @var 플러그인 버전
	 */
	public $version = 1.0;

	/**
	 * 
	 * @var 플러그인 제작자
	 */
	public $author_name = 'Unknown';

	/**
	 * 
	 * @var 플러그인 제작자
	 */
	public $author_homepage = '';

	/**
	 * 
	 * @var 플러그인 상세 정보 링크
	 */
	public $plugin_link = '';

	/**
	 * 
	 * @var 플러그인 이름
	 */
	public $label;

	/**
	 *
	 * @var string 플러그인 경로
	 */
	public $plugin_path;

	/**
	 *
	 * @var string 데이터 경로
	 */
	public $data_path;


	/**
	 *
	 * @var string 플러그인 js 파일 경로
	 */
	public $jsfile;

	/**
	 *
	 * @var string 플러그인 css 파일 경로
	 */
	public $cssfile;
	

	/**
	 * 생성자
	 */
	public function __construct() {				
		$class_name = substr(get_class($this), 13);
		$class_name{0} = strtolower($class_name{0});
		$this->id = $this->label = $class_name;
		$this->plugin_path = GPF_PATH."/plugins/".$class_name;
		$this->data_path = GPF_PATH."/data/plugins/".$class_name;				
		$this->jsfile = GPF_PATH."/data/js/".$this->id.".js";
		$this->cssfile = GPF_PATH."/data/css/".$this->id.".css";
	}
	
	/**
	 *
	 * js 내용 업데이트
	 */
	public function updateJS($js_content)
	{
		$fp = fopen($this->jsfile, "w");
		fwrite($fp, $js_content);
		fclose($fp);

		include_once GPF_PATH."/lib/gpf.JSCSS.class.php";
		$gpfjc = new GPFJsCss();
		$gpfjc->updateJs();
	}

	/**
	 *
	 * js 파일 삭제
	 */
	public function clearJS()
	{
		@unlink($this->jsfile);
		include_once GPF_PATH."/lib/gpf.JSCSS.class.php";
		$gpfjc = new GPFJsCss();
		$gpfjc->updateJs();
	}

	/**
	 *
	 * css 내용 업데이트
	 */
	public function updateCSS($css_content)
	{
		$fp = fopen($this->cssfile, "w");
		fwrite($fp, $css_content);
		fclose($fp);
		include_once GPF_PATH."/lib/gpf.JSCSS.class.php";
		$gpfjc = new GPFJsCss();
		$gpfjc->updateCss();
	}

	/**
	 *
	 * css 파일 삭제
	 */
	public function clearCSS()
	{
		@unlink($this->cssfile);
		include_once GPF_PATH."/lib/gpf.JSCSS.class.php";
		$gpfjc = new GPFJsCss();
		$gpfjc->updateCss();
	}


	/**
	 *
	 * 등록된 event, px, admin 정보 반환
	 */	
	public function getFunctions() 
	{ 
		$gpf = GPF::getInstance();

		// 반환 형식 예제
		$p = $gpf->readPlugin($this->id);
		if(!$p) return null;

		$dummy = new GPFDummy();
		$p->regist($dummy);
		
		return $dummy->getAuths();
	}

	/**
	 *
	 * 플러그인 설정해야 하나?
	 *
	 * @see $g4['adm_path']/gpf/plugins.php
	 * 플러그인에서 중복구현 되어야 함
	 *
	 * @return true|false 설치해야 하면 true, 아니면 false
	 */
	public function shouldSetup() { return false;	}

	/**
	 *
	 * 플러그인 설치해야 하나?
	 *
	 * @see $g4['adm_path']/gpf/plugins.php
	 * 플러그인에서 중복구현 되어야 함
	 *
	 * @return true|false 설치해야 하면 true, 아니면 false
	 */
	public function shouldInstall() { return false;	}


	/**
	 *
	 * 플러그인 언인스톨해야 하나?
	 *
	 * @see $g4['adm_path']/gpf/plugins.php
	 * 플러그인에서 중복구현 되어야 함
	 *
	 * @return true|false 언인스톨해야 하면 true, 아니면 false
	 */
	public function shouldUnInstall() { return false;	}


	/**
	 *
	 * 플러그인 설정
	 *
	 * @see $g4['path']/gpf/plugin_setup.php
	 * 플러그인에서 중복구현 되어야 함
	 */
	public function setup() { }

	/**
	 *
	 * 플러그인 설치
	 *
	 * @see adm/plugin_install.php
	 * 플러그인에서 중복구현 되어야 함
	 */
	public function install() { }

	/**
	 *
	 * 플러그인 삭제
	 *
	 * @see adm/plugin_install.php
	 * 플러그인에서 중복구현 되어야 함
	 */
	public function uninstall() { }


	/**
	 *
	 * 관리자페이지에서 플러그인을 비활성화할 때 호출
	 *
	 * @see $g4['adm_path']/gpf/exe/plugins.php
	 * 플러그인에서 중복구현 되어야 함
	 */	
	public function onDeactivated() {}

	/**
	 *
	 * 관리자페이지에서 플러그인을 활성화할 때 호출
	 *
	 * @see $g4['adm_path']/gpf/exe/plugins.php
	 * 플러그인에서 중복구현 되어야 함
	 */	
	public function onActivated() {}
}






























class GPFDummy
{
	var $auths = array();

	public function __construct() {				
	}
	public function addAction($event, $obj, $handler)
	{
		array_push($this->auths, $event);
	}
	public function addAdmin($label, $obj, $handler)
	{
		array_push($this->auths, $label);
	}
	public function addHelper($name, $obj, $help_function)
	{
		array_push($this->auths, $name);
	}
	public function addPx($event, $obj, $handler)
	{
		array_push($this->auths, "PX_".strtoupper($event));
	}
	public function getAuths() { return $this->auths; }
}
?>
