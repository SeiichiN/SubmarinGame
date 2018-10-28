<?php
require_once("mylib.php");
require_once("Submarin.php");
require_once("GameHelper.php");



function makeSubmarin($sub) {
    static $i = 0;
    $name = ["Papiyon", "SeaTiger", "Dragon"];
    
    // 1つめの潜水艦
    $location = GameHelper::placeSubmarin(3);
    $sub->setLocationCells($location);
    $sub->setName($name[$i]);
    $i++;
    
    // var_dump($location);
    return $sub;
}

function checkUserGuess($guess) {
    global $numOfGuess;
    global $submarinList;
    
    $numOfGuess++;

    $guess = strtoupper($guess);
    
    $result = "失敗";
    foreach ($submarinList as $idx=>$sub) {
        // echo "submarin : " . $sub->getName() . "\n";
        $result = $sub->checkYourself($guess);

        if ($result === "命中") break;
        if ($result === "撃沈") {
            $result = $sub->getName() . ":" . $result;
            array_splice($submarinList, $idx, 1);
            break;
        }
    }
    return $result;
}

function gameStart() {
    $msg = "このゲームの目的は3隻の潜水艦を撃沈することです。";
    $msg .= "潜水艦の潜む海域は、7 X 7 の 49 のマス目です。";
    $msg .= "横に A 〜 G の7つ。縦に 1 〜 7 の7つです。";
    $msg .= "各艦は、3ﾏｽの大きさをもっています。";
    $msg .= "d4 とか B3 とかいうふうにマス目を指定してください。";
    $msg .= "攻撃回数20回以下だと優秀です。では、頑張ってください。";
    return $msg;
}

function gameEnd() {
    global $numOfGuess;

    $msg = "全隻が撃沈されました。";
    $msg .= "あなたの攻撃回数は、{$numOfGuess} でした。";

    return $msg;
}

/**
 * デバッグ用に各潜水艦の位置を表示する
 */
function openLocation() {
    global $submarinList;

    foreach ($submarinList as $idx=>$sub) {
        echo $sub->getName() . " : ";
        echo $sub->getLocationCells() .  "\n";
    }
}

$submarinList = array();

// Grid（マス目）を初期化する。
GameHelper::initGrid();

$sub1 = makeSubmarin(new Submarin());
// echo "sub1:" . $sub1->getName(), "\n";
$sub2 = makeSubmarin(new Submarin());
// echo "sub2:" . $sub2->getName(), "\n";
$sub3 = makeSubmarin(new Submarin());
//echo "sub3:" . $sub3->getName(), "\n";

array_push($submarinList, $sub1);
array_push($submarinList, $sub2);
array_push($submarinList, $sub3);

// openLocation();

$numOfGuess = 0;

echo gameStart(), "\n";

while (!empty($submarinList)) {
    echo "A1 〜 G7 までのセルを指定 > ";
    $myGuess = trim(fgets(STDIN));
    $result = checkUserGuess($myGuess);
    echo $result, "\n";
}

echo gameEnd(), "\n";

/* $myGuess = "B3";
 * $myResult = $sub1->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "d2";
 * $myResult = $sub1->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "c2";
 * $myResult = $sub1->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "b2";
 * $myResult = $sub1->checkYourself($myGuess);
 * echo $myResult, "\n";*/
