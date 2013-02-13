<?
/**
 * 
 * 대시보드
 *
 * @author	chongmyung.park (http://byfun.com)
 */

include_once("./_common.php");

auth_check($auth[$sub_menu], "r");

$g4['title'] = "GPF 대시보드";

include_once("gpf.head.php");

?>
<style type="text/css">
#gpf_dashboard { font-size:10pt; line-height:160%; }
.gd_section { position:relative; padding:10px; margin-left:10px; }
</style>

<div id="gpf_dashboard">
	<h1>GPF 대시보드</h1>

	<h2>GPF 커뮤니티</h2>

	<div class="gd_section">
		<iframe src="http://byfun.com/axis/gpf_dashboard.php" style="width:100%;height:200px;border:0;overflow:hidden;" scrolling="no" frameborder="0"></iframe>
	</div>

	<br/>

	<h2>Copyright</h2>
	
	<div class="gd_section">

		2002-<?=date('Y')?> © <a href="http://byfun.com/" target="_blank">byfun.com</a><br/>
		<br/>
		GPF (Gnuboard Plugin Framework)는 <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GNU GPL V2</a> 로 개발되었습니다. <br/>
		여타의 Open Source 프로그램과 마찬가지로 무료로 사용하실 수 있도록 개발되었습니다. <br/>
		더 나은 소프트웨어 개발을 후원해주세요 : <a href="http://byfun.com/donation" target="_blank" style="color:red;font-weight:bold">[후원하기]</a>
	
	</div>

</div>

<script type="text/javascript">

</script>

<?
include_once("gpf.tail.php");
?>
