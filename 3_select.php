<?php
//0. SESSION開始！！
session_start();

//1.  DB接続します
include("7_funcs.php"); //DB接続

//LOGINチェック → funcs.phpへ関数化しましょう！
sschk();

//２．データ登録SQL作成
$pdo = db_conn();
$sql = "SELECT * FROM contact_test";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute(); //true or false

//３．データ表示
if($status==false) {
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード] このまま覚える
//JSONに値を渡す場合に使う
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>お問い合わせ一覧</title>
<link rel="stylesheet" href="css/select.css">
<style>
div{padding: 10px;font-size:16px;}
td {border: 1px solid black; }
</style>
</head>

<header><p>管理者ページ - お問い合わせ一覧</p></header>
<?=$_SESSION["name"]?>さん、こんにちは！
<body id="main">
<!-- Head[Start] -->

<!-- Head[End] -->


<!-- Main[Start] -->
    <table>
    <tr>
        <th>ID</th>
        <th>カテゴリ</th>
        <th>名前</th>
        <th>詳細</th>
        <th>送信日時</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
    <?php foreach($values as $v){?>
      <tr>
      <td><?=h($v["id"])?></td>
      <td><?=h($v["category"])?></td>
      <td><?=h($v["name"])?></td>
      <td><?=h($v["details"])?></td>
      <td><?=h($v["indate"])?></td>
      <td><a href="4_detail.php?id=<?=h($v["id"])?>" style="color: orange;">更新</a></td>
      <td><a href="6_delete.php?id=<?=h($v["id"])?>" style="color: orange;">削除</a></td>
    </td>
    <?php } ?>
    </table>

    <footer>
        <div class="mgmt">
            <a href="index.php">ユーザページ</a>
            <a class="navbar-brand" href="user.php">データ登録</a>
            <a class="navbar-brand" href="logout.php">ログアウト</a>
       </div>
    </footer>

<!-- Main[End] -->


<script>


</script>
</body>
</html>
