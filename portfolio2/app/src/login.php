<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>ログイン</title>
</head>
<body>
    <div class="position_center">
        <div class='login_form'>
            <h1>ログイン</h1>
            <div class='login_form_border'>
                <form class='margin-top' action='./login_check.php' method='post'>
                    <?php
                        if (!empty($_POST['error']) && $_POST['error'] == 1)
                            echo "<p>メールアドレスとパスワードが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 2)
                            echo "<p>メールアドレスが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 3)
                            echo "<p>パスワードが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 4)
                            echo "<p>メールアドレスが存在しません</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 5)
                            echo "<p>パスワードが正しくありません</p>";
                    ?>
                    <input type='text' name='email' placeholder='メールアドレス'><br>
                    <input type='password' name='password' placeholder='パスワード'><br>
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