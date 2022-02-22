<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гра "Екстрасенс" - Глянь у Код і Зламай Собі Мізки</title>
</head>
<body>
    <form action="index.php" method="post">
        <?php
            if (!isset ($_POST["pass"])) {
                $pass = $_POST["pass"] = rand(1,10);
            } else {
                $pass = $_POST["pass"];
            }
            if (!isset ($_POST["try"])) {
                $try = 0;
            } else {
                $try = $_POST["try"];
            }
            if (isset ($_POST["answer"])) {
                $answer = $_POST["answer"];
                $answers = json_decode($_POST["answers"]);
                $answers[] += $answer;
            } else {
                $answers = [];
            }

            echo ("<br>");
            var_dump($_POST);
            echo ("<br>");
            echo ("<p>Було загадано число від 1 до 10. Спробуйте з трьох разів відгадати це число.</p>");

            // // Простий код для блокування лише перший двох обраних варіантів:
            // echo "<select name='answer'>";
            // for ($i = 1; $i <= 10; $i++) {
            //     if ($answers[0] == $i || $answers[1] == $i) {
            //         echo ("<option value='".$i."' disabled>$i</option>");
            //     } else {
            //         echo ("<option value='".$i."'>$i</option>");
            //     }
            // }
            // echo "</select>";

            // Складний, але універсальний код, що буде блокувати будь-яку к-ть обраних варіантів:
            echo "<select name='answer'>";
            for ($i = 1; $i <= 10; $i++) {
                if ($answers) {
                    for ($j = 0; $j < count($answers); $j++) {
                        if ($answers[$j] == $i) {
                            echo ("<option value='".$i."' disabled>$i</option>");
                            break;
                        } else if ($j == (count($answers) - 1)) {
                            echo ("<option value='".$i."'>$i</option>");
                        }
                    }
                } else {
                    echo ("<option value='".$i."'>$i</option>");
                }
            }
            echo "</select>";

            // Кнопка і Виведення результатів:
            if (isset ($_POST["answer"])) {
                echo ('<button type="submit" ');
                    if ($try == 3 || $answer == $pass) {
                        echo ("disabled");
                    }
                echo ('>Обрати</button>');
                // echo ("<p>Ви обрали <b>".$answer."</b>.</p>");
                if ($answer == $pass) {
                    echo ("<p>Було загадано також <b>".$pass."</b>. Ви відгадали!</p>");
                } else if ($try < 3) {
                    foreach ($answers as $item) {
                        echo ("<p>Ви обрали <b>".$item."</b>, але це неправильна відповідь.</p>");
                    }
                    echo ("<p>Спробуйте ще раз.</p>");
                    // echo ("<p>Ви не вгадали. Спробуйте ще раз.</p>");
                } else {
                    for ($i = 0; $i < count($answers); $i++) {
                        echo ("<p>Ви обрали <b>".$answers[$i]."</b>.</p>");
                    }
                    echo ("<p>А було загадано <b>".$pass."</b>. Ви не відгадали.</p>");
                }
            } else {
                echo ('<button type="submit">Обрати</button>');
            }
            $try++;
        ?>
        <input type="hidden" name="try" value="<?=$try?>">
        <input type="hidden" name="pass" value="<?=$pass?>">
        <input type="hidden" name="answers" value="<?=json_encode($answers)?>">
    </form>

    <!-- Перезапуск гри -->
    <form action="index.php" method="post">
        <input type="hidden" name="try" value="0">
        <input type="hidden" name="answers" value="<?=json_encode([])?>">
        <p><button type="submit"<?php
            if (!isset($_POST["answer"])) {
                $answer = 0;
            }
            if ($try < 4 && $answer != $pass) {
                echo ("disabled");
            }
            ?>>Зіграти ще раз</button></p>
    </form>
</body>
</html>
