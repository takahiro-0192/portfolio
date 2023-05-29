<?php
    $flg = false;
    $check_counter = 0;
    foreach($_POST as $Key => $Value) {
        if (empty($_POST[$Key]))
            $check_counter++;
    }
    if ($check_counter != 2)
        $text = "未入力項目があります。";
    else {
        if ($_POST['password'] != $_POST['now_password'])
            $text = "現在のパスワードが正しくありません。";
        else if (strlen($_POST['new_password']) >= 4) {
            if (mb_strlen($_POST['new_password']) <= 255) {
                if ($_POST['new_password'] != $_POST['retype_password'])
                    $text = "新しいパスワードが確認用と違います。";
                else if ($_POST['now_password'] == $_POST['new_password'])
                    $text = "現在と同じパスワードを設定できません。";
                else {
                    try {
                        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                        $sql = $pdo->prepare("UPDATE accounts SET password = ? WHERE email = ?;");
                        $sql->bindValue(1, password_hash($_POST['new_password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
                        $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
                        $sql->execute();
                        $text = "パスワードを変更しました。";
                        $flg = true;
                    } catch (PDOException $e) {
                        echo 'エラー:' . $e->getMessage() . '<br>';
                        die();
                    }
                }
            } else
                $text =  "パスワードは255字以内で設定してください。";
        } else
            $text =  "パスワードは4文字以上で設定してください。";
    }

    if ($flg == false)
        $password = $_POST['password'];
    else
        $password = $_POST['new_password'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>☕️ Community Cafe</title>
</head>
<body>
    <?php
        if ($_POST['gender'] == '男性')
            $class = 'bgcolor_man';
        else
            $class = 'bgcolor_woman';
    ?>
    <div class="wrapper content_center <?php echo $class; ?>">
        <div>
            <p class="update_text"><?php echo $text;?></p>
            <form action="./index.php" method="post">
                <input name="select" value="0" type="hidden">
                <input name="user_list" value="1" type="hidden">
                <input name="icon" value="<?php echo $_POST['icon'] ?>" type="hidden">
                <input name="id" value="<?php echo $_POST['id'] ?>" type="hidden">
                <input name="name" value="<?php echo $_POST['name'] ?>" type="hidden">
                <input name="birth" value="<?php echo $_POST['birth'] ?>" type="hidden">
                <input name="address1" value="<?php echo $_POST['address1'] ?>" type="hidden">
                <input name="address2" value="<?php echo $_POST['address2'] ?>" type="hidden">
                <input name="email" value="<?php echo $_POST['email'] ?>" type="hidden">
                <input name="gender" value="<?php echo $_POST['gender'] ?>" type="hidden">
                <input name="password" value="<?php echo $password ?>" type="hidden">
                <input name="chat" value="0" type="hidden">
                <input name="address1_search" value="全国" type="hidden">
                <input name="gender_search" value="性別" type="hidden">
                <?php
                    if ($_POST['gender'] == '男性')
                        $class = 'button_back_man';
                    else
                        $class = 'button_back_woman';
                ?>
                <div class="button_position"><?php echo "<button class='{$class} btn' type='submit'>戻る</button>"; ?></div>
            </form>
        </div>
    </div>
</body>
</html>
