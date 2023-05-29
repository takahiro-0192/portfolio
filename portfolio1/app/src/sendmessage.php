<?php
    $text_error_title = NULL;
    $text_error_message = NULL;
    if (!empty($_POST['message'])) {
        if ((mb_strlen($_POST['message_title']) <= 255) && (mb_strlen($_POST['message']) <= 1000)) {
            date_default_timezone_set('Asia/Tokyo');
            try {
                $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                $sql = $pdo->prepare("INSERT INTO chat SET message_id = ?, message_title = ?, message = ?, name = ?, from_id = ?, from_name = ?, send_date = ?;");
                $sql->bindValue(1, $_POST['id_opponent'], PDO::PARAM_INT);
                $sql->bindValue(2, $_POST['message_title'], PDO::PARAM_STR);
                $sql->bindValue(3, $_POST['message'], PDO::PARAM_STR);
                $sql->bindValue(4, $_POST['name_opponent'], PDO::PARAM_STR);
                $sql->bindValue(5, $_POST['id'], PDO::PARAM_INT);
                $sql->bindValue(6, $_POST['name'], PDO::PARAM_STR);
                $sql->bindValue(7, date("Y/m/d G:i:s"), PDO::PARAM_STR);
                $sql->execute();
                $data = $sql->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'エラー:' . $e->getMessage() . '<br>';
                die();
            }
            $text = $_POST['name_opponent'] . 'さんに<br>メッセージを送信しました。';
        } else {
            $text = 'メッセージを送信できませんでした。';
            if (mb_strlen($_POST['message_title']) > 255)
                $text_error_title = '件名は255字以内で入力してください';
            if (mb_strlen($_POST['message']) > 1000)
                $text_error_message = '本文は1000字以内で入力してください';
        }
    } else
        $text = 'メッセージを送信できませんでした。<br>本文を入力してください。';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>☕ Community Cafe</title>
</head>
<body>
    <?php
        if ($_POST['gender'] == '男性')
            $class = 'bgcolor_man';
        else
            $class = 'bgcolor_woman';
    ?>
    <div class="<?php echo $class; ?> send_message_wrapper">
        <div>
            <p class="send_text"><?php echo $text;?></p>
            <?php
                if ($text_error_title != NULL)
                    echo "<p class='send_text'>{$text_error_title}</p>" ;
                if ($text_error_message != NULL)
                    echo "<p class='send_text'>{$text_error_message}</p>" ;
            ?>
            <form action="./index.php" method="post">
                <input name="id" value="<?php echo $_POST['id'] ?>" type="hidden">
                <input name="icon" value="<?php echo $_POST['icon'] ?>" type="hidden">
                <input name="name" value="<?php echo $_POST['name'] ?>" type="hidden">
                <input name="gender" value="<?php echo $_POST['gender'] ?>" type="hidden">
                <input name="birth" value="<?php echo $_POST['birth'] ?>" type="hidden">
                <input name="address1" value="<?php echo $_POST['address1'] ?>" type="hidden">
                <input name="address2" value="<?php echo $_POST['address2'] ?>" type="hidden">
                <input name="email" value="<?php echo $_POST['email'] ?>" type="hidden">
                <input name="password" value="<?php echo $_POST['password'] ?>" type="hidden">
                <input name="chat" value="0" type="hidden">
                <input name="address1_search" value="全国" type="hidden">
                <input name="gender_search" value="性別" type="hidden">
                <input name="user_list" value="1" type="hidden">
                <?php
                    if ($_POST['gender'] == '男性')
                        $class = 'send_button_back_man';
                    else
                        $class = 'send_button_back_woman';
                ?>
                <div class="send_button_position"><?php echo "<button class='{$class} btn' type='submit'>戻る</button>"; ?></div>
            </form>
        </div>
    </div>
</body>
</html>
