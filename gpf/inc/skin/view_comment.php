<?
/**
 * 
 * view_comment.php 를 가로챔
 *
 */
 
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

// 스킨 경로를 <gpf>/inc/skin 으로 변경
$board_skin_path = GPF_INC_SKIN_PATH;

// 스킨 파일에서 path 사용시 생길 수 있는 오류 수정을 위해 출력버퍼를 가져와 보정함
ob_start();
include_once $g4['bbs_path']."/view_comment.php";
$out = ob_get_contents();
ob_clean();

if($out) echo str_replace(GPF_INC_SKIN_PATH, GPF_SKIN_PATH, $out);

unset($out);

// 스킨 경로를 다시 원래 스킨으로 돌려놓음
$board_skin_path = GPF_SKIN_PATH;
?>
