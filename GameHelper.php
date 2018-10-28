<?php

require_once("mylib.php");

class GameHelper {
    const ALPHABET = "ABCDEFG";
    const GRID_LENGTH = 7;   // 海域の一行の大きさ
    const GRID_SIZE = 49;    // 海域の大きさ 7 X 7 = 49
    private static $grid = array();   // 海域を配列とする
    private static $subCount = 0;     // 潜水艦の数

    

    /**
     * コンストラクタ
     * 海域($grid)の初期化処理
     */
    public static function readGrid() {
        if (file_exists("grid.dat")) {
            self::$grid = unserialize(file_get_contents("grid.dat"));
        } else {
            echo "'grid.dat'が見当たりません\n";
        }
                
    }

    /**
     * $this->gridを初期化する
     * すべてのセルを 0 で埋める
     */
    public static function initGrid() {
        for ($i=0; $i < self::GRID_SIZE; $i++) {
            self::$grid[$i] = 0;
        }
        // grid情報をファイルに保存
        file_put_contents("grid.dat", serialize(self::$grid));
    }
    
    /**
     * @summery: 潜水艦の配置セルを提示する
     * @param: int $subSize -- 潜水艦の大きさ
     */
    public static function placeSubmarin($subSize) {
        $alphaCells = array();  // 
        $alphaCoords = array();  // "a3" などのコードを保持する
        $success = false;       // 配置が適切かどうかを表すフラグ
        $attempts = 0;          // 試行回数のカウンタ
        $location = 0;          // 検討対象のセルを示す
        $coords = array();      // 候補となる海域セル番号を保持する
        
        self::$subCount++;      // 何番目の潜水艦か
        $incr = 1;              // 配置を決めるときのセルの増加分

        self::readGrid();
        
        // 乱数で奇数の場合は縦向きにする。
        $subNum = rand(1, 30);
        if (($subNum % 2) === 1) {
            $incr = self::GRID_LENGTH;
        }

        while (!$success && $attempts++ < 200) {
            $location = rand(1, self::GRID_SIZE);
            $x = 0;             // 潜水艦の大きさ（カウント用）
            $success = true;
            // 潜水艦の大きさが $subSize以下であれば
            while ($success && $x < $subSize) {
                if (DEBUG) echo '$location:' . $location, "\n";
                if (DEBUG) echo '$grid[' . $location . '] : ' . self::$grid[$location] . "\n";
                // その海域がまだ不使用ならば
                if (self::$grid[$location] === 0) {
                    // この海域セルを候補とする
                    $coords[$x] = $location;  
                    $x++;
                    $location += $incr;  // 次の海域セル
                    // そのセルが 全海域サイズよりもおおきければ
                    if ($location >= self::GRID_SIZE) {
                        $success = false;    // 失敗
                    }
                    // そのセルが7で割り切れるということは、はみ出ている
                    if ($x > 0 && $location % self::GRID_LENGTH === 0) {
                        $success = false;
                    }
                } else {
                    $success = false;
                }
                if (DEBUG) echo '$success:' . $success . "\n";
            }

        }

        $x = 0;
        $row = 0;
        $col = 0;
        while ($x < $subSize) {
            // $coords[$x] には、0 〜 48 の数字が格納されている。
            self::$grid[$coords[$x]] = 1;    // そのセルを使用済みとする
            $row = floor($coords[$x] / self::GRID_LENGTH);   // 縦方向の番号
            $col = $coords[$x] % self::GRID_LENGTH;             // 横方向の番号
            $temp = mb_substr(self::ALPHABET, $col, 1);     // 横の番号をアルファベットにする
            if (DEBUG) echo '$row:' . $row . ' $col:' . $col . "  " . $temp, "\n";
            $alphaCells[$coords[$x]] = $temp . ($row + 1);   // "B4"などの文字を配列に保存
            if (DEBUG) echo $alphaCells[$coords[$x]], "\n";
            $alphaCoords[$x] = $alphaCells[$coords[$x]];     // 
            $x++;
        }
        // grid情報をファイルに保存
        file_put_contents("grid.dat", serialize(self::$grid));
        return $alphaCoords;
    }
}

/* GameHelper::initGrid();
 * $place1 = GameHelper::placeSubmarin(3);
 * var_dump($place1);
 * 
 * $place2 = GameHelper::placeSubmarin(3);
 * var_dump($place2);
 * 
 * $place3 = GameHelper::placeSubmarin(3);
 * var_dump($place3);
 * */
