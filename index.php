<?php
//ページに文字としてプログラムを出力する用です。これないと動きません
$code = file_get_contents("index.ths");

// 実行関数
function runCode($code) {
    $chars = [
        " ", "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O",
        "P","Q","R","S","T","U","V","W","X","Y","Z",
        "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o",
        "p","q","r","s","t","u","v","w","x","y","z",
        ".", ",", "!", ":", "/", "#", "\n"
    ];

    $tape = [0];
    $ptr = 0;
    $output = "";

    for ($i = 0; $i < strlen($code); $i++) {
        $cmd = $code[$i];
        switch ($cmd) {
            case "1":
                $tape[$ptr] = max(0, $tape[$ptr] - 1);
                break;
            case "2":
                $tape[$ptr] = $tape[$ptr] + 1;
                break;
            case "3":
                $ptr = max(0, $ptr - 1);
                if (!isset($tape[$ptr])) $tape[$ptr] = 0;
                break;
            case "4":
                $ptr++;
                if (!isset($tape[$ptr])) $tape[$ptr] = 0;
                break;
            case "5":
                $val = $tape[$ptr];
                if ($val > 0 && $val <= count($chars)) {
                    $output .= $chars[$val - 1];
                } else {
                    $output .= "?";
                }
                break;
        }
    }
    return $output;
}

$result = runCode($code);

// HTMLで改行が反映されるように
echo nl2br(htmlspecialchars($result, ENT_QUOTES, 'UTF-8'));
