<?
/**
 * 
 * <gpf>/data/gpf.js, css 파일을 읽어와 head.sub.php 에 추가
 *
 * @author	chongmyung.park (http://byfun.com)
 */

if (!defined('_GNUBOARD_')) exit;

$g4 = $GLOBALS['g4'];
$jsfile = GPF_PATH."/data/gpf.js";
$cssfile = GPF_PATH."/data/gpf.css";

if(basename($_SERVER['SCRIPT_NAME']) == 'config_form.php') 
{
?>
<script type="text/javascript">
$(document).ready(function() {
	$('option[value=".gpf"]').remove();
});
</script>
<?
}

if(file_exists($cssfile)) echo "<link rel=\"stylesheet\" href=\"{$g4['url']}/gpf/data/gpf.css\" type=\"text/css\">";
if(file_exists($jsfile)) echo "<script type=\"text/javascript\" src=\"{$g4['url']}/gpf/data/gpf.js\"></script>";

?>