<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>検索結果一覧</title>

    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>
    <div id="list" class="big-bg">

      <!-- ページヘッダー -->
      <header class="page-header wrapper">
        <!-- ロゴ画像 -->
        <h1><a href="index2.php"><img class="logo" src="hotpepper-s.gif" alt="ホットペッパーWebサービスクレジット"></a></h1>
      </header>

      <div  class="wrapper">
        <h2 class="page-title">レストラン一覧</h2>
      </div>

    </div>

    <?php
      // Hotpepper WebサービスAPIのアクセスキー
      $access_key = "57226955e387ab53";

      // APIエンドポイントのURL
      $api_endpoint = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/";

      $radius = $_REQUEST['radius'];
      $latitude = $_REQUEST['latitude'];
      $longitude = $_REQUEST['longitude'];
      $keyword = $_REQUEST['keyword'];

      // パラメータの設定
      $params = array(
        "key" => $access_key, // アクセスキー
        "lat" => 41.8327694,//$latitude,//41.8327694, // 緯度
        "lng" => 140.7603196,//$longitude,//140.7603196, // 経度
        "keyword" => $keyword,
        "range" => $radius, // 検索範囲
        "format" => "json", // レスポンス形式
      );
      
      // URLにパラメータを追加
      $api_endpoint .= "?" . http_build_query($params);

      // APIにリクエストを送信
      $response = file_get_contents($api_endpoint);

      // レスポンスをJSONから配列に変換
      $data = json_decode($response, true);
      
      // 1ページあたりの件数を指定
      $page_limit = 8;

      // 取得したレストラン情報の数をカウント
      $shop_count = count($data["results"]["shop"]);

      // ページ数を計算
      $page_count = ceil($shop_count / $page_limit);

      // 現在のページ番号を取得
      $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;

      // 現在のページ番号から、表示するレストラン情報の範囲を計算
      $start = ($current_page - 1) * $page_limit;
      $end = $start + $page_limit;
    ?>

    <div class="restaurant-list">
      <?php
        // レストラン情報を表示
        if (isset($data["results"]["shop"])) {
          // ページに表示するレストラン情報を取得
          $shops = array_slice($data["results"]["shop"], $start, $page_limit);

          foreach ($shops as $shop) {
            $image_url = $shop['photo']['pc']['m'];
            $_SESSION['restaurant_details'] = $shop["id"];
      ?>
          
            <a href="index3.php?id=<?php echo $shop["id"]; ?>" class="restaurant">
              <div class="restaurant-image">
                <img src="<?php echo $image_url; ?>" alt="<?php echo $shop["name"]; ?>">
              </div>
              <div class="restaurant-details">
                <h3 class="restaurant-name"><?php echo $shop["name"]; ?></h3>
                <p class="restaurant-address"><?php echo $shop["address"]; ?></p>
              </div>
            </a>
      <?php
          }
        }

        // ページングのリンクを表示
        if ($page_count > 1) {
      ?>
          <div class="pagination">
      <?php
            for ($i = 1; $i <= $page_count; $i++) {
              if ($i == $current_page) {
                echo "<span>{$i}</span>";
              } else {
                echo '<a href="?page=' . $i . '&latitude=' . $latitude . '&longitude=' . $longitude . '&radius=' . $radius . '&keyword=' . $keyword .'">' . $i . '</a>';
              }
            }
      ?>
          </div>
      <?php
        }
      ?>
    </div>

    <!-- ページフッター -->
    <footer>
      <div class="wrapper">
        <p><small>Powered by ホットペッパー Webサービス</small></p>
      </div>
    </footer>

  </body>
</html>

