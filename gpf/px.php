<?
/**
 * 
 * 플러그인 실행(Plugin Execution) 페이지
 *
 * @author	chongmyung.park (http://byfun.com)
 */

define("GPF_PX", "DOIT");

include_once "_common.php";

if(!$m) alert('GPF PX : 플러그인 모듈이 필요합니다.');

include_once GPF_PATH."/lib/gpf.GPFPx.class.php";

$gpfPx = GPFPx::getInstance();

$m = strtoupper($m);
if($gpfPx->hasPx($m)) $gpfPx->trigger(strtoupper($m));
else alert('GPF PX : 요청된 모듈이 존재하지 않습니다.');

?>
