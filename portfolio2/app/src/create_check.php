<?php
    $error = 0;

    if (empty($_POST['email']) && empty($_POST['password']))
        $error = 1;
    else if (empty($_POST['email']) && !empty($_POST['password']))
        $error = 2;
    else if (!empty($_POST['email']) && empty($_POST['password']))
        $error = 3;
    else if (!empty($_POST['email']) && !empty($_POST['password'])) {
        if (mb_strlen($_POST['email']) <= 50 && mb_strlen($_POST['password']) >= 4 && mb_strlen($_POST['password']) <= 255 ) {
            if (filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) && preg_match("/[!-~]+$/", $_POST['password']) == 1) {
                try {
                    $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                    $sql = $pdo->prepare("SELECT * FROM accounts WHERE email = :email;");
                    $sql->execute(array(
                        ":email" => $_POST['email']
                    ));
                    $data = $sql->fetchAll(PDO::FETCH_ASSOC);

                    if (sizeof($data) == 0) {
                        $sql = $pdo->prepare("INSERT INTO accounts SET email = :email, password = :password;");
                        $sql->execute(array(
                            ":email" => $_POST['email'],
                            ":password" => password_hash($_POST['password'], PASSWORD_DEFAULT)
                        ));
                    } else
                        $error = 8;
                } catch (PDOException $e) {
                    echo 'エラー:' . $e->getMessage() . '<br>';
                }
            } else if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) && preg_match("/[!-~]+$/", $_POST['password']) != 1)
                $error = 9;
            else if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) && preg_match("/[!-~]+$/", $_POST['password']) == 1)
                $error = 10;
            else if (filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL) && preg_match("/[!-~]+$/", $_POST['password']) != 1)
                $error = 11;
        } else if (mb_strlen($_POST['email']) > 50 && mb_strlen($_POST['password']) <= 255)
            $error = 4;
        else if (mb_strlen($_POST['email']) <= 50 && mb_strlen($_POST['password']) > 255)
            $error = 5;
        else if (mb_strlen($_POST['email']) > 50 && mb_strlen($_POST['password']) > 255)
            $error = 6;
        else if (mb_strlen($_POST['email']) <= 50 && mb_strlen($_POST['password']) < 4)
            $error = 7;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>アカウント作成</title>
</head>
<body onload="document.FRM.submit();">
    <?php
        if ($error != 0) {
            echo "
                <form name='FRM' action='./create_account.php' method='post'>
                    <input name='error' type='hidden' value={$error}>
                </form>
            ";
        } else {
            echo "
                <form name='FRM' action='./login.php' method='post'>
                </form>
            ";
        }
    ?>
    <div class="position_center">
        <div class='login_form'>
            <h1>アカウント作成</h1>
            <div class='login_form_border'>
                <form class='margin-top' action='./create_check.php' method='post'>
                    <?php
                        echo "<input type='text' value='{$_POST['email']}' name='email' placeholder='メールアドレス: 50字以内'><br>";
                        echo "<input type='password' value='{$_POST['password']}' name='password' placeholder='パスワード: 半角英数字255字以内'><br>";
                    ?>
                    <button>登録</button>
                </form>
                <form class='margin-bottom' action='./login.php' method='post'>
                    <button>戻る</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>