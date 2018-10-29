<?php
require_once("mylib.php");
require_once("Submarin.php");
require_once("GameHelper.php");

class SubmarinBust {

    private $submarinList = array();
    private $subNum = 0;
    private $numOfGuess = 0;

    public function __construct() {
        // Grid（マス目）を初期化する。
        GameHelper::initGrid();

        $sub1 = $this->makeSubmarin(new Submarin());
        echo "sub1:" . $sub1->getName(), "\n";
        $sub2 = $this->makeSubmarin(new Submarin());
        echo "sub2:" . $sub2->getName(), "\n";
        $sub3 = $this->makeSubmarin(new Submarin());
        echo "sub3:" . $sub3->getName(), "\n";

        array_push($this->submarinList, $sub1);
        array_push($this->submarinList, $sub2);
        array_push($this->submarinList, $sub3);
    }

    public function getSubmarinList() {
        return $this->submarinList;
    }

    public function getNumOfGuess() {
        return $this->numOfGuess;
    }
    
    public function makeSubmarin($sub) {
        $name = ["Papiyon", "SeaTiger", "Dragon"];
        
        // 1つめの潜水艦
        $location = GameHelper::placeSubmarin(3);
        $sub->setLocationCells($location);
        $sub->setName($name[$this->subNum]);
        $this->subNum++;
        
        // var_dump($location);
        return $sub;
    }
    
    public function checkUserGuess($guess) {
        
        $this->numOfGuess++;

        $guess = strtoupper($guess);
        
        $result = "失敗";
        foreach ($this->submarinList as $idx=>$sub) {
            // echo "submarin : " . $sub->getName() . "\n";
            $result = $sub->checkYourself($guess);

            if ($result === "命中") break;
            if ($result === "撃沈") {
                $result = $sub->getName() . ":" . $result;
                array_splice($this->submarinList, $idx, 1);
                break;
            }
        }
        return $result;
    }

    public function gameStart() {
        $msg = "このゲームの目的は3隻の潜水艦を撃沈することです。";
        $msg .= "潜水艦の潜む海域は、7 X 7 の 49 のマス目です。";
        $msg .= "横に A 〜 G の7つ。縦に 1 〜 7 の7つです。";
        $msg .= "各艦は、3ﾏｽの大きさをもっています。";
        $msg .= "d4 とか B3 とかいうふうにマス目を指定してください。";
        $msg .= "攻撃回数20回以下だと優秀です。では、頑張ってください。";
        return $msg;
    }

    public function gameEnd() {
        $i = $this->numOfGuess;

        $msg = "全隻が撃沈されました。";
        $msg .= "あなたの攻撃回数は、$i でした。";

        return $msg;
    }

    /**
     * デバッグ用に各潜水艦の位置を表示する
     */
    public function openLocation() {
        global $submarinList;

        foreach ($submarinList as $idx=>$sub) {
            echo $sub->getName() . " : ";
            echo $sub->getLocationCells() .  "\n";
        }
    }

}


/* $game = new SubmarinBust();
 * 
 * echo $game->gameStart(), "\n";
 * 
 * while (!empty($game->getSubmarinList())) {
 *     echo "A1 〜 G7 までのセルを指定 > ";
 *     $myGuess = trim(fgets(STDIN));
 *     $result = $game->checkUserGuess($myGuess);
 *     echo $result, "\n";
 * }
 * 
 * echo $game->gameEnd(), "\n";*/

