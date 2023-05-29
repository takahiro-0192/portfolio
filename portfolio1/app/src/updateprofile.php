<?php
    $text_none = NULL;
    $text_birth = NULL;
    $text_photo = NULL;
    $text_name = NULL;
    $text_address1 = NULL;
    $text_address2 = NULL;
    $text_introduction = NULL;
    $check_counter = [0, 0, 0];

    try {
        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');

        if ($_POST['year'] == '選択してください' || $_POST['month'] == '選択してください' || $_POST['day'] == '選択してください') {
            if (!($_POST['year'] == '選択してください' && $_POST['month'] == '選択してください' && $_POST['day'] == '選択してください'))
                $text_birth = "誕生日を変更する際は選択項目を全て選択してください。";
        } else {
            $birth = $_POST['year'] . '年' . $_POST['month'] . '月' . $_POST['day'] .'日';
            $sql = $pdo->prepare("UPDATE accounts SET date_of_Birth = ? WHERE email = ?;");
            $sql->bindValue(1, $birth, PDO::PARAM_STR);
            $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
            $sql->execute();
            $_POST['birth'] = $birth;
            $text_birth = "誕生日を更新しました。";
        }

        $uploaded_path = $_POST['icon'];
        if (!empty($_FILES['upload_image']['name'])) {
            $dirpass = "./images/{$_POST['id']}";
            $dir = glob($dirpass . '/*');
            foreach ($dir as $file)
                unlink($file);
            mkdir($dirpass, 0755, true);
            $uploaded_path = $dirpass . '/' . $_FILES['upload_image']['name'];
            $result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
            $sql = $pdo->prepare("UPDATE accounts SET update_image_name = ? WHERE email = ?;");
            $sql->bindValue(1, $uploaded_path, PDO::PARAM_STR);
            $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
            $sql->execute();
            $text_photo = "写真を更新しました。";
        }

        if (!empty($_POST['new_name'])) {
            if (mb_strlen($_POST['new_name']) <= 10) {
                $sql = $pdo->prepare("UPDATE accounts SET name = ? WHERE email = ?;");
                $sql->bindValue(1, $_POST['new_name'], PDO::PARAM_STR);
                $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
                $sql->execute();
                $_POST['name'] = $_POST['new_name'];
                $text_name = "名前を更新しました。";
            } else
                $text_name = "名前は10字以内で設定してください。";
        }

        if ($_POST['new_address1'] != '選択してください') {
            $sql = $pdo->prepare("UPDATE accounts SET address1 = ? WHERE email = ?;");
            $sql->bindValue(1, $_POST['new_address1'], PDO::PARAM_STR);
            $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
            $sql->execute();
            $_POST['address1'] = $_POST['new_address1'];
            $text_address1 = "住所１を更新しました。";
        }
        if (!empty($_POST['new_address2'])) {
            if (mb_strlen($_POST['new_address2']) <= 10) {
                $sql = $pdo->prepare("UPDATE accounts SET address2 = ? WHERE email = ?;");
                $sql->bindValue(1, $_POST['new_address2'], PDO::PARAM_STR);
                $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
                $sql->execute();
                $_POST['address2'] = $_POST['new_address2'];
                $text_address2 = "住所２を更新しました。";
            } else
                $text_address2 = "住所２は10字以内で設定してください。";
        }
        if (!empty($_POST['new_introduction'])) {
            $sql = $pdo->prepare("SELECT introduction FROM accounts WHERE email = ?;");
            $sql->bindValue(1, $_POST['email'], PDO::PARAM_STR);
            $sql->execute();
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $introduction = $data['introduction'];
            if ($_POST['new_introduction'] != $data['introduction']) {
                if (mb_strlen($_POST['introduction']) <= 255) {
                    $check_counter[2] = 1;
                    $sql = $pdo->prepare("UPDATE accounts SET introduction = ? WHERE email = ?;");
                    $sql->bindValue(1, $_POST['new_introduction'], PDO::PARAM_STR);
                    $sql->bindValue(2, $_POST['email'], PDO::PARAM_STR);
                    $sql->execute();
                    $text_introduction = "自己紹介を更新しました。";
                }
                else
                    $text_introduction = "自己紹介は255字以内で設定してください。";
            }
        }

        foreach($_POST as $Key => $Value) {
            if (empty($_POST[$Key]))
                $check_counter[0]++;
            if ($_POST[$Key] == '選択してください')
                $check_counter[1]++;
        }

        if (($check_counter[0] == 5 || $check_counter[0] == 4) && $check_counter[1] == 4 && $check_counter[2] == 0) {
            if (empty($_FILES['upload_image']['name']))
                $text_none = "変更項目がありません。";
        }
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
        die();
    }
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
            <?php
                if ($text_none != NULL)
                    echo "<p class='update_text'>{$text_none}</p>";
                if ($text_name != NULL)
                    echo "<p class='update_text'>{$text_name}</p>";
                if ($text_birth != NULL)
                    echo "<p class='update_text'>{$text_birth}</p>";
                if ($text_photo != NULL)
                    echo "<p class='update_text'>{$text_photo}</p>";
                if ($text_address1 != NULL)
                    echo "<p class='update_text'>{$text_address1}</p>";
                if ($text_address2 != NULL)
                    echo "<p class='update_text'>{$text_address2}</p>";
                if ($text_introduction != NULL)
                    echo "<p class='update_text'>{$text_introduction}</p>";
            ?>
            <form action="./editprofile.php" method="post">
                <input name="select" value="0" type="hidden">
                <input name="id" value="<?php echo $_POST['id']; ?>" type="hidden">
                <input name="icon" value="<?php echo $uploaded_path; ?>" type="hidden">
                <input name="name" value="<?php echo $_POST['name']; ?>" type="hidden">
                <input name="gender" value="<?php echo $_POST['gender']; ?>" type="hidden">
                <input name="birth" value="<?php echo $_POST['birth']; ?>" type="hidden">
                <input name="address1" value="<?php echo $_POST['address1']; ?>" type="hidden">
                <input name="address2" value="<?php echo $_POST['address2']; ?>" type="hidden">
                <input name="email" value="<?php echo $_POST['email']; ?>" type="hidden">
                <input name="password" value="<?php echo $_POST['password']; ?>" type="hidden">
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
