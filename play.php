<?php
require_once("SubmarinBust.php");

$game = new SubmarinBust();

$startMsg = $game->gameStart();

$endMsg = $game->gameEnd();

$myGuess = $_POST[cell];

if (!empty($game->getSubmarinList())) {
    $result = $game->checkUserGuess($myGuess);
}

?>

<!doctype html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>潜水艦ゲーム</title>
    </head>
    <body>
        <div id="wrap">
            <header>
                <h1>潜水艦ゲーム</h1>
            </header>
            <article>

                <table>
                    <tr>
                        <td>/</td>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                        <th>F</th>
                        <th>G</th>
                    </tr>
                    <tr>
                        <th>1</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>2</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>3</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>4</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>5</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>6</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                    <tr>
                        <th>7</th>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                        <td>.</td>
                    </tr>
                </table>
                <form action="" method="post">
                    
                    <p>A1 〜 G7 までのセルを指定 > <input type="text" name="cell"></p>
                    <p><input type="submit"></p>
                    <p> <?php echo $result; ?></p>

                </form>
            </article>
            <footer>
                <small>&copy; 2018 Seiichi Nukayama</small>
            </footer>
        </div>
    </body>
</html>


