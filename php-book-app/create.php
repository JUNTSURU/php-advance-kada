<?php
$dsn='mysql:dbname=php_book_app;host=localhost;charset=utf8mb4';
$user='root';
$password='';

if(isset($_POST['submit'])){
  try{
    $pdo = new PDO($dsn,$user,$password);

    $sql_insert='
    INSERT INTO books (book_code,book_name,price,stock_quantitiy,genre_code)
    VALUES (:book_code,:book_name,:price,:stock_quantitiy,:genre_code)';

    $stmt_insert=$pdo->prepare($sql_insert);

    $stmt_insert->bindValue(':book_code',$_POST['book_code'],PDO::PARAM_INT);
    $stmt_insert->bindValue(':book_name',$_POST['book_name'],PDO::PARAM_STR);
    $stmt_insert->bindValue(':price',$_POST['price'],PDO::PARAM_INT);
    $stmt_insert->bindValue(':stock_quantitiy',$_POST['stock_quantitiy'],PDO::PARAM_INT);
    $stmt_insert->bindValue(':genre_code',$_POST['genre_code'],PDO::PARAM_INT);

    $stmt_insert->execute();

    $count=$stmt_insert->rowCount();

    $message="商品を{$count}件登録しました。";

    header("Location:read.php?message={$message}");

  }catch(PDOException $e){
    exit($e->getMessage());
  }
}

try{
  $pdo =new PDO($dsn,$user,$password);

  $sql_select='SELECT genre_code FROM genres';

  $stmt_select=$pdo->query($sql_select);

  $genre_codes=$stmt_select->fetchAll(PDO::FETCH_COLUMN);

}catch(PDOException $e){
  exit($e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>商品登録</title>

    <!-- google fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&display=swap" rel="stylesheet">
<body>
  <!-- ヘッダー -->
<header>
  <nav>
    <a href="index.php">書籍管理アプリ</a>
  </nav>
</header>
<main>
  <article class="registration">
    <h1>商品登録</h1>
    <div class="back">
      <a href="read.php" class="btn">&lt;戻る</a>
    </div>
    <form action="create.php" method="post" class="registration-form">
      <div>
      <label for="book_code">書籍コード</label>
      <input type="number" name="book_code" min="0" max="10000" required>

      <label for="book_name">書籍名</label>
      <input type="text" name="book_name" maxlength="50" required>

      <label for="price">単価</label>
      <input type="number" name="price" min="0" max="10000" required>

      <label for="stock_quantitiy">在庫数</label>
      <input type="number" name="stock_quantitiy" min="0" max="10000" required>

      <label for="genre_code">ジャンルコード</label>
      <select name="genre_code" required>
      <option disabled selected value>選択してください。</option>

      <?php
      foreach($genre_codes as $genre_code){
        echo "<option value='{$genre_code}'>{$genre_code}</option>";
      }
      ?>
      </select>
      </div>
      <button type="submit" class="submit-btn" name="submit" value="create">登録</button>
    </form>

  </article>
</main>

<!-- フッター -->
<footer>
  <p class="copyright">&copy; 書籍管理アプリ All rights reserved.</p>
</footer>
</body>
</html>
