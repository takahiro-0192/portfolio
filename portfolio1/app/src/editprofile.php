<?php
    $id = $_POST['id'];
    $icon = $_POST['icon'];
    $birth = $_POST['birth'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $select = $_POST['select'];
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
    <?php if ($gender == '男性') $class = 'bgcolor_man'; else $class = 'bgcolor_woman';  echo "<div class=\"{$class}\">"; ?></div>
    <div class="edit_main_wrapper">
        <div class="edit_main_content_position">
            <div class="edit_select_button_wrapper">
                <?php
                    if ($select == 0) {
                        echo "<div>";
                        echo "<form action='./editprofile.php' method='post'>";
                        echo "<input name='select' value='1' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性') {
                            $book = '📘';
                            $class = 'edit_select_button_1_man';
                        } else {
                            $book = '📕';
                            $class = 'edit_select_button_1_woman';
                        }
                        echo "<button class='{$class}' type='submit'><b><p>{$book} 登録情報変更</p></b>";
                        echo "<span>写真、誕生日、名前、居住地情報が変更できます。<br>※メールアドレスは変更できません。</span>";
                        echo "</button>";
                        echo "</form>";
                        echo "<form action='./editprofile.php' method='post'>";
                        echo "<input name='select' value='2' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'edit_select_button_2_man';
                        else
                            $class = 'edit_select_button_2_woman';
                        echo "<button class='{$class}' type='submit'><b><p>🔑 パスワード変更</p></b></button>";
                        echo "</form>";
                        echo "<div>";
                        echo "</div>";
                        echo "<form class='button_back_margin' action='./index.php' method='post'>";
                        echo "<input name='user_list' value='1' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'button_back_style_man';
                        else
                            $class = 'button_back_style_woman';
                        echo "<button class='{$class}'><b>戻る</b></button>";
                        echo "</form>";
                    } else if ($select == 1) {
                        try {
                            $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                            $sql = $pdo->prepare("SELECT * FROM accounts WHERE email = :email;");
                            $sql->execute(array(':email' => $email));
                            $data = $sql->fetch(PDO::FETCH_ASSOC);
                        } catch (PDOException $e) {
                            echo 'エラー:' . $e->getMessage() . '<br>';
                            die();
                        }
                        if ($gender == '男性') {
                            $color = 'blue';
                        } else {
                            $color = 'red';
                        }
                        echo "<form enctype='multipart/form-data' class='edit_select_1_form' action='./updateprofile.php' method='post'>";
                        echo "<div class='edit_select_1_form_content_wrapper'>";
                        echo "<div>";
                        echo "<div class='profile_image_wrapper'>";
                        echo "<img src='{$icon}' class='profile_image'><br>";
                        echo "<input name='upload_image' class='input_upload_image' type='file'><br>";
                        echo "</div>";
                        echo "<div class='edit_select_1_form_1_content_center'>";
                        echo "<label class='profile_font_size'>誕生日</label><br class='display_br'>";
                        echo "<select class='profile_font_size' name='year'>";
                        echo "<option>選択してください</option>";
                        for ($i = 1960; $i <= (date("Y") - 10); $i++)
                            echo "<option>{$i}</option>";
                        echo "</select><span class='profile_font_size'> 年 </span><br class='display_br'>";
                        echo "<select class='profile_font_size' name='month'>";
                        echo "<option>選択してください</option>";
                        for ($i = 1; $i <= 12; $i++)
                            echo "<option>{$i}</option>";
                        echo "</select><span class='profile_font_size'> 月 </span><br class='display_br'>";
                        echo "<select class='profile_font_size' name='day'>";
                        echo "<option>選択してください</option>";
                        for ($i = 1; $i <= 31; $i++)
                            echo "<option>{$i}</option>";
                        echo "</select><span class='profile_font_size'> 日</span><br>";
                        echo "<div class='edit_input_name_margin'>";
                        echo "<label class='profile_font_size'>名前</label><br class='display_br'>";
                        echo "<input class='profile_font_size' name='new_name' type='text' placeholder='例:田中 太郎'><br>";
                        echo "</div>";
                        echo "<div class='edit_input_address_margin'>";
                        echo "<label class='profile_font_size'>居住地</label><br class='display_br'>";
                        echo "<select class='profile_font_size' name='new_address1'>";
                        echo "<option>選択してください</option>";
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
                        echo "</select><br class='display_br'>";
                        echo "<input class='input_profile_address2' name='new_address2' type='text' placeholder='市町村'>";
                        echo "</div>";
                        echo "<div class='ownself_label_position'>";
                        echo "<br><label class='profile_font_size'>自己紹介</label><br>";
                        echo "<textarea placeholder='自己紹介(255字以内)' class='ownself' name='new_introduction'>{$data['introduction']}</textarea>";
                        echo "</div>";
                        echo "<div>";
                        echo "<input name='select' value='0' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$_POST['address1']}' type='hidden'>";
                        echo "<input name='address2' value='{$_POST['address2']}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'button_save_man';
                        else
                            $class = 'button_save_woman';
                        echo "<div class='button_save_margin'><button class='{$class}'><b>保存</b></button></div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</form>";

                        echo "<form action='./editprofile.php' method='post'>";
                        echo "<input name='select' value='0' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$_POST['address1']}' type='hidden'>";
                        echo "<input name='address2' value='{$_POST['address2']}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'button_back_style_man';
                        else
                            $class = 'button_back_style_woman';
                        echo "<div class='button_back_margin_2'><button type='submit' class='{$class}'><b>戻る</b></button></div>";
                        echo "</form>";
                    } else {
                        if ($gender == "男性")
                            $color = 'blue';
                        else
                            $color = 'red';
                        echo "<form class='edit_select_2_form' action='./updatepassword.php' method='post'>";
                        echo "<div>";
                        echo "<label>現在のパスワード</label><br class='display_br'>";
                        echo "<input name='now_password' type='password' placeholder='現在のパスワード'><br>";
                        echo "<div class='input_margin'>";
                        echo "<label class='input_margin'>新しいパスワード</label><br class='display_br'>";
                        echo "<input name='new_password' type='password' placeholder='新しいパスワード'>";
                        echo "</div>";
                        echo "<label>新しいパスワード(確認)</label><br class='display_br'>";
                        echo "<input name='retype_password' type='password' placeholder='新しいパスワード(確認)'><br>";
                        echo "<input name='select' value='0' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'button_save_man';
                        else
                            $class = 'button_save_woman';
                        echo "<div class='button_save_margin'><button class='{$class}' type='submit'><b>保存</b></button></div>";
                        echo "</div>";
                        echo "</form>";

                        echo "<form action='./editprofile.php' method='post'>";
                        echo "<input name='select' value='0' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='chat' value='0' type='hidden'>";
                        echo "<input name='address1_search' value='全国' type='hidden'>";
                        echo "<input name='gender_search' value='性別' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'button_back_style_man';
                        else
                            $class = 'button_back_style_woman';
                        echo "<div class='button_back_margin'><button class='{$class}' type='submit'><b>戻る</b></button></div>";
                        echo "</form>";
                    }
                ?>
            </div>
        </div>
    </div>
    <?php if ($gender == '男性') $class = 'index_header_man'; else $class = 'index_header_woman';  echo "<div class=\"{$class}\">"; ?>
        <div class="edit_title">
            <p>☕️ プロフィール編集 ☕️</p>
        </div>
    </div>
</body>
</html>