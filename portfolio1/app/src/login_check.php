<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>☕️ Community Cafe</title>
</head>
<body onload="document.FRM.submit();">
    <?php
        $email_miss_check_count = 0;
        $password_miss_check_count = 0;
        try {
            $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
            $sql = $pdo->prepare("SELECT * FROM accounts WHERE email = :email;");
            $sql->execute(array(':email' => $_POST['email']));
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'エラー:' . $e->getMessage() . '<br>';
            die();
        }
        echo "<form name='FRM' action='./login.php' method='post'>";
        if (empty($_POST['email']) && empty($_POST['password'])) {
            echo "<input name='input_null_email' value='1' type='hidden'>";
            echo "<input name='input_null_password' value='1' type='hidden'>";
        }
        if (empty($_POST['email']))
            echo "<input name='input_null_email' value='1' type='hidden'>";
        if (empty($_POST['password']))
            echo "<input name='input_null_password' value='1' type='hidden'>";

        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $flg = 0;
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($_POST['email'] != $data[$i]['email'])
                    $email_miss_check_count++;
                if (!password_verify($_POST['password'], $data[$i]['password']))
                    $password_miss_check_count++;
            }
            if ($email_miss_check_count == sizeof($data))
                echo "<input name='input_miss_email' value='1' type='hidden'>";
            if ($password_miss_check_count != 0)
                echo "<input name='input_miss_password' value='1' type='hidden'>";
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($_POST['email'] == $data[$i]['email'] && password_verify($_POST['password'], $data[$i]['password'])) {
                    $user_login_status = 1;
                    $user_id = $data[$i]['id'];
                    $user_name = $data[$i]['name'];
                    $user_gender = $data[$i]['gender'];
                    $user_birth = $data[$i]['date_of_Birth'];
                    $user_address1 = $data[$i]['address1'];
                    $user_address2 = $data[$i]['address2'];
                    if ($data[$i]['update_image_name'] != NULL)
                        $user_icon = $data[$i]['update_image_name'];
                    else if ($user_gender == '男性')
                        $user_icon = './images/icon_man.png';
                    else
                        $user_icon = './images/icon_woman.png';
                    $flg++;
                    break;
                }
            }
            if ($flg != 0) {
                try {
                    $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                    $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE email = :email;");
                    $sql->execute(array(
                        ':login_status' => $user_login_status,
                        ':email' => $_POST['email'],
                    ));
                } catch (PDOException $e) {
                    echo 'エラー:' . $e->getMessage() . '<br>';
                    die();
                }
                echo "<input name='login_success' value='1' type='hidden'>";
                echo "<input name='id' value={$user_id} type='hidden'>";
                echo "<input name='name' value={$user_name} type='hidden'>";
                echo "<input name='gender' value={$user_gender} type='hidden'>";
                echo "<input name='birth' value={$user_birth} type='hidden'>";
                echo "<input name='address1' value={$user_address1} type='hidden'>";
                echo "<input name='address2' value={$user_address2} type='hidden'>";
                echo "<input name='email' value={$_POST['email']} type='hidden'>";
                echo "<input name='password' value={$_POST['password']} type='hidden'>";
                echo "<input name='icon' value={$user_icon} type='hidden'>";
            }
        }
        echo "</form>";
    ?>
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #D0FFD0;"></div>
    <div class="login_page_wrapper">
        <div class="login">
            <div class="title">
                <h1><span class="mark_1">☕️</span>Community Cafe<span class="mark_2">☕️</span></h1>
                <small><div>-コミュニティーカフェ-</div></small>
                <p class="logo"><br>ログイン</p>
            </div>
            <form class="form_login">
            <div>
                <input name="email" placeholder="メールアドレス"><br>
                <input name="password" type="password" placeholder="パスワード"><br>
                </form>
                <div class="input_login">
                    <form action="create_account.php">
                    <button class="btn_link">アカウント新規作成</button>
                    </form>
                    <button class="btn">ログイン</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>