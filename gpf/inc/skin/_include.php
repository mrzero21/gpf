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
$board_skin_path = GPF_SKIN_PATH;


// view_comment.php 를 가로채기 위한 방법
// * 조건
//   <g4>/skin/board/스킨/view.skin.php 에서 댓글 include 방식을
//   include_once("./view_comment.php"); 에서
//   include_once("view_comment.php"); 이렇게 변경해야 함
$gpf_inc_path = dirname(__FILE__);
$gpf_current_incs = get_include_path();
set_include_path($gpf_inc_path . PATH_SEPARATOR . $gpf_current_incs);

// 스킨 파일에서 path 사용시 생길 수 있는 오류 수정을 위해 출력버퍼를 가져와 보정함
ob_start();
@include GPF_SKIN_PATH."/".$gpf_include;
$out = ob_get_contents();
ob_end_clean();
if($out) echo str_replace(GPF_INC_SKIN_PATH, GPF_SKIN_PATH, $out);

set_include_path($gpf_current_incs);
unset($gpf_current_incs);
unset($gpf_inc_path);

// 등록된 이벤트 처리기 실행 후 반환되는 배열을 extract
gpf_trigger(GPF_POST_EVENT_PREFIX.$event_name);

unset($out);
unset($gpf_include);

// 스킨 경로 재설정
$board_skin_path = GPF_INC_SKIN_PATH;

?>