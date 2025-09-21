<?php
//さすがにサイトを構成するコードとして使うときに人力で入力するのは腕の骨が複雑骨折すると思うのでサイトの内容を入力してそれをプログラムに変換し、index.php側で表示するファイルを自動生成するためのものです
// 文字表
$chars = [
    " ", "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O",
    "P","Q","R","S","T","U","V","W","X","Y","Z",
    "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o",
    "p","q","r","s","t","u","v","w","x","y","z",
    ".", ",", "!", ":", "/", "#", "\n"
];

// テキスト → プログラム変換
function encode($text, $chars) {
    $result = "";
    foreach (preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY) as $ch) {
        $pos = array_search($ch, $chars, true);
        if ($pos !== false) {
            $result .= str_repeat("2", $pos+1) . "5"; // pos+1回インクリメント → 出力
            $result .= "4"; // 次のセルに移動
        } else {
            $result .= "?"; // 未対応文字
        }
    }
    return $result;
}

$program = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST["input"] ?? "";
    $input = str_replace(["\r\n", "\r"], "\n", $input);
    $program = encode($input, $chars);
    // index.ths に保存
    file_put_contents("index.ths", $program);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>タレス変換器</title>
</head>
<body>
  <h1>タレス変換器</h1>
  <form method="post">
    <textarea name="input" rows="5" cols="60"><?= htmlspecialchars($_POST["input"] ?? "") ?></textarea><br>
    <button type="submit">変換して保存</button>
  </form>

  <?php if ($program): ?>
    <h2>変換されたプログラム</h2>
    <pre><?= htmlspecialchars($program) ?></pre>
    <p><a href="index.php" target="_blank">index.php で実行結果を見る</a></p>
  <?php endif; ?>
</body>
</html>
