<?
/**
 * 
 * skin includer
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가


// 이벤트명 : write_update.head.skin.php ==> WRITE_UPDATE.HEAD
$event_name = strtoupper(str_replace(".skin.php", "", $gpf_include));

// 등록된 이벤트 처리기 실행 후 반환되는 배열을 extract
gpf_trigger(GPF_PRE_EVENT_PREFIX.$event_name);

// 스킨 경로 변경
$config['cf_search_skin'] = GPF_SEARCH_SKIN;
$sc_skin_path = "$g4[path]/skin/search/{$config['cf_search_skin']}";

// 스킨 파일에서 path 사용시 생길 수 있는 오류 수정을 위해 출력버퍼를 가져와 보정함
ob_start();
@include $sc_skin_path."/".$gpf_include;
$out = ob_get_contents();
ob_end_clean();
if($out) echo str_replace($search_skin_path, $sc_skin_path, $out);

// 등록된 이벤트 처리기 실행 후 반환되는 배열을 extract
gpf_trigger(GPF_POST_EVENT_PREFIX.$event_name);

unset($out);
unset($gpf_include);

// 스킨 경로 재설정
$search_skin_path = "$g4[path]/skin/member/{$config['cf_member_skin']}";

?>