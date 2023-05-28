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
    <form name="FRM" action="./create_account.php" method="post">
        <?php
            $text = '';
            $check_counter = [0,0,0];
            foreach ($_POST as $Key => $Value) {
                if (empty($_POST[$Key]))
                    $check_counter[0]++;
                if (($_POST[$Key] == '選択してください'))
                    $check_counter[1]++;
            }

            if ($check_counter[0] == 0 && $check_counter[1] == 0) {
                if ((mb_strlen($_POST['name']) <= 10) && (mb_strlen($_POST['email']) <= 50) && (mb_strlen($_POST['address2']) <= 10) && (mb_strlen($_POST['password']) <= 255) && (mb_strlen($_POST['password_retype']) <= 255)) {
                    if (strlen($_POST['password']) >= 4 && filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)) {
                        try {
                            $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                            $sql = $pdo->prepare("SELECT email FROM accounts");
                            $sql->execute();
                            $db_recode_count = $sql->rowCount();
                            $data = $sql->fetchAll(PDO::FETCH_ASSOC);
                            for ($i = 0; $i < $db_recode_count; $i++) {
                                if ($_POST['email'] == $data[$i]['email'])
                                    $check_counter[2]++;
                            }
                            if ($check_counter[2] == 0) {
                                if (($_POST['password'] == $_POST['password_retype'])) {
                                    $birth = $_POST['year'] . '年' . $_POST['month'] . '月' . $_POST['day']. '日';
                                    $sql = $pdo->prepare("INSERT INTO accounts SET date_of_Birth = ?, name = ?, gender = ?, email = ?, password = ?, address1 = ?, address2 = ?, introduction = ?");
                                    $sql->bindValue(1, $birth, PDO::PARAM_STR);
                                    $sql->bindValue(2, $_POST['name'], PDO::PARAM_STR);
                                    $sql->bindValue(3, $_POST['gender'], PDO::PARAM_STR);
                                    $sql->bindValue(4, $_POST['email'], PDO::PARAM_STR);
                                    $sql->bindValue(5, password_hash($_POST['password'], PASSWORD_DEFAULT), PDO::PARAM_STR);
                                    $sql->bindValue(6, $_POST['address1'], PDO::PARAM_STR);
                                    $sql->bindValue(7, $_POST['address2'], PDO::PARAM_STR);
                                    $sql->bindValue(8, 'よろしくお願いします。', PDO::PARAM_STR);
                                    $sql->execute();
                                    echo "<input name='regist_success' value='1' type='hidden'>";
                                } else
                                echo "<input name='password_retype_miss' value='1' type='hidden'>";
                            } else
                            echo "<input name='email_regist_already' value='1' type='hidden'>";
                        } catch (PDOException $e) {
                            echo 'エラー:' . $e->getMessage() . '<br>';
                            die();
                        }
                    } else if (strlen($_POST['password']) < 4)
                        echo "<input name='password_is_short' value='1' type='hidden'>";
                    else if (!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL))
                        echo "<input name='email_input_error' value='1' type='hidden'>";
                } else {
                    if (mb_strlen($_POST['name']) > 10)
                        echo "<input name='over_count_name' value='1' type='hidden'>";
                    if (mb_strlen($_POST['email']) > 30)
                        echo "<input name='over_count_email' value='1' type='hidden'>";
                    if (mb_strlen($_POST['address2']) > 10)
                        echo "<input name='over_count_address2' value='1' type='hidden'>";
                    if (mb_strlen($_POST['password']) > 255)
                        echo "<input name='over_count_password' value='1' type='hidden'>";
                    if (mb_strlen($_POST['password_retype']) > 255)
                        echo "<input name='over_count_password_retype' value='1' type='hidden'>";
                }
            } else {
                if (empty($_POST['name']))
                    echo "<input name='input_null_name' value='1' type='hidden'>";
                if (empty($_POST['email']))
                    echo "<input name='input_null_email' value='1' type='hidden'>";
                if (empty($_POST['address2']))
                    echo "<input name='input_null_address2' value='1' type='hidden'>";
                if (empty($_POST['password']))
                    echo "<input name='input_null_password' value='1' type='hidden'>";
                if (empty($_POST['password_retype']))
                    echo "<input name='input_null_password_retype' value='1' type='hidden'>";

                if ($_POST['year'] == '選択してください')
                    echo "<input name='select_null_year' value='1' type='hidden'>";
                if ($_POST['month'] == '選択してください')
                    echo "<input name='select_null_month' value='1' type='hidden'>";
                if ($_POST['day'] == '選択してください')
                    echo "<input name='select_null_day' value='1' type='hidden'>";
                if ($_POST['gender'] == '選択してください')
                    echo "<input name='select_null_gender' value='1' type='hidden'>";
                if ($_POST['address1'] == '選択してください')
                    echo "<input name='select_null_address1' value='1' type='hidden'>";
            }
        ?>
    </form>
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #D0FFD0;"></div>
    <div class="create_account_page_wrapper">
        <div>
            <div class="title">
                <h1><span class="mark_1">☕️</span>Community Cafe<span class="mark_2">☕️</span></h1>
                <small><div>-コミュニティーカフェ-</div></small>
                <p class="logo">アカウント作成</p>
            </div>
            <form class="form_create_account">
                <div class="form_content_margin">
                    <div>
                        <label>生年月日</label><br class="display_br">
                        <select name="year">
                            <option>選択してください</option>
                            <?php
                                for ($i = 1960; $i <= 2023; $i++)
                                    echo "<option>{$i}</option>";
                            ?>
                        </select>
                        <label>年</label><br class="display_br">
                        <select name="month">
                            <option>選択してください</option>
                            <?php
                                for ($i = 1; $i <= 12; $i++)
                                    echo "<option>{$i}</option>";
                            ?>
                        </select>
                        <label>月</label><br class="display_br">
                        <select name="day">
                            <option>選択してください</option>
                            <?php
                                for ($i = 1; $i <= 31; $i++)
                                    echo "<option>{$i}</option>";
                            ?>
                        </select>
                        <label>日</label>
                    </div><br>
                    <div>
                        <label>名前 </label><br class="display_br">
                        <input class="input_name" name="name" placeholder="例:田中 太郎"><br><br>
                        <label>性別</label><br class="display_br">
                        <select name="gender">
                            <option>選択してください</option>
                            <option>男性</option>
                            <option>女性</option>
                        </select>
                    </div><br>
                    <div>
                        <label>メールアドレス</label><br class="display_br">
                        <input class="input_email" name="email" placeholder="例:example@gmail.com">
                    </div><br>
                    <div>
                        <label>居住地</label><br class="display_br">
                        <select name="address1">
                            <option>選択してください</option>
                            <?php
                                $address1 = [
                                    '北海道',  '青森県', '秋田県', '岩手県', '山形県', '宮城県', '福島県',   #北海道・東北
                                    '栃木県', '群馬県', '茨城県', '埼玉県', '東京都', '神奈川県', '千葉県', '山梨県', '新潟県', '長野県', #関東・甲信越
                                    '愛知県', '岐阜県', '静岡県', '三重県', '富山県', '石川県', '福井県',   #東海・北陸
                                    '大阪府', '兵庫県', '京都府', '滋賀県', '奈良県', '和歌山県', '高知県', '香川県', '徳島県', '愛媛県',  #近畿・四国
                                    '広島県', '岡山県', '山口県', '島根県', '鳥取県',   #中国
                                    '佐賀県', '福岡県', '大分県', '熊本県', '宮崎県', '長崎県', '鹿児島県', '沖縄県'    #九州・沖縄
                                ];
                                $Index = 0;
                                foreach ($address1 as $address)
                                    echo "<option>{$address1[$Index++]}</option>";
                            ?>
                        </select><br class="display_br">
                        <input class="input_city" name="address2" placeholder="市町村"><br>
                    </div><br>
                    <div>
                        <label>パスワード</label><br class="display_br">
                        <input class="input_password" name="password" type="password" placeholder="パスワード"><br><br>
                        <label>パスワード(再入力)</label><br class="display_br">
                        <input class="input_password" name="password_retype" type="password" placeholder="パスワード（再入力）"><br>
                    </div>
                    <div class="flex">
                        </form>
                        <form action="./login.php" method="post">
                            <div class="regist_button btn_margin_left"><button class="btn" type="submit">戻る</button></div>
                        </form>
                        <div class="regist_button btn_margin_right"><button class="btn" type="submit">登録</button></div>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>
