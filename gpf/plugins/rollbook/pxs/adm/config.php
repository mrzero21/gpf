<?
/**
 * 프로그램명 : 교회 출석부
 * 개발자 : 박총명 (chongmyung.park@gmail.com)
 * 본 프로그램의 수정후 재배포를 금합니다.
 */

$pageid = "config";

include_once "admin.head.php";

$skins = rb_get_skins();
$rb_config['title'] = $rb['title'];
$rb_config['passwd'] = $rb['passwd'];
$rb_config['teacher_level'] = $rb['teacher_level'];
$rb_config['read_level'] = $rb['read_level'];
$rb_config['default_stat'] = $rb['default_stat'];
$rb_config['enum_1'] = $rb['enum_stat'][1];
$rb_config['enum_2'] = $rb['enum_stat'][-1];
$rb_config['enum_3'] = $rb['enum_stat'][0];
$rb_config['head'] = $rb['head'];
$rb_config['tail'] = $rb['tail'];
$rb_config['grade'] = implode("\n", $rb['grade']);
?>

<style type="text/css">
#rb_config_tbl { font-size:10pt; border-top:2px solid #ccc; width:100%; }
#rb_config_tbl th { background-color:#eaeaea; text-align:right;}
#rb_config_tbl th,
#rb_config_tbl td { border-bottom:1px solid #ccc; padding:8px 5px;}
#rb_config_tbl .nphelp { color:#888; font-size:0.95em; }
#rb_config_tbl .npitxt { width:100px; }
</style>

<h2>기본 설정</h2>

<form name="cfgfrm" method="post" action="<?=GPF_ADMIN_PATH?>/plugin_setup.php">
<input type="hidden" name="p" value="rollbook"/>
<input type="hidden" name="c" value="exe_config"/>
<input type="hidden" name="md" value="w"/>
<table cellspacing="0" cellpadding="0" id="rb_config_tbl">
<colgroup><col width="130px"/><col width="220px"/><col/></colgroup>
<tr>
	<th>출석부명</th>
	<td><input type="text" class="npitxt" style="width:100%" name='rb_config[title]' value="<?=htmlspecialchars($rb_config['title'])?>"/></td>
	<td class="nphelp"></td>
</tr>

<tr>
	<th>선생님 권한</th>
	<td>
		<select name='rb_config[teacher_level]'>
		<? for($i=1; $i<=10; $i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
		</select>
		<script type="text/javascript">
			$('select[name="rb_config[teacher_level]"]').val('<?=$rb_config['teacher_level']?>');
		</script>
	</td>
	<td class="nphelp">그룹, 클래스, 출석부를 추가하고 출결체크를 할 수 있는 권한</td>
</tr>

<tr>
	<th>출석부 열람 권한</th>
	<td>
		<select name='rb_config[read_level]'>
		<? for($i=1; $i<=10; $i++) echo '<option value="'.$i.'">'.$i.'</option>'; ?>
		</select>
		<script type="text/javascript">
			$('select[name="rb_config[read_level]"]').val('<?=$rb_config['read_level']?>');
		</script>
	</td>
	<td class="nphelp">출석부를 열람할 수 있는 권한</td>
</tr>

<tr>
	<th>삭제 비밀번호</th>
	<td><input type="password" class="npitxt" style="width:100%" name='rb_config[passwd]' value="<?=htmlspecialchars($rb_config['passwd'])?>"/></td>
	<td class="nphelp"></td>
</tr>

<tr>
	<th>기본상태</th>
	<td>
		<select name='rb_config[default_stat]'>
			<option value="">미정원</option>
			<option value="X">결석</option>
			<option value="O">출석</option>
		</select>
		<script type="text/javascript">
			$('select[name="rb_config[default_stat]"]').val('<?=$rb_config['default_stat']?>');
		</script>
	</td>
	<td class="nphelp">출석부 생성시 학생들의 기본 출석 상태</td>
</tr>

<tr>
	<th>상태표시</th>
	<td colspan="2">
		출석 : <input type="text" class="npitxt" style="width:40px" name='rb_config[enum_1]' value="<?=htmlspecialchars($rb_config['enum_1'])?>"/>
		결석 : <input type="text" class="npitxt" style="width:40px" name='rb_config[enum_2]' value="<?=htmlspecialchars($rb_config['enum_2'])?>"/>
		미정원 : <input type="text" class="npitxt" style="width:40px" name='rb_config[enum_3]' value="<?=htmlspecialchars($rb_config['enum_3'])?>"/>
	</td>

</tr>

<tr>
	<th>구분관리</th>
	<td>
		<textarea class="npitxt" name="rb_config[grade]" style="height:300px"><?=$rb_config['grade']?></textarea>
	</td>
	<td class="nphelp"></td>
</tr>

<tr>
	<th>스킨</th>
	<td>
		<select name='rb_config[skin]'>
		<? foreach($skins as $skin) echo '<option value="'.$skin.'">'.$skin.'</option>'; ?>
		</select>
		<script type="text/javascript">
			$('select[name="rb_config[skin]"]').val('<?=$rb_config['skin']?>');
		</script>
	</td>
	<td class="nphelp"></td>
</tr>

<tr>
	<th>상단파일경로</th>
	<td><input type="text" class="npitxt" style="width:100%" name='rb_config[head]' value="<?=htmlspecialchars($rb_config['head'])?>"/></td>
	<td class="nphelp">그누보드 설치 폴더로 부터의 상대 경로로 입력</td>
</tr>

<tr>
	<th>하단파일경로</th>
	<td><input type="text" class="npitxt" style="width:100%" name='rb_config[tail]' value="<?=htmlspecialchars($rb_config['tail'])?>"/></td>
	<td class="nphelp">그누보드 설치 폴더로 부터의 상대 경로로 입력</td>
</tr>

<tr>
	<th></th>
	<td colspan="2">
		<span class="button black"><input type="submit" value="설정"/></span>
	</td>
</tr>
</table>
</form>


<?
include_once "admin.tail.php";

function rb_get_skins()
{
	global $rb;
	$skins = array();
	$dir = $rb['path'].'/skin';
	$handle = opendir($dir);
	while ($file = readdir($handle))
	{
		if($file{0} == ".") continue;
		if (is_dir($dir."/".$file)) array_push($skins, $file);
	}
	closedir($handle);
	return $skins;
}
?>
