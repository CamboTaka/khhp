<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 最終更新日2014/12/12
#　改造や改変は自己責任で行ってください。
#
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "http://cambodia.fuji-realty.asia";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "fj_support@fuji-realty.asia";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "Email";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　
※有効にするにはこのファイルとフォームページが同一ドメイン内にある必要があります
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------


// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "[富士リアルティ]お問い合わせが入りました。";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 0;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 0;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです。
配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。*/
$require = array('お名前','Email');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "[富士リアルティ(株)] カンボジア支店";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "[富士リアルティ(株)]お問い合わせ頂きありがとうございました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
$remail_text = <<< TEXT

この度は、弊社へお問い合わせ頂き誠に有難うございます。
頂きましたお問い合わせ内容につきまして、早急にご返信致しますので
今しばらくお待ちくださいませ。

送信内容は以下になります。
今一度ご確認頂きます様宜しくお願い致します。

TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 1;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER
※このメールアドレスは送信専用となっておりますので、返信はお受け
　できません。返信いただいてもお問い合わせにはお答えできませんので
　あらかじめご了承ください。
──────────────────────
(Century21)Branch of Fuji Realty Co.,Ltd
富士リアルティ(株)カンボジア支店
#320, Monivong Blvd, Cross 252, Sk. Chaktomuk, Kh.
Daun Penh, Phnom Penh, Cambodia
TEL：023-219-021(カンボジア国内)
TEL：+855-23-219-021(カンボジア国外からの場合)
E-mail:fj_support@fuji-realty.asia
URL: http://cambodia.fuji-realty.asia/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 1;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('thai','japan');


//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。


//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）

if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if($requireCheck == 1) {
	$requireResArray = requireCheck($require);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1 && !empty($val)){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">【".$key."】はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}

if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){

	//差出人に届くメールをセット
	if($remail == 1) {
		$userBody = mailToUser($_POST,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode);
		$reheader = userHeader($refrom_name,$to,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp);
	$header = adminHeader($userMail,$post_mail,$BccMail,$to);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";

	mail($to,$subject,$adminBody,$header);
	if($remail == 1 && !empty($post_mail)) mail($post_mail,$re_subject,$userBody,$reheader);
}
else if($confirmDsp == 1){

/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="copyright" content="Template Party">
<meta name="description" content="カンボジアプノンペンの不動産で賃貸物件や売買物件、仲介投資物件のことならBranch of Fuji Realty Co.,Ltdにお任せ下さい。">
<meta name="keywords" content="カンボジア,プノンペン,不動産,仲介,賃貸,売買,移住,コンドミニアム,アパートメント,サービスアパートメント,Villa,フラットハウス">
<meta name="google-site-verification" content="NuHY4F3SsMh4j1LTfRfBF2DuryWMemujCTJlgtIu1H8" />
<link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/png" href="/images/favicon.png">
<link href="css/hover-min.css" rel="stylesheet" media="all">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="?act=rss20">
<meta name="google-site-verification" content="NuHY4F3SsMh4j1LTfRfBF2DuryWMemujCTJlgtIu1H8" />
<title>お問い合わせ確認画面 | カンボジアの不動産ならBranch of Fuji Realty Co.,Ltdまで</title>
<style type="text/css">
/* 自由に編集下さい */
#formWrap {
	width:100%;
	margin:0 auto;
	color: #000;
	line-height:120%;
	font-size:90%;
}
table.formTable{
	width:100%;
	margin:0 auto;
	border-collapse:collapse;
}
table.formTable td,table.formTable th{
	border:1px solid #ccc;
	padding:10px;
}
table.formTable th{
  font-weight: normal;
  background: #efefef;
  width: 140px;
	height: 48px;
  padding: 10px;
  text-align: center;
  background-color: #ffeeb3;
	font-size: 10pt;
	font-weight: bold;
  color: black;
}
p.error_messe{
	margin:5px 0;
	color:red;
}
</style>
</head>
<body>
	<header>
    <div id="title">
      <div class="wrap">
        <h1>お問い合わせ確認画面 | カンボジアの不動産のご相談は、センチュリー21 Branch of Fuji Realty Co.,Ltdまで！</h1>
        <a class="right" style="color: white;" href="./?act=list&html=contact.html" target="_blank">&gt; お問い合わせ</a>
        <a class="right" style="color: white;" href="./?act=list&html=company.html" target="_blank">&gt; 会社概要</a>
      </div>
    </div>
    <div class="inner">
      <div id="imgtiltle">
        <img id="imgtitle" src="../images/title_1.jpg" alt="タイトル">
      </div>
      <div id="kennsuu">
        <img src="../images/topq.png" alt="トップクオリティー" />
      </div>
      <h1><a href=""><img src="images/fuji-03.png" alt="Logo" id="logo"></a></h1>
      <address>
        <div id="addr">
          <img src="../images/tel_info.jpg" alt="電話番号" />
        </div>
      </address>
    </div>
  </header>

	<nav id="menubar" class="navre">
    <ul class="menu">
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/">ホーム<span>HOME</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&kind=1">賃貸物件を探す<span>FIND FOR RENT</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&kind=2">購入物件を探す<span>FIND FOR SALE</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&html=cambodia-property-seminar.html">セミナー/ツアー<span>SEMINAR / TOUR</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&html=aboutcambodia.html">カンボジアについて<span>ABOUT CAMBODIA</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&html=company.html">会社案内<span>OUR COMPANY</span></a></li>
      <li class="hvr-rectangle-out"><a href="http://cambodia.fuji-realty.asia/?act=list&html=contact.html">お問い合わせ<span>CONTACT US</span></a></li>
    </ul>
    <span id="slide-line"></span>
  </nav>

	<div id="contents">

		<div id="contents-in">

			<div id="main">

				<div id="formWrap">

					<section>
						<form method="post" action="mail.php">
							<h2 class="mb15">お問い合わせ内容確認画面</h2>
							<div style="border:1px solid #FFDD3C; padding-bottom:15px">
								<div style="padding:15px 20px;  background:#FFEEB3; font-weight:bold; font-size:18px;">
									<span>お電話でお問い合わせの方はこちら</span>
								</div>
								<div style="width:420px; float:left; margin:20px auto auto 20px; text-align:center;">
									<span>お気軽にお問い合わせください。日本語・英語・クメール語可能</span><br />
									<img src="./images/footer_logo.jpg" alt="logo" />
								</div>
								<div style="clear:both"></div>
							</div>
							<div style="border:1px solid #FFDD3C; padding-bottom: 15px; margin-top: 10px;">
								<div style="padding:15px 20px;  background:#FFEEB3; font-weight:bold; font-size:18px;">
									<span>フォームでのお問い合わせはこちら</span>
								</div>
								<div style="width:420px; float:left; margin:20px auto auto 20px; text-align:center;">
									<span>物件に関するお問い合わせから、住まい探しの様々な疑問点まで、お気づきの点がございましたら、お気軽にお問い合わせください。</span>
								</div>
								<div style="clear:both"></div>
							</div>
							<div class="form_table_01"> お問い合わせ内容確認画面</div>
							<ol class="stepBar step3">
								<li class="step">情報入力</li>
								<li class="step current">内容確認</li>
								<li class="step">完了</li>
							</ol>
							<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
							<div id="formWrap">
							<?php if($empty_flag == 1){ ?>
							<div align="center">
							<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
							<?php echo $errm; ?><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
							</div>
							<?php }else{ ?>
							<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="POST">
							<table class="formTable">
							<?php echo confirmOutput($_POST);//入力内容を表示?>
							</table>
							<p align="center">上記の内容で間違いがなければ、「送信する」ボタンを押してください。</p>
							<p align="center"><input type="hidden" name="mail_set" value="confirm_submit">
							<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']);?>">
							<input type="submit" value="　送信する　">
							<input type="button" value="前画面に戻る" onClick="history.back()"></p>
							</form>
							<?php } ?>
							</div><!-- /formWrap -->
							<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->
						</form>
					</section>
				</div>
			</div>
			<div id="sub">

				<nav id="box1">

					<section id="new">
						<a href="./?act=list&html=web_flyer.html"><img src="../images/chirashi.jpg" alt="WEBチラシ" /></a>
					</section>

					<h2><i aria-hidden="true"></i> 賃貸物件カテゴリー<br><small>Select by property type</small></h2>
					<ul>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%B5%E3%83%BC%E3%83%93%E3%82%B9%E3%82%A2%E3%83%91%E3%83%BC%E3%83%88%E3%83%A1%E3%83%B3%E3%83%88&info8=&info20=&info17=&info4=&info1=">サービスアパートメント<br /><small>Serviced Apartment</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%A2%E3%83%91%E3%83%BC%E3%83%88%E3%83%A1%E3%83%B3%E3%83%88&info8=&info20=&info17=&info4=&info1=">アパートメント<br /><small>Apartment</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%83%95%E3%83%A9%E3%83%83%E3%83%88%E3%83%8F%E3%82%A6%E3%82%B9&info8=&info20=&info17=&info4=&info1=">フラットハウス<br /><small>Flat House</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%B0%E3%83%A9%E3%83%B3%E3%83%89%E3%83%B4%E3%82%A3%E3%83%A9&info8=&info20=&info17=&info4=&info1=">グランドヴィラ<br /><small>Grand Villa</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%83%A9%E3%83%B3%E3%83%89%28%E5%9C%9F%E5%9C%B0%29&info8=&info20=&info17=&info4=&info1=">ランド(土地)<br /><small>land</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%AA%E3%83%95%E3%82%A3%E3%82%B9&info8=&info20=&info17=&info4=&info1=">オフィス<br /><small>Office</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%B7%E3%83%A7%E3%83%83%E3%83%97&info8=&info20=&info17=&info4=&info1=">ショップ<br /><small>Shop</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%82%B3%E3%83%B3%E3%83%89%E3%83%9F%E3%83%8B%E3%82%A2%E3%83%A0&info8=&info20=&info17=&info4=&info1=">コンドミニアム<br /><small>Condominium</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%83%93%E3%83%AB%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0&info8=&info20=&info17=&info4=&info1=">ビルディング<br /><small>Building</small></a></li>
					</ul>
				</nav>

				<nav id="box1">
					<h2><i aria-hidden="true"></i> 売買物件カテゴリー<br><small>Select by property type</small></h2>
					<ul>
						<li><a href="#">コンドミニアム<br /><small>Condominium</small></a></li>
						<li><a href="#">フラットハウス<br /><small>Frat House</small></a></li>
						<li><a href="#">グランドビラ<br /><small>Ground Villa</small></a></li>
						<li><a href="#">倉庫<br /><small>Warehouse</small></a></li>
					</ul>
				</nav>

				<nav id="box1">
					<h2><i aria-hidden="true"></i> 間取りで検索<br><small>Choose by floor plan</small></h2>
					<ul>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=%E3%82%B9%E3%82%BF%E3%82%B8%E3%82%AA%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">スタジオルーム<br /><small>Studio Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=1%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">1ベットルーム<br /><small>1Bed Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=2%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">2ベットルーム<br /><small>2Bed Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=3%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">3ベッドルーム<br /><small>3Bed Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=4%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">4ベッドルーム<br /><small>4Bed Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=5%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">5ベッドルーム<br /><small>5Bed Room</small></a></li>
						<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=&info8=6%E3%83%99%E3%83%83%E3%83%89%E3%83%AB%E3%83%BC%E3%83%A0&info20=&info17=&info1=">6ベッドルーム<br /><small>6Bed Room</small></a></li>
					</ul>
				</nav>

				<nav id="box1">
					<h2><i class="fa fa-map" aria-hidden="true"></i> エリアから選ぶ<br><small>Select by area</small></h2>
					<ul>
						<li><a class="hvr-bubble-right" href="#">セントラル・マーケット周辺<br><small>Central Market Area</small></a></li>
						<li><a class="hvr-bubble-right" href="#">ダイヤモンドアイランド周辺<br><small>Diamond Island Area</small></a></li>
						<li><a class="hvr-bubble-right" href="#">ボンケンコンエリア<br><small>Bokkenkon Area</small></a></li>
						<li><a class="hvr-bubble-right" href="#">リバーサイド・王宮エリア<br><small>Riverside Area</small></a></li>
					</ul>
				</nav>

				<section class="box1">
					<h2><i class="fa fa-building-o" aria-hidden="true"></i> 店舗情報<br><small>Store information</small></h2>
					<p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.9337830054774!2d104.91843581415588!3d11.55660474746948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513c8ff51947%3A0xf48ed569e606e2e5!2sFuji+Housing!5e0!3m2!1sen!2sjp!4v1490236133432"
							width="100%" height="188" frameborder="0" style="border:0" allowfullscreen></iframe></p>
					<p><i class="fa fa-map-marker" aria-hidden="true"></i> アドレス<br> #320, Monivong Blvd, Cross 252, Sk. Chaktomuk, Kh. Daun Penh, Phnom Penh, Cambodia</p>
					<p><i class="fa fa-clock-o" aria-hidden="true"></i> 営業時間<br> 9:00～17:00（月～金）
						<br>土曜日はお問い合せ下さい。</p>
					<p><a href="#"><input type="submit" value="お問い合わせ"></a></p>
				</section>

			</div>
			<!--/sub-->
		</div>
		<!--/contents in-->
		<div id="side">

			<h2 id="newinfo_hdr" class="close">カンボジア只今の時間</h2>
			<section class="mb1em" id="clock">
				<iframe scrolling="no" frameborder="no" clocktype="html5" style="overflow:hidden;border:0;margin:0;padding:0;width:227px;height:75px;" src="http://www.clocklink.com/html5embed.php?clock=008&timezone=Cambodia_PhnomPenh&color=orange&size=227&Title=&Message=&Target=&From=2017,1,1,0,0,0&Color=orange"></iframe>
			</section>

			<h2 id="newinfo_hdr" class="close">最新為替状況</h2>
			<section class="mb1em">
				<script type="text/javascript" src="http://ja.exchange-rates.org/GetCustomContent.aspx?sid=RT000DSNE&amp;type=RatesTable&amp;stk=0HW52Z014M" charset="utf-8">
				</script>
				<div>提供: <a href="http://ja.exchange-rates.org/" rel="nofollow">ja.exchange-rates.org</a></div>
			</section>

			<section class="mb1em">
				<a href="http://thepeak.fuji-realty.asia/" target="_blank"><img src="images/thepeak.jpg" width="250" height="240" alt="The Peak"></a>
				<p><small><a href="http://thepeak.fuji-realty.asia/" target="_blank">カンボジアで投資物件なら<br>THE PEAK</a></small></p>
			</section>

			<section class="mb1em">
				<a href="http://time-square.fuji-realty.asia/" target="_blank"><img src="images/timesquare.jpg" width="250" height="240" alt="タイムスクエア"></a>
				<p><small><a href="http://time-square.fuji-realty.asia/" target="_blank">カンボジアで投資物件なら<br>TIME SQUARE</a></small></p>
			</section>

			<section class="mb1em">
				<a href="http://theview.fuji-realty.asia/" target="_blank"><img src="images/theview.jpg" width="250" height="240" alt="THE VIEW"></a>
				<p><small><a href="http://theview.fuji-realty.asia/" target="_blank">投資物件オススメのTHE VIEW</a></small></p>
			</section>

			<section class="mb1em">
				<img src="images/toushi.jpg" width="250" height="240" alt="投資物件">
				<p><small><a href="#">カンボジアの投資物件視察ツアー</a></small></p>
			</section>

			<section class="mb1em">
				<img src="images/seminer.jpg" width="250" height="240" alt="セミナー">
				<p><small><a href="http://cambodia.fuji-realty.asia/seminar.html" target="_blank">投資セミナーの開催予定 | お申込み</a></small></p>
			</section>

			<section class="mb1em">
				<a href="http://thai.fuji-realty.asia/yokuaru.html"><img src="images/shitsumon.jpg" width="250" height="240" alt="質問"></a>
				<p><small><a href="http://thai.fuji-realty.asia/yokuaru.html">カンボジア不動産のよくあるご質問をまとめました。</a></small></p>
			</section>

			<section class="mb1em">
				<a href="http://form.os7.biz/f/dd79b177/" target="_blank"><img src="images/mail.jpg" alt="メール"></a>
				<p><small><a href="http://form.os7.biz/f/dd79b177/">メルマガ会員募集中！</a></small></p>
			</section>

			<section class="mb1em">
				<a href="https://ameblo.jp/shonankotaro/" target="_blank"><img src="./images/shonan.jpg" alt="ブログ" width="250" height="240"></a>
				<p><small><a href="http://ameblo.jp/shonankotaro/" target="_blank">カンボジア不動産、投資などの<span style="color: red;">ブログ</span><br>湘南小太郎のひとり言</a></small></p>
			</section>

			<aside>
				<h2><i class="fa fa-link" aria-hidden="true"></i> グループ運営会社サイト</h2>
				<a href="http://www.century21umi.com/" target="_blank"><img src="./images/fujiumi.jpg" width="250" height="240" alt="富士ハウジング"></a>
				<p><small><a href="http://www.century21umi.com/" target="_blank">実績多数！湘南エリアの不動産紹介はセンチュリー21富士ハウジングへ</a></small></p>
				<a href="http://thai.fuji-realty.asia/" target="_blank"><img src="./images/thai.jpg" width="250" height="240" alt="タイ法人"></a>
				<p><small><a href="http://thai.fuji-realty.asia/" target="_blank">タイ不動産ならThai Fuji Realty(Thailand)</a></small></p>
			</aside>

		</div>
		<!--/side-->
		<p id="pagetop"><a href="#">TOPへ戻る</a></p>

	</div>
	<!--/contents-->
<!-- ▲ Headerやその他コンテンツなど　※自由に編集可 ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
<footer>
	<div id="f_company">
		<div id="f_company_in">
			<div id="f_logo">
				<a href=""><img id="footer_logoimg" src="../images/footer_logo.jpg" alt="会社のロゴ" /></a>
			</div>
			<div id="f_text">
				<div id="f_text_tx">
					カンボジアの不動産なら、<br />センチュリー21 富士リアルティ カンボジアにおまかせください！
				</div>
			</div>
			<div id="f_image">
				<img src="../images/tenpo.jpg" alt="店舗外観写真" /><img src="../images/tenpo2.jpg" height="160" alt="店舗内写真" />
				<p>センチュリー21 富士リアルティ カンボジア支店は賃貸物件・売買物件・媒介物件を取り扱っています。プノンペン モニボン通り沿いに位置するオフィスです。</p>
			</div>
		</div>
	</div>
	<div id="f_wrap">
		<div id="f_innner">
			<div class="f_search">
				<ul>
					<li><a href="http://cambodia.fuji-realty.asia/">TOPページ</a></li>
					<li><a href="http://cambodia.fuji-realty.asia/?act=list&kind=1">賃貸物件を探す</a></li>
					<li><a href="http://cambodia.fuji-realty.asia/?act=list&kind=2">売買物件を探す</a></li>
					<li><a href="#">媒介物件を探す</a></li>
					<li><a href="http://cambodia.fuji-realty.asia/seminar.html">セミナー開催情報</a></li>
					<li><a href="http://cambodia.fuji-realty.asia/aboutcambodia.html">カンボジアについて</a></li>
					<li><a href="http://cambodia.fuji-realty.asia/?act=list&kind=4">本日の特選物件</a></li>
				</ul>
			</div>
			<div class="f_search">
				<div class="f_searchti">【賃貸物件を探す】</div>
				<ul>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%B5%E3%83%BC%E3%83%93%E3%82%B9%E3%82%A2%E3%83%91%E3%83%BC%E3%83%88%E3%83%A1%E3%83%B3%E3%83%88&info1=">サービスアパートメント</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%A2%E3%83%91%E3%83%BC%E3%83%88%E3%83%A1%E3%83%B3%E3%83%88&info1=">アパートメント</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%83%95%E3%83%A9%E3%83%83%E3%83%88%E3%83%8F%E3%82%A6%E3%82%B9&info1=">フラットハウス</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%B0%E3%83%A9%E3%83%B3%E3%83%89%E3%83%B4%E3%82%A3%E3%83%A9&info1=">グランドヴィラ</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=14&html=&top=0&page=&info3=%E3%83%A9%E3%83%B3%E3%83%89%28%E5%9C%9F%E5%9C%B0%29&info8=&info20=&info17=&info4=&info1=">ランド(土地)</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%AA%E3%83%95%E3%82%A3%E3%82%B9&info1=">オフィス</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%B7%E3%83%A7%E3%83%83%E3%83%97&info1=">ショップ</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%82%B3%E3%83%B3%E3%83%89%E3%83%9F%E3%83%8B%E3%82%A2%E3%83%A0&info1=">コンドミニアム</a></li>
					<li><a href="./?act=list&ord=&kind=1&limit=10&html=&top=0&page=&info3C%5B%5D=%E3%83%93%E3%83%AB%E3%83%87%E3%82%A3%E3%83%B3%E3%82%B0&info1=">ビルディング</a></li>
				</ul>
			</div>
			<div class="f_search">
				<div class="f_searchti">【売買物件を探す】</div>
				<ul>
					<li><a href="./?act=list&ord=&kind=2&limit=10&html=&top=0&page=&info3=%E3%82%B3%E3%83%B3%E3%83%89%E3%83%9F%E3%83%8B%E3%82%A2%E3%83%A0&info8=&info20=&info17=&info1=">コンドミニアム</a></li>
					<li><a href="">フラットハウス</a></li>
					<li><a href="./?act=list&ord=&kind=2&limit=10&html=&top=0&page=&info3=%E3%82%B0%E3%83%A9%E3%83%B3%E3%83%89%E3%83%B4%E3%82%A3%E3%83%A9&info8=&info20=&info17=&info1=">グランドヴィラ</a></li>
					<li><a href="">倉庫</a></li>
					<li><a href="./?act=list&kind=3">ランド(土地)</a></li>
				</ul>
			</div>
			<div class="f_search">
				<ul>
					<li><a href="./?act=list&html=company.html">会社案内</a></li>
					<li><a href="./?act=list&html=privacy.html">プライバシーポリシー</a></li>
					<li><a href="./?act=list&html=contact.html">お問い合わせ</a></li>
				</ul>
			</div>
			<div class="f_search">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3908.9338563246783!2d104.91843581422413!3d11.55659949179499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3109513c8ff51947%3A0xf48ed569e606e2e5!2sFuji+Housing!5e0!3m2!1sen!2skh!4v1515393442159"
					width="430" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
			</div>
		</div>
	</div>
	<div id="f_copyright">
		<small>Copyright&copy; 2017 <a href="./">Branch of Fuji Realty Co.,Ltd</a> All Rights Reserved.</small>
		<span class="pr"><a href="http://template-party.com/" target="_blank">Web Design:Template-Party</a></span>
	</div>
</footer>
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) {

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>完了画面</title>
</head>
<body>
<div align="center">
<?php if($empty_flag == 1){ ?>
<h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4>
<div style="color:red"><?php echo $errm; ?></div>
<br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</body>
</html>
<?php }else{ ?>
送信ありがとうございました。<br />
送信は正常に完了しました。<br /><br />
<a href="<?php echo $site_top ;?>">トップページへ戻る&raquo;</a>
</div>
<?php copyright(); ?>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-98444003-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-98444003-1');
</script>
</body>
</html>
<?php
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) {
	if($empty_flag == 1){ ?>
<div align="center"><h4>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h4><div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php
	}else{ header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	global $hankaku,$hankaku_array;
	$resArray = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');

		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }

		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		if($out != "confirm_submit" && $key != "httpReferer") {
			$resArray .= "【 ".h($key)." 】 ".h($out)."\n";
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr){
	global $hankaku,$hankaku_array;
	$html = '';
	foreach($arr as $key => $val) {
		$out = '';
		if(is_array($val)){
			foreach($val as $key02 => $item){
				//連結項目の処理
				if(is_array($item)){
					$out .= connect2val($item);
				}else{
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');

		}else{ $out = $val; }//チェックボックス（配列）追記ここまで
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);

		//全角→半角変換
		if($hankaku == 1){
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}

		$html .= "<tr><th>".$key."</th><td>".$out;
		$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
		$html .= "</td></tr>\n";
	}
	return $html;
}

//全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array){
	global $encode;
	if(is_array($hankaku_array) && function_exists('mb_convert_kana')){
		foreach($hankaku_array as $hankaku_array_val){
			if($key == $hankaku_array_val){
				$out = mb_convert_kana($out,'a',$encode);
			}
		}
	}
	return $out;
}
//配列連結の処理
function connect2val($arr){
	$out = '';
	foreach($arr as $key => $val){
		if($key === 0 || $val == ''){//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
			$key = '';
		}elseif(strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)){
			$val = number_format($val);//金額の場合には3桁ごとにカンマを追加
		}
		$out .= $val . $key;
	}
	return $out;
}

//管理者宛送信メールヘッダ
function adminHeader($userMail,$post_mail,$BccMail,$to){
	$header = '';
	if($userMail == 1 && !empty($post_mail)) {
		$header="From: $post_mail\n";
		if($BccMail != '') {
		  $header.="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$post_mail."\n";
	}else {
		if($BccMail != '') {
		  $header="Bcc: $BccMail\n";
		}
		$header.="Reply-To: ".$to."\n";
	}
		$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
		return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr,$subject,$mailFooterDsp,$mailSignature,$encode,$confirmDsp){
	$adminBody="「".$subject."」からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody.= postToMail($arr);//POSTデータを関数からセット
	$adminBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
	$adminBody.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody.="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	if($confirmDsp != 1){
		$adminBody.="問い合わせのページURL：".@$_SERVER['HTTP_REFERER']."\n";
	}else{
		$adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
	}
	if($mailFooterDsp == 1) $adminBody.= $mailSignature;
	return mb_convert_encoding($adminBody,"JIS",$encode);
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode){
	$reheader = "From: ";
	if(!empty($refrom_name)){
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != $encode){
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	}else{
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode){
	$userBody = '';
	if(isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody.= $remail_text;
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.= postToMail($arr);//POSTデータを関数からセット
	$userBody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	if($mailFooterDsp == 1) $userBody.= $mailSignature;
	return mb_convert_encoding($userBody,"JIS",$encode);
}
//必須チェック関数
function requireCheck($require){
	$res['errm'] = '';
	$res['empty_flag'] = 0;
	foreach($require as $requireVal){
		$existsFalg = '';
		foreach($_POST as $key => $val) {
			if($key == $requireVal) {

				//連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}

					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				//デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($key)."】は必須項目です。</p>\n";
					$res['empty_flag'] = 1;
				}

				$existsFalg = 1;
				break;
			}

		}
		if($existsFalg != 1){
				$res['errm'] .= "<p class=\"error_messe\">【".$requireVal."】が未選択です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}

	return $res;
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain){
	if($Referer_check == 1 && !empty($Referer_check_domain)){
		if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
			return exit('<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright(){
	echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://cambodia.fuji-realty.asia/" target="_blank">- 富士リアルティ株式会社 カンボジア支店 -</a>';
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>
