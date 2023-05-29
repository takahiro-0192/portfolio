<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>&#9749;&#65039; Community Cafe</title>
</head>
<body onload="document.FRM.submit();">
    <?php
        if (!empty($_POST['regist_success']) && $_POST['regist_success'] == '1') {
            echo "<form name='FRM' action='./login.php' method='post'>";
            echo "</form>";
        }
    ?>
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: #D0FFD0;"></div>
    <div class="create_account_page_wrapper">
        <div>
            <div class="title">
                <h1><span class="mark_1">&#9749;&#65039;</span>Community Cafe<span class="mark_2">&#9749;&#65039;</span></h1>
                <small><div>-コミュニティーカフェ-</div></small>
                <p class="logo">アカウント作成</p>
            </div>
            <form class="form_create_account" action="./create_check.php" method="post">
                <div class="form_content_margin">
                    <div>
                        <label>生年月日</label><br class="display_br">
                        <select style="<?php if (!empty($_POST['select_null_year']) && $_POST['select_null_year'] == '1') echo 'color: red;'; ?>" name="year">
                            <option>選択してください</option>
                            <?php
                                for ($i = 1960; $i <= (date("Y") - 10); $i++)
                                    echo "<option>{$i}</option>";
                            ?>
                        </select>
                        <label>年</label><br class="display_br">
                        <select style="<?php if (!empty($_POST['select_null_month']) && $_POST['select_null_month'] == '1') echo 'color: red;'; ?>" name="month">
                            <option>選択してください</option>
                            <?php
                                for ($i = 1; $i <= 12; $i++)
                                    echo "<option>{$i}</option>";
                            ?>
                        </select>
                        <label>月</label><br class="display_br">
                        <select style="<?php if (!empty($_POST['select_null_day']) && $_POST['select_null_day'] == '1') echo 'color: red;'; ?>" name="day">
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
                        <input class="input_name" name="name" placeholder="例:田中 太郎"> <?php if (!empty($_POST['over_count_name']) && $_POST['over_count_name'] == '1') echo "<br class='display_br'><span class='error_message'>10文字以内で入力してください</span>"; if (!empty($_POST['input_null_name']) && $_POST['input_null_name'] == '1') echo "<br class='display_br'><span class='error_message'>未入力です</span>"; ?><br><br>
                        <label>性別</label><br class="display_br">
                        <select <?php if (!empty($_POST['select_null_gender']) && $_POST['select_null_gender'] == '1') echo "style='color: red;'"; ?> name="gender">
                            <option>選択してください</option>
                            <option>男性</option>
                            <option>女性</option>
                        </select>
                    </div><br>
                    <div>
                        <label>メールアドレス</label><br class="display_br">
                        <input class="input_email" name="email" placeholder="例:example@gmail.com">
                            <?php
                                if (!empty($_POST['over_count_email']) && $_POST['over_count_email'] == '1')
                                    echo "<br class='display_br'><span class='error_message'>50文字以内で入力してください</span>";
                                if (!empty($_POST['input_null_email']) && $_POST['input_null_email'] == '1')
                                    echo "<br class='display_br'><span class='error_message'>未入力です</span>";
                                if (!empty($_POST['email_regist_already']) && $_POST['email_regist_already'] == '1')
                                    echo "<br class='display_br'><span class='error_message'>既に登録されております。</span>";
                                if (!empty($_POST['email_input_error']) && $_POST['email_input_error'] == '1')
                                    echo "<br class='display_br'><span class='error_message'>入力が正しくありません</span>";
                            ?>
                    </div><br>
                    <div>
                        <label>居住地</label><br class="display_br">
                        <select style="<?php if (!empty($_POST['select_null_address1']) && $_POST['select_null_address1'] == '1') echo 'color: red;'; ?>" name="address1">
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
                        <input class="input_city" name="address2" placeholder="市町村"> <?php if (!empty($_POST['over_count_address2']) && $_POST['over_count_address2'] == '1') echo "<br class='display_br'><span class='error_message'>10文字以内で入力してください</span>";  if (!empty($_POST['input_null_address2']) && $_POST['input_null_address2'] == '1') echo "<br class='display_br'><span class='error_message''>未入力です</span>"; ?><br>
                    </div><br>
                    <div>
                        <label>パスワード</label><br class="display_br">
                        <input class="input_password" name="password" type="password" placeholder="パスワード"> <?php if (!empty($_POST['over_count_password']) && $_POST['over_count_password'] == '1') echo "<br class='display_br'><span class='error_message'>255文字以内で入力してください</span>"; if (!empty($_POST['input_null_password']) && $_POST['input_null_password'] == '1') echo "<br class='display_br'><span class='error_message'>未入力です</span>"; if (!empty($_POST['password_is_short']) && $_POST['password_is_short'] == 1) echo "<br class='display_br'><span class='error_message'>４文字以上入力してください</span>"; if (!empty($_POST['password_retype_miss']) && $_POST['password_retype_miss'] == 1) echo "<br class='display_br'><span class='error_message'>パスワードが確認用と一致しておりません</span>"; ?><br><br>
                        <label>パスワード(再入力)</label><br class="display_br">
                        <input class="input_password" name="password_retype" type="password" placeholder="パスワード（再入力）"> <?php if (!empty($_POST['over_count_password_retype']) && $_POST['over_count_password_retype'] == '1') echo "<br class='display_br'><span class='error_message'>255文字以内で入力してください</span>"; if (!empty($_POST['input_null_password_retype']) && $_POST['input_null_password_retype'] == '1') echo "<br class='display_br'><span class='error_message'>未入力です</span>"; ?><br>
                    </div>
                    <div class='flex'>
                        </form>
                        <form action="./login.php" method="post">
                            <div class="regist_button btn_margin_left"><button class="return btn" type="submit">戻る</button></div>
                        </form>
                        <div class="regist_button btn_margin_right"><button class="btn" type="submit">登録</button></div>
                    </div>
                </div>
        </div>
    </div>
</body>
</html>