<?php
    $error = 0;
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        try {
            $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

            $sql = $pdo->prepare("SELECT * FROM accounts WHERE email = :email;");
            $sql->execute(array(
                ":email" => $_POST['email']
            ));
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($data) == 0)
                $error = 4;
            else if (!password_verify($_POST['password'], $data[0]['password']))
                $error = 5;
            else {
                $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE email = :email;");
                $sql->execute(array(
                    ":login_status" => 1,
                    ":email" => $_POST['email']
                ));
                $id = $data[0]['id'];
                if ($data[0]['id_name'] != NULL)
                    $id_name = $data[0]['id_name'];
                else
                    $id_name = '未設定';
                $email = $_POST['email'];
                if ($data[0]['tel'] != NULL)
                    $tel = $data[0]['tel'];
                else
                    $tel = '未設定';
            }
        } catch (PDOException $e) {
            echo "エラー:" . $e->getMessage() . "<br>";
        }
    }else if (empty($_POST['email']) && empty($_POST['password']))
        $error = 1;
    else if (empty($_POST['email']) && !empty($_POST['password']))
        $error = 2;
    else if (!empty($_POST['email']) && empty($_POST['password']))
        $error = 3;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>ログイン</title>
</head>
<body onload="document.FRM.submit();">
    <?php
        if ($error != 0) {
            echo "
                <form name='FRM' action='./login.php' method='post'>
                    <input name='error' type='hidden' value={$error}>
                </form>
            ";
        } else {
            echo "
                <form name='FRM' action='./index.php' method='post'>
                    <input name='mode' value=0 type='hidden'>
                    <input name='chat_mode' value=0 type='hidden'>
                    <input name='chat_room_page' value=1 type='hidden'>
                    <input name='id' value={$id} type='hidden'>
                    <input name='id_name' value={$id_name} type='hidden'>
                    <input name='email' value={$email} type='hidden'>
                    <input name='tel' value={$tel} type='hidden'>
                    <input name='login' value=1 type='hidden'>
                </form>
            ";
        }
    ?>
    <div class="position_center">
        <div class='login_form'>
            <h1>ログイン</h1>
            <div class='login_form_border'>
                <form class='margin-top' action='./login_check.php' method='post'>
                    <?php
                        echo "<input type='text' value='{$_POST['email']}' name='email' placeholder='メールアドレス'><br>";
                        echo "<input type='password' value='{$_POST['password']}' name='password' placeholder='パスワード'><br>";
                    ?>
                    <button>ログイン</button>
                </form>
                <form class='margin-bottom' action='./create_account.php' method='post'>
                    <button>アカウント作成</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>