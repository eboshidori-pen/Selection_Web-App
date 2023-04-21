<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>検索条件入力画面</title>

    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>
    <!-- ページヘッダー -->
    <header class="page-header wrapper">
      <!-- ロゴ画像 -->
      <h1><a href="index1.php"><img class="logo" src="hotpepper-s.gif" alt="ホットペッパーWebサービスクレジット"></a></h1>
    </header>
  
    <!-- 検索フォーム -->
    <div class="search-box-body">
      <div class="search">

        <form method="post" action="index2.php">
          <!-- キーワード検索 -->
          <input type="text" id="keyword" name="keyword" placeholder="キーワードで検索">

          <!-- 現在地からの半径選択 -->
          <div class="radius-select">
            <label for="radius">現在地からの半径：</label>
            <select name="radius" class="styled-select">
              <option value="1" hidden>300ｍ以内　▼</option>  
              <option value="1">300ｍ以内</option>
              <option value="2">500ｍ以内</option>
              <option value="3">1000ｍ以内</option>
              <option value="4">2000ｍ以内</option>
              <option value="5">3000ｍ以内</option>
            </select>
          </div>

          <!-- 検索ボタン -->
          <button type="submit">検索</button>

          <!-- 隠しフィールドに現在地の緯度経度を設定 -->
          <input type="hidden" id="latitude" name="latitude">
          <input type="hidden" id="longitude" name="longitude">

        </form>
      </div>
    </div>

    <script>
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        }else{
        // エラーメッセージを表示する
        alert("このブラウザではGeolocationがサポートされていません。");
        }
      }

      function setLocation(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        // 隠しフィールドに現在地の緯度経度を設定
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
      }

      //ロード時に取得する
      getLocation(); 
    </script>
  </body>
</html>

<?php
  //次のページに送るためデータを取得
  $radius = isset($_POST['radius']) ? $_POST['radius'] : "";
  $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : "";
  $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : "";
  $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
?>
