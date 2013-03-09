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
.gd_desc { margin-left:10px;color:#555;font-size:0.9em;  }
</style>

<div id="gpf_dashboard">
	<h1>그누보드 플러그인 프레임워크 <span style='font-size:0.8em'>(Gnuboard Plugin Framework; GPF)</span></h1>
	
	<div class="gd_section">


		GPF는 <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GNU GPL V2</a> 로 개발되었습니다. <br/>
		여타의 Open Source 프로그램과 마찬가지로 무료로 사용하실 수 있도록 개발되었습니다. <br/>
		더 나은 소프트웨어 개발을 후원해주세요 : <a href="http://byfun.com/donation" target="_blank" style="color:red;font-weight:bold">[후원하기]</a>

	</div>
	
	<div class="gd_section">
		<h3>GPF 링크</h3>
		<ul>
			<li><a href="http://byfun.com" target="_blank">개발자 홈페이지</a> <span class='gd_desc'>- 응원의 메시지를 남겨주세요 ^^</span></li>
			<li><a href="https://github.com/byfun/gpf" target="_blank">GPF on GitHub</a> <span class='gd_desc'>- GPF 최신 버전을 다운로드 하실 수 있습니다.</span></li>
			<li><a href="http://lovelyus.net/" target="_blank">GPF 관련 자료실</a> <span class='gd_desc'>- GPF 플러그인, 트윅, 스킨 등을 구하실 수 있습니다.</span></li>
		</ul>
	</div>

	<br/><br/>

	<div style="text-align:center;margin-bottom:30px;">2002-<?=date('Y')?> © <a href="http://byfun.com/" target="_blank">byfun.com</a></div>

</div>

<script type="text/javascript">

</script>

<?
include_once("gpf.tail.php");
?>
