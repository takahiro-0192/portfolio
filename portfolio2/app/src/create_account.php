<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>アカウント作成</title>
</head>
<body>
    <div class="position_center">
        <div class='login_form'>
            <h1>アカウント作成</h1>
            <div class='login_form_border'>
                <form class='margin-top' action='./create_check.php' method='post'>
                    <?php
                        if (!empty($_POST['error']) && $_POST['error'] == 1)
                            echo "<p>メールアドレスとパスワードが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 2)
                            echo "<p>メールアドレスが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 3)
                            echo "<p>パスワードが未入力です</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 4)
                            echo "<p>メールアドレスは50字以内入力したください</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 5)
                            echo "<p>パスワードは255字以内入力してください</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 6)
                            echo "<p>メールアドレスとパスワードが規定の字数を超えております</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 7)
                            echo "<p>パスワードは4字以上入力してください</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 8)
                            echo "<p>既に登録されています</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 9)
                            echo "<p>メールアドレス及びパスワードの入力が正しくありません</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 10)
                            echo "<p>メールアドレスの入力が正しくありません</p>";
                        if (!empty($_POST['error']) && $_POST['error'] == 11)
                            echo "<p>パスワードの入力が正しくありません</p>";
                    ?>
                    <input type='text' name='email' placeholder='メールアドレス: 50字以内'><br>
                    <input type='password' name='password' placeholder='パスワード: 半角英数字255字以内'><br>
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