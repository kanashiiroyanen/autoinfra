<!DOCTYPE html>
<html lang = “ja”>
<head>
<meta charset = “UFT-8”>
<link rel="stylesheet" type="text/css" href="./style.css">
<script type="text/javascript"><!--
function ChangeTab(tabname) {
   // 全部消す
   document.getElementById('tab1').style.display = 'none';
   document.getElementById('tab2').style.display = 'none';
   document.getElementById('tab3').style.display = 'none';
   // 指定箇所のみ表示
   document.getElementById(tabname).style.display = 'block';
}
// --></script>
<title>インフラ簡易構築ツール</title>
</head>
<body>
<h1>インフラ構築ツール</h1>
<div class="tabbox">
   <p class="tabs">
      <a href="#tab1" class="tab1" onclick="ChangeTab('tab1'); return false;">Windows のクローン</a>
      <a href="#tab2" class="tab2" onclick="ChangeTab('tab2'); return false;">Windows の設定</a>
      <a href="#tab3" class="tab3" onclick="ChangeTab('tab3'); return false;">サーバの設定</a>
   </p>
   <div id="tab1" class="tab">
      <p>Windows のクローンできるようにする。</p>
   </div>
   <div id="tab2" class="tab">
      <form action="./oapc.php" method="post">
      <dl>
      <dt>Windows の IP アドレス (OA端末)</dt>
      <dd><input name="ipaddr" id="ipaddr" type="text" size="50" /></dd>
      <dt>ユーザ名</dt>
      <dd><input name="user" id="usr" type="text" size="50" /></dd>
      <dt>パスワード</dt>
      <dd><input name="pass" id="pass" type="password" size="50" /></dd>
      <dt>インストールしたいソフト</dt>
      <dd><input name="soft" id="soft" type="text" size="50" /></dd>
      <dd>カンマ区切りで、複数ソフトの指定もできるよ</dd>
      <input type="submit" value="送信する" />
      </form>
   </div>
   <div id="tab3" class="tab">
      <form action="./infra.php" method="post">
      <dl>
      <dt>Docker サーバの IP アドレス (インフラ)</dt>
      <dd><input name="ipaddr" id="ipaddr" type="text" size="50" /></dd>
      <dt>ユーザ名</dt>
      <dd><input name="user" id="usr" type="text" size="50" /></dd>
      <dt>パスワード</dt>
      <dd><input name="pass" id="pass" type="password" size="50" /></dd>
      <dt></dt>
      <dt>Docker で起動したいサーバ</dt>
      <dd>
	  <input type="checkbox" name="web" value="web">Web
	  <input type="checkbox" name="dns" value="dns">DNS
	  <input type="checkbox" name="db" value="db">DB
      </dd><br>
      <input type="submit" value="送信する" />
      </form>
   </div>
</div>
<script type="text/javascript">
   ChangeTab('tab1');
</script>

<dt>性別</dt>
<dd>
<input name="gender" id="man" type="radio" value="男性" /><label for="man">男性</label><input name="gender" id="woman" type="radio" value="女性" /><label for="woman">女性</label>
</dd>
<dt>血液型</dt>
<dd>
<select name="blood" id="blood">
<option value="A型">A型</option>
<option value="B型">B型</option>
<option value="O型">O型</option>
<option value="AB型">AB型</option>
</select>
</dd>
<dt>内容</dt>
<dd><textarea name="naiyou" id="naiyou" cols="50" rows="10"></textarea></dd>
</dl>
</body>
</html>
