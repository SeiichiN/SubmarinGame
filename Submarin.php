<?php // Submarin.php

/**
 * Submarin -- 潜水艦ゲーム
 * @summery:
 *   49のマス目に、3個の大きさで潜水艦を配置する。
 *   マス目の番号は、
 *   横に、A B C D E F G、縦に 1 2 3 4 5 6 7 とする。
 *   そのうちの3つに潜水艦を配置する（連続）。
 *   それが潜水艦の大きさとなる。
 *   （例）[B2, B3, B4] あるいは、[C3, D3, E3]
 *   ユーザーは、何番目のマス目に潜水艦があるかを当てる。
 *   3つ当たれば「撃沈」となる。
 */
class Submarin {

    // 潜水艦の配置 -- [B2, B3, B4]
    private $locationCells = array();
    // 潜水艦の大きさ -- 要素数
    private $length = 0;
    // 命中した数 -- 3 で撃沈
    private $numOfHits = 0;
    // 潜水艦の名前
    private $name = "none";

    /**
     * setLocationCells
     * @summery: 配置を決める。
     * @param: $locs -- [2, 3, 4]などの配列
     */
    public function setLocationCells($locs) {
        /* foreach ($locs as $idx => $cell) {
         *     $cell = mb_strtolower($cell);
         *     $locs[$idx] = $cell;
         * }*/
        if (DEBUG) {echo '$locs:'; var_dump($locs); }

        $this->locationCells = array_merge($this->locationCells, $locs);
        $this->length = count($this->locationCells);
    }

    public function setName($n) {
        $this->name = $n;
    }
    public function getName() {
        return $this->name;
    }

    /**
     * デバッグ用に各潜水艦の位置を表示するメソッド
     */
    public function getLocationCells() {
        $location = implode('.', $this->locationCells);
        return $location;
    }

    /**
     * checkYourself
     * @summery: ユーザーからの攻撃に対する判定処理
     * @param: $guess -- ユーザーからの攻撃。
     *                   2 とか、3 とか。
     */
    public function checkYourself($guess) {
        $result = "失敗";

        // echo implode('.', $this->locationCells) . "\n";
        
        foreach ($this->locationCells as $idx => $cell) {
            if ($guess === $cell) {
                array_splice($this->locationCells, $idx, 1);
                $result = "命中";
                $this->numOfHits++;
                break;
            }
        }

        /* if (empty($this->locationCells)) {
         *     $result = "撃沈";
         * }*/

        if ($this->numOfHits === $this->length) {
            $result = "撃沈";
        }

        return $result;
    }
}
    
/* $sub = new Submarin();
 * $location = ["B2", "C2", "d2"];
 * $sub->setLocationCells($location);
 * $sub->setName("Papiyon");
 * $myGuess = "B3";
 * $myResult = $sub->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "d2";
 * $myResult = $sub->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "c2";
 * $myResult = $sub->checkYourself($myGuess);
 * echo $myResult, "\n";
 * $myGuess = "b2";
 * $myResult = $sub->checkYourself($myGuess);
 * echo $myResult, "\n";*/
