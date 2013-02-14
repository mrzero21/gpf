<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */
if(!defined("__RB__")) die("잘못된 접근입니다.");

if($md != 'w') alert('잘못된 접근');

$grade = explode("\n", $rb_config['grade']);
if(empty($grade)) alert('구분관리를 입력하세요');

$current_config = gpf_get_option('/rollbook_config');

$current_config['passwd'] = $rb_config['passwd'];
$current_config['title'] = $rb_config['title'];
$current_config['teacher_level'] = $rb_config['teacher_level'];
$current_config['read_level'] = $rb_config['read_level'];
$current_config['default_stat'] = $rb_config['default_stat'];
$current_config['enum_stat'] = array("1"=>$rb_config['enum_1'], "-1"=>$rb_config['enum_2'], "0"=>$rb_config['enum_3']);
$current_config['grade'] = $grade;
$current_config['skin'] = $rb_config['skin'];
$current_config['head'] = $rb_config['head'];
$current_config['tail'] = $rb_config['tail'];

gpf_set_option('/rollbook_config', $current_config);	

goto_url(gpf_rb_adm_url('config'));


?>
