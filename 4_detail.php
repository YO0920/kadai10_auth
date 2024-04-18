<?php
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。

//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
session_start();
$id = $_GET["id"]; //?id~**を受け取る
include("7_funcs.php"); //DB接続
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM contact_test WHERE id=:id"; //idで接続
$stmt = $pdo->prepare($sql); //SQLセット
$stmt->bindValue(':id', $id, PDO::PARAM_INT); //idに接続、値を渡し、数値ですよ
$status = $stmt->execute(); //実行する

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$v =  $stmt->fetch(); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード] fetchAllだと全部取ってこようとしているが、1レコードだけとってきたいので1だけ返して欲しいとわかっている
// $json = json_encode($values,JSON_UNESCAPED_UNICODE); 

?>
<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="css/select.css">
  <!-- <style>div{padding: 10px;font-size:16px;}</style> -->
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="3_select.php">データ更新</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<!-- <form method="POST" action="5_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>フリーアンケート更新</legend>
     <label>カテゴリ<input type="text" name="category" value= "<?=$v["category"]?>"></label><br>
     <label>名前<input type="text" name="name" value= "<?=$v["name"]?>"></label><br>
     <label><textArea name="details" rows="4" cols="40"><?=$v["details"]?></textArea></label><br>
     <input type="hidden" name = "id" value="<?=$v["id"]?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form> -->


<div id="contact">
        <form action="5_update.php" method="post">
            <table class="contact_table" style="margin: auto;">
                <tr>
                    <td style="font-weight:bold;">カテゴリ</td>
                    <td>
                        <select name="category" id="category" value= "<?=$v["category"]?>">
                            <option value="選択してください">選択してください</option>
                            <option value="サポート体制について">サポート体制について</option>
                            <option value="アプリ月額について">アプリ月額について</option>
                            <option value="退会について">退会について</option>
                            <option value="栄養コンサルについて">栄養コンサルについて</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">名前</td>
                    <td><input type="text" name="name" value= "<?=$v["name"]?>" style="text-align: left;"></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">内容</td>
                    <td><textarea name="details" id="text" cols="30" rows="10" style="width: 500px;"><?=$v["details"]?></textarea></td>
                </tr>
                <input type="hidden" name = "id" value="<?=$v["id"]?>">
            </table>
            <button type="submit" id="send" class="btn">送信</button>
        </form>
    </div>
<!-- Main[End] -->


</body>
</html>



