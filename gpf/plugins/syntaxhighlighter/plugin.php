<?
/**
 * 
 * 문법강조(Syntax Highlighter) 플러그인 클래스
 *
 * @license GPL2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("GPF")) exit; // 개별 페이지 접근 불가 

class GPFPluginSyntaxhighlighter extends GPFPlugin 
{	

	var $codes = array();
	var $no_codes = array();

	/**
	 * 
	 * @see lib/GPFPlugin::register()
	 */
	public function regist($gpf)
	{
		$gpf->addAction("PRE_VIEW", $this, "on_view");
	}

	/**
	 * 핸들러 : view.skin.php 가 include 되기 직전 호출됨
	 * 반환 : array('view'=>....) 를 반환하여, view.skin.php 의 $view 를 변경함
	 */
	public function on_view($event, $g)
	{
		$view = $g['view'];
		$sh_path = $g['g4']['path']."/gpf/plugins/".$this->id."/sh";

		preg_replace_callback('/\[code\s?([\w]{0,})\](.*?)\[\/code\]/si',array($this,"_save_code"), $view['wr_content']);

		$view['content'] = preg_replace_callback('/\[code\s?([\w]{0,})\](.*?)\[\/code\]/si', array($this, "do_parse"), $view['content']);

		?>
		<script type="text/javascript" src="<?=$sh_path?>/scripts/shCore.js"></script>
		<script type="text/javascript" src="<?=$sh_path?>/scripts/shBrushAll.js" ></script>
		<link type="text/css" rel="stylesheet" href="<?=$sh_path?>/styles/shCore.css"/>
		<link type="text/css" rel="stylesheet" href="<?=$sh_path?>/styles/shThemeDefault.css"/>
		<script type="text/javascript">
			SyntaxHighlighter.config.clipboardSwf = '<?=$sh_path?>/scripts/clipboard.swf';
			SyntaxHighlighter.all();
		</script>		
		<?	
		
		return array('view'=>$view);
	}
	
	/**
	 * [code 언어] .. [/code] 태그 치환
	 */
	private function do_parse($matches)
	{
		$code = $this->codes[0];
		array_shift($this->codes);
		return "<pre class='brush: {$matches[1]}'>".$code."</pre>";	
	}

	/**
	 * 미리 원본 코드를 백업해 놓음 (그누보드의 html 모드 때문에.. T_T)
	 */
	protected function _save_code($matches)
	{
		array_push($this->codes, $matches[2]);
	}



}

?>