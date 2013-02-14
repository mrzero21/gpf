<?
if (!defined("GPF")) exit; // 개별 페이지 접근 불가 
?>
<div style="margin-top:20px;width:100%;padding:0 0 5px 0;height:25px">

	<? /* <!------------------------ 구글+ 버튼 -------------------------------> */?>
	<div style="float:right;">
		<link rel="canonical" href="<?=$google_p?>" /><?/*현제페이지 URL*/?>
		<g:plusone size="medium" annotation="inline" width="170"></g:plusone>
		<script type="text/javascript">
		window.___gcfg = {
			lang: 'ko'
		}; // 언어를 한국어로
		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
		</script>
	</div>
	<? /* <!----------------------- /구글+ 버튼/ ------------------------------> */?>
	
	<? /* <!------------------ 페이스북 좋아요 버튼 ---------------------------> */?>
	<div style="float:right;margin-right:10px;">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1&appId=133896173354212";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-like" data-href="<?=$facebook_like?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>	
	</div>
	<? /* <!----------------- /페이스북 좋아요 버튼/ --------------------------> */?>

	<? /* <!--------------------- 네이트온으로 보내기 -----------------------------> */?>
	<div style="float:right;margin-right:3px;">
		<script language="javascript" type="text/javascript" src="http://api.nateon.nate.com/js/note/type_small.js"></script>
		<meta name="nate-note" content="원문 제목: <?=$view['wr_subject']?>">
	</div>
	<? /* <!-------------------- /네이트온으로 보내기/ ----------------------------> */?>

	<? /* <!---------------------- 에버노트로 보내기 ------------------------------> */?>
	<div style="float:right;margin-right:3px;">
	<script type="text/javascript" src="http://static.evernote.com/noteit.js"></script>
	<a href="#" onclick="Evernote.doClip({providerName:'<?=$config['cf_title']?>',url:'<?=$board_url?>',suggestNotebook:'<?=$config[cf_title]?>',contentId:'writeContents'}); return false;"><img src="http://static.evernote.com/article-clipper.png" alt="Clip to Evernote" /></a>
	</div>
	<? /* <!--------------------- /에버노트로 보내기/ -----------------------------> */?>

	<? /* <!----------------------- 네이버로 북마크 -------------------------------> */?>
	<div style="float:right;margin-right:3px;"><a href="http://bookmark.naver.com/post?ns=1&title=<?=$subject?>&url=<?=$board_url?>" target="_blank"><img src="<?=$plugin_url?>/icons/naver.png" width="25" height="25" alt="게시글을 네이버로 북마크 하기" border="0"></a></div>
	<? /* <!---------------------- /네이버로 북마크/ ------------------------------> */?>

	<? /* <!----------------------- 요즘으로 보내기 -------------------------------> */?>
	<div style="float:right;margin-right:3px;"><img src="<?=$plugin_url?>/icons/yozm.png" onclick="window.open('http://yozm.daum.net/api/popup/prePost?sourceid=41&link=<?=$yozm_url?>&prefix=<?=$yozm_subject?>','window','width=600,height=430')" style="cursor:pointer" width="25" height="25" alt="게시글을 요즘으로 보내기" border="0"></div>
	<? /* <!---------------------- /요즘으로 보내기/ ------------------------------> */?>

	<? /* <!---------------------- 미투데이로 보내기 ------------------------------> */?>
	<div style="float:right;margin-right:3px;"><a href='http://me2day.net/posts/new?new_post[body]=<?=$me2_subject?>+++++++["<?=$me2_url_text?>":<?=$me2_url?>+]&new_post[tags]=<?=$me2_teg?>'  target="_blank"><img src="<?=$plugin_url?>/icons/Me2Day.png" width="25" height="25" border="0" alt="게시글을 Me2Day로 보내기"></a></div>
	<? /* <!--------------------- /미투데이로 보내기/ -----------------------------> */?>

	<? /* <!------------------ 페이스북으로 보내기 강화 ---------------------------> */?>
	<div style="float:right;margin-right:3px;"><img src="<?=$plugin_url?>/icons/facebook.png" width="25" height="25" border="0" onclick="window.open('http://www.facebook.com/sharer/sharer.php?s=100&p%5Btitle%5D=<?=$face_subject?>&p%5Burl%5D=<?=$face_url?>&<?=($face_img ? "p%5Bimages%5D%5B0%5D=$face_img":"")?>&p%5Bsummary%5D=<?=$face_content?>','window','width=600,height=430')" style="cursor:pointer" alt="게시글을 facebook으로 보내기"></div>
	<? /* <!----------------- /페이스북으로 보내기 강화/ --------------------------> */?>

	<? /* <!--------------------- 트위터로 보내기 ------------------------------> */?>
	<div style="float:right;margin-right:3px;"><img src="<?=$plugin_url?>/icons/twitter.png" onclick="window.open('http://twitter.com/?status=<?=$url?>','window','width=600,height=430')" style="cursor:pointer" width="25" height="25" border="0" alt="게시글을 twitter로 보내기"></div>
	<? /* <!-------------------- /트위터로 보내기/ -----------------------------> */?>

</div>