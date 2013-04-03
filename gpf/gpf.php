<?
/**
 * 
 * 그누보드 플러그인 프레임워크 : GPF
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

define("GPF", "Gnuboard Plugin Framework");


// Gnuboard Plugin Framework Helper
if(!defined("NO_GPF")) 
{
	include_once GPF_PATH."/lib/gpf.GPF.class.php";
	$gpf = GPF::getInstance();
}












































/**
 *
 * 이벤트 트리거
 *
 * @param string $name 옵션명
 * @param mixed $array 값
 */
function gpf_trigger($event, $params = array()) {	
	if(defined("NO_GPF")) return;
	return GPF::getInstance()->trigger($event, $params); 
}

/**
 *
 * 옵션 설정
 *
 * @param string $name 옵션명
 * @param mixed $array 값
 */
function gpf_set_option($name, $array)
{
	$name = mysql_real_escape_string($name);
	sql_query("DELETE FROM gpf_options WHERE name = '$name'");
	$json = mysql_real_escape_string(json_encode($array));
	$sql = "INSERT INTO	gpf_options VALUES ('$name', '$json')";
	sql_query($sql);
	return true;
}


/**
 *
 * 옵션 반환
 *
 * DB의 option_table은 'name (varchar 255)', 'content (text)' 필드로 되어있으며,
 * gpf_get_option, gpf_set_option 함수를 이용해 json 데이터로 저장하고 읽어온다.
 *
 * gpf_get_option($name) 으로 데이터 전체를 가져올 수 있고,
 *
 * 사용 예 :
 * <code>
 * // 값 셋팅
 * gpf_set_option("js_modified", "timestamp", time());
 *
 * // js_modified 옵션 읽어오기
 * $modified = gpf_get_option("js_modified");
 * echo $modified['timestamp'];
 *
 * </code>
 *
 * @param string $name 옵션명
 * @return mixed option_table 에 설정된 값 (없을 경우 null)
 */
function gpf_get_option($name)
{
	$name = mysql_real_escape_string($name);
	$opt = sql_fetch("SELECT content FROM gpf_options WHERE name = '$name'");
	if($opt) {
		return json_decode($opt['content'], $assoc=true);
	}
	return null;
}

/**
 *
 * 옵션 삭제
 */
function gpf_del_option($name) 
{
	$name = mysql_real_escape_string($name);
	$opt = sql_query("DELETE FROM gpf_options WHERE name = '$name'");
}

/**
 *
 * 모든 플러그인 정보 반환 (사용되지 않는 플러그인 포함)
 */
function gpf_die($msg)
{
	global $g4, $is_admin;
	
	$backtrace = debug_backtrace();
	$calling = array_pop($backtrace);	

	$content =<<<EOF
<meta http-equiv="content-type" content="text/html; charset={$g4['charset']}">
<div style='width:50%;margin:50px auto;padding:20px;border-bottom:1px solid #eaeaea;'>
	<h1 style='font-size:16pt;border:1px solid #eaeaea;border-left:8px solid #ccc;padding:10px'>그누보드 플러그인 프레임워크 에러</h1>
	<div style='padding:10px;background-color:#fff;'>$msg</div>

EOF;

	if($is_admin) {
		$content .=<<<EOF
		<div style="padding:10px;font-size:0.8em">
			파일 : {$calling['file']} <br/>
			라인 : {$calling['line']}
		</div>
EOF;
	}

	$content .= "</div>";

	die($content);
}


?>
