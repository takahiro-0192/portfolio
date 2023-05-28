<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>☕️ Community Cafe</title>
</head>
<body onload="document.FRM.submit()">
    <?php
        if (!empty($_POST['login_success']) && $_POST['login_success'] == '1') {
            echo "<form name='FRM' action='./index.php' method='post'>";
            echo "<input name='user_list' value='1' type='hidden'>";
            echo "<input name='chat' value='0' type='hidden'>";
            echo "<input name='address1_search' value='全国' type='hidden'>";
            echo "<input name='gender_search' value='性別' type='hidden'>";
            echo "<input name='id' value={$_POST['id']} type='hidden'>";
            echo "<input name='name' value={$_POST['name']} type='hidden'>";
            echo "<input name='gender' value={$_POST['gender']} type='hidden'>";
            echo "<input name='birth' value={$_POST['birth']} type='hidden'>";
            echo "<input name='address1' value={$_POST['address1']} type='hidden'>";
            echo "<input name='address2' value={$_POST['address2']} type='hidden'>";
            echo "<input name='email' value={$_POST['email']} type='hidden'>";
            echo "<input name='password' value={$_POST['password']} type='hidden'>";
            echo "<input name='icon' value={$_POST['icon']} type='hidden'>";

        echo "</form>";
        }
    ?>
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #D0FFD0;"></div>
    <div class="login_page_wrapper">
        <div class="login">
            <div class="title">
                <h1><span class="mark_1">☕️</span>Community Cafe<span class="mark_2">☕️</span></h1>
                <small><div>-コミュニティーカフェ-</div></small>
                <p class="logo"><br>ログイン</p>
            </div>
            <form action="./login_check.php" method="post" class="form_login">
            <div>
                <?php
                    if ((!empty($_POST['input_null_email']) && $_POST['input_null_email'] == '1') && (!empty($_POST['input_null_password']) && $_POST['input_null_password'] == '1'))
                        echo "<div class='error_message'>メールアドレスとパスワードが未入力です。</div>";
                    else if (!empty($_POST['input_null_email']) && $_POST['input_null_email'] == '1')
                        echo "<div class='error_message'>メールアドレスが未入力です。</div>";
                    else if (!empty($_POST['input_null_password']) && $_POST['input_null_password'] == '1')
                        echo "<div class='error_message'>パスワードが未入力です。</div>";
                    if (!empty($_POST['input_miss_email']) && $_POST['input_miss_email'] == '1')
                        echo "<div class='error_message'>メールアドレスが正しくありません。</div>";
                    else if (!empty($_POST['input_miss_password']) && $_POST['input_miss_password'] != '0')
                        echo "<div class='error_message'>パスワードが正しくありません。</div>";
                ?>
                <input type="hidden" name="chat" value="0">
                <input type="hidden" name="user_list" value="1">
                <input type="hidden" name="address1_search" value="全国">
                <input type="hidden" name="gender_search" value="性別">
                <input name="email" placeholder="メールアドレス"><br>
                <input name="password" type="password" placeholder="パスワード"><br>
                </form>
                <div class="smart_phone_margin">
                    <div class="input_login">
                        <form action="create_account.php" method="post">
                        <button class="btn_link">アカウント新規作成</button>
                        </form>
                        <div style='smart_phone_margin'><button class="btn" type="submit">ログイン</button></div>
                    </div>
                <div>
            </div>
        </div>
    </div>
</body>
</html>
