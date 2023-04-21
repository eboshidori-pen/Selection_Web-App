<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>店舗詳細</title>

    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link href="https://fonts.googleapis.com/css?family=Philosopher" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>
    <div id="detail" class="big-bg">

      <!-- ページヘッダー -->
      <header class="page-header wrapper">
        <!-- ロゴ画像 -->
        <h1><a href="index3.php"><img class="logo" src="hotpepper-s.gif" alt="ホットペッパーWebサービスクレジット"></a></h1>
      </header>

      <div class="wrapper">
        <h3 class="page-title">レストラン詳細</h3>
      </div>
    </div>

    <?php
      // Hotpepper WebサービスAPIのアクセスキー
      $access_key = "57226955e387ab53";

      // APIエンドポイントのURL
      $api_endpoint = "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/";

      if (isset($_GET['id'])) {
        $id = $_GET['id'];
      }

      // パラメータの設定
      $params = array(
        "key" => $access_key,
        // アクセスキー
        "id" => $id,
        // 検索キーワード
        "format" => "json", // レスポンス形式
      );

      // URLにパラメータを追加
      $api_endpoint .= "?" . http_build_query($params);

      // APIにリクエストを送信
      $response = file_get_contents($api_endpoint);

      // レスポンスをJSONから配列に変換
      $data = json_decode($response, true);

      // レストラン情報を変数に取得
      if (isset($data["results"]["shop"][0])) {
        $shop = $data["results"]["shop"][0];
        $image_detail_url = $shop['photo']['pc']['l'];
        $shop_detail_url = $shop["urls"]["pc"];
        $shop_detail_title = $shop["name"];
        $shop_detail_address = $shop["address"];
      } else {
        echo "レストランが見つかりませんでした。";
      }
    ?>

    <header class="shop-info">
      <!-- レストラン名表示 -->
      <h2 class="shop-title wrapper">
        <?php echo $shop["name"]; ?>
      </h2>

      <!-- お店ジャンル表示 -->
      <p class="wrapper">お店ジャンル:
        <?php echo $shop["genre"]["name"]; ?>
      <p>
    </header>

    <!-- お店画像表示 -->
    <div class="wrapper">
      <img class="shop-detail-image" src="<?php echo $image_detail_url; ?>">
    </div>

    <!-- お店キャッチ表示 -->
    <p class="wrapper">
      <?php echo $shop["catch"]; ?>
    </p>

    <!-- 基本情報表示 -->
    <h3 class="wrapper shop-detail-text sub-title">基本情報</h3>
    <p class="wrapper">住所：
      <?php echo $shop["address"]; ?>
    </p>
    <p class="wrapper">営業時間：
      <?php echo $shop["open"]; ?>
    </p>
    <p class="wrapper">定休日：
      <?php echo $shop["close"]; ?>
    </p>
    <p class="wrapper">平均予算：
      <?php echo $shop["budget"]["average"]; ?>
    </p>
    <p class="wrapper">店舗URL： <a href=" <?php echo $shop_detail_url; ?>"><?php echo $shop_detail_url; ?></a></p>;

    <!-- マップ表示 -->
    <section id="location">
      <div class="wrapper">
        <div class="location-info">
          <h3 class="sub-title">マップ</h3>
          <p>アクセス：
            <?php echo $shop["access"]; ?>
          </p>
          <p>最寄り駅：
            <?php echo $shop["station_name"]; ?>
          </p>
          <p>住所：
            <?php echo $shop["address"]; ?>
          </p>
        </div>
        <div class="location-map">
          <iframe
            src="https://www.google.com/maps/?output=embed&q=<?php echo urlencode($shop_detail_title . ' ' . $shop_detail_address); ?>&t=m&z=15"
            width="700" height="400">
          </iframe>
        </div>
      </div>
    </section>


    <h3 class="sub-title">詳細情報</h3>

    <!-- 詳細情報の表を表示 -->
    <table border="1" class="wrapper">
      <tr>
        <td>最大宴会収容人数</td>
        <td>
          <?php echo $shop["party_capacity"]; ?>
        </td>
      </tr>
      <tr>
        <td>WiFi 有無</td>
        <td>
          <?php echo $shop["wifi"]; ?>
        </td>
      </tr>
      <tr>
        <td>ウェディング･二次会</td>
        <td>
          <?php echo $shop["wedding"]; ?>
        </td>
      </tr>
      <tr>
        <td>コース</td>
        <td>
          <?php echo $shop["course"]; ?>
        </td>
      </tr>
      <tr>
        <td>飲み放題</td>
        <td>
          <?php echo $shop["free_drink"]; ?>
        </td>
      </tr>
      <tr>
        <td>食べ放題</td>
        <td>
          <?php echo $shop["free_food"]; ?>
        </td>
      </tr>
      <tr>
        <td>個室</td>
        <td>
          <?php echo $shop["private_room"]; ?>
        </td>
      </tr>
      <tr>
        <td>座敷</td>
        <td>
          <?php echo $shop["tatami"]; ?>
        </td>
      </tr>
      <tr>
        <td>カード可</td>
        <td>
          <?php echo $shop["card"]; ?>
        </td>
      </tr>
      <tr>
        <td>禁煙席</td>
        <td>
          <?php echo $shop["non_smoking"]; ?>
        </td>
      </tr>
      <tr>
        <td>貸切可</td>
        <td>
          <?php echo $shop["charter"]; ?>
        </td>
      </tr>
      <tr>
        <td>駐車場</td>
        <td>
          <?php echo $shop["parking"]; ?>
        </td>
      </tr>
      <tr>
        <td>バリアフリー</td>
        <td>
          <?php echo $shop["barrier_free"]; ?>
        </td>
      </tr>
      <tr>
        <td>その他設備</td>
        <td>
          <?php echo $shop["other_memo"]; ?>
        </td>
      </tr>
      <tr>
        <td>ライブ・ショー</td>
        <td>
          <?php echo $shop["show"]; ?>
        </td>
      </tr>
      <tr>
        <td>カラオケ</td>
        <td>
          <?php echo $shop["karaoke"]; ?>
        </td>
      </tr>
      <tr>
        <td>バンド演奏可</td>
        <td>
          <?php echo $shop["band"]; ?>
        </td>
      </tr>
      <tr>
        <td>TV・プロジェクター</td>
        <td>
          <?php echo $shop["tv"]; ?>
        </td>
      </tr>
      <tr>
        <td>英語メニュー</td>
        <td>
          <?php echo $shop["english"]; ?>
        </td>
      </tr>
      <tr>
        <td>ペット可</td>
        <td>
          <?php echo $shop["pet"]; ?>
        </td>
      </tr>
      <tr>
        <td>お子様連れ</td>
        <td>
          <?php echo $shop["child"]; ?>
        </td>
      </tr>
      <tr>
        <td>ランチ</td>
        <td>
          <?php echo $shop["lunch"]; ?>
        </td>
      </tr>
      <tr>
        <td>23時以降も営業</td>
        <td>
          <?php echo $shop["midnight"]; ?>
        </td>
      </tr>
      <tr>
        <td>備考</td>
        <td>
          <?php echo $shop["shop_detail_memo"]; ?>
        </td>
      </tr>
    </table>

    <!-- ページフッター -->
    <footer>
      <div class="wrapper">
        <p><small>Powered by ホットペッパー Webサービス</small></p>
      </div>
    </footer>

    </body>
</html>
