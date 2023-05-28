<?php
    if (empty($_POST['email']) && empty($_POST['password']))
        header('Location: ./login.php');

    $id = $_POST['id'];
    $name = $_POST['name'];
    $birth = $_POST['birth'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $address1_search = $_POST['address1_search'];
    $gender_search = $_POST['gender_search'];
    $icon = $_POST['icon'];
    try {
        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
        $sql = $pdo->prepare("SELECT * FROM accounts");
        $sql->execute();
        $data = $sql->fetchAll(PDO::FETCH_ASSOC);
        $counter = $sql->rowCount();
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
    <?php if ($gender == '男性') $class = 'bgcolor_man'; else $class = 'bgcolor_woman';  echo "<div class=\"{$class}\">"; ?></div>
    <? if ($_POST['chat'] == '0') echo "<div class='background_border'></div>";?>
    <?php
        echo "<div class='search_wrapper'>";
        echo "<div class='content_position'>";
        if ($_POST['chat'] == '0') {
            echo  "<b><p class='search_text'>メッセージを送信する相手を選択してください。</p></b>";
            echo "<form action='./index.php' method='post'>";
            echo "<label>🔎 都道府県で絞る</label><br class='display_br'>";
            echo "<select name='address1_search'>";
            echo "<option>全国</option>";
            $address1_search = [
                '北海道', '青森県', '山形県', '秋田県', '宮城県', '福島県', '岩手県', '栃木県', '群馬県', '茨城県', '埼玉県', '東京都', '千葉県', '神奈川県', '山梨県', '新潟県', '長野県', '静岡県', '愛知県', '岐阜県',
                '滋賀県', '富山県', '石川県', '福井県', '和歌山県', '大阪府', '奈良県', '三重県', '京都府', '兵庫県', '岡山県', '広島県', '山口県', '鳥取県', '広島県', '愛媛県', '香川県', '徳島県', '高知県', '佐賀県',
                '福岡県', '大分県', '熊本県', '宮崎県', '鹿児島県', '長崎県', '沖縄県'
            ];
            for ($i = 0; $i < 47; $i++) {
                echo "<option>{$address1_search[$i]}</option>";
            }
            echo "</select><br class='display_br'>";
            echo "<label class='search_text_margin'>🔎 性別で絞る</label><br class='display_br'>";
            echo "<select name='gender_search'>";
            echo "<option>性別</option>";
            echo "<option>男性</option>";
            echo "<option>女性</option>";
            echo "</select><br class='display_br'>";
            echo "<input name='icon' type='hidden' value='{$icon}'>";
            echo "<input name='id' type='hidden' value='{$id}'>";
            echo "<input name='name' type='hidden' value='{$name}'>";
            echo "<input name='birth' type='hidden' value='{$birth}'>";
            echo "<input name='gender' type='hidden' value='{$gender}'>";
            echo "<input name='address1' type='hidden' value='{$address1}'>";
            echo "<input name='address2' type='hidden' value='{$address2}'>";
            echo "<input name='email' type='hidden' value='{$email}'>";
            echo "<input name='password' type='hidden' value='{$password}'>";
            echo "<input name='chat' type='hidden' value='0'>";
            echo "<input name='user_list' type='hidden' value='1'>";
            echo "<button class='search_button_margin search_button_size' type='submit'>検索</button>";
            echo "</form>";
        }
        if ($_POST['chat'] == '0') {
            if ($_POST['address1_search'] == '全国') {
                if ($_POST['gender_search'] == '性別') {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($id != $data[$i]['id']) {
                            if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                if ($data[$i]['login_status'] == 1)
                                    $mark = '🟢';
                                else
                                    $mark = '🔴';
                                if ($data[$i]['gender'] == '男性') {
                                    $class = 'list_button_man';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_man.png';
                                } else {
                                    $class = 'list_button_woman';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_woman.png';
                                }
                                echo "<form class='list_margin' action='./index.php' method='post'>";
                                echo "<input type='hidden' name='chat' value='1'>";
                                echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                echo "<input name='icon' type='hidden' value='{$icon}'>";
                                echo "<input type='hidden' name='id' value='{$id}'>";
                                echo "<input type='hidden' name='name' value='{$name}'>";
                                echo "<input type='hidden' name='gender' value='{$gender}'>";
                                echo "<input type='hidden' name='birth' value='{$birth}'>";
                                echo "<input type='hidden' name='address1' value='{$address1}'>";
                                echo "<input type='hidden' name='address2' value='{$address2}'>";
                                echo "<input type='hidden' name='email' value='{$email}'>";
                                echo "<input type='hidden' name='password' value='{$password}'>";
                                echo "<input type='hidden' name='gender' value='{$gender}'>";
                                echo "<input type='hidden' name='address1_search' value='全国'>";
                                echo "<input type='hidden' name='gender_search' value='性別'>";
                                echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br><span>{$mark} {$data[$i]['gender']}</span><br><span>🎂 {$data[$i]['date_of_Birth']}</span></button>";
                                echo "</form>";
                            }
                            $j++;
                            $page_counter += 1.0;
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='性別'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1)
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='性別'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                } else if ($_POST['gender_search'] == '男性') {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($data[$i]['gender'] == '男性') {
                            if ($id != $data[$i]['id']) {
                                if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                    if ($data[$i]['login_status'] == 1)
                                        $mark = '🟢';
                                    else
                                        $mark = '🔴';
                                        $class = 'list_button_man';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_man.png';
                                    echo "<form class='list_margin' action='./index.php' method='post'>";
                                    echo "<input type='hidden' name='chat' value='1'>";
                                    echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                    echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                    echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                    echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                    echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                    echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                    echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                    echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                                    echo "<input name='id' type='hidden' value='{$id}'>";
                                    echo "<input name='name' type='hidden' value='{$name}'>";
                                    echo "<input type='hidden' name='email' value='{$email}'>";
                                    echo "<input type='hidden' name='password' value='{$password}'>";
                                    echo "<input type='hidden' name='gender' value='{$gender}'>";
                                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                                    echo "<input type='hidden' name='address1_search' value='全国'>";
                                    echo "<input type='hidden' name='gender_search' value='性別'>";
                                    echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br>{$mark} {$data[$i]['gender']}<br>🎂 {$data[$i]['date_of_Birth']}</button>";
                                    echo "</form>";
                                }
                                $j++;
                                $page_counter += 1.0;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='男性'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1)
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='男性'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                } else {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($data[$i]['gender'] == '女性') {
                            if ($id != $data[$i]['id']) {
                                if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                    if ($data[$i]['login_status'] == 1)
                                        $mark = '🟢';
                                    else
                                        $mark = '🔴';
                                    $class = 'list_button_woman';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_woman.png';
                                    echo "<form class='list_margin' action='./index.php' method='post'>";
                                    echo "<input type='hidden' name='chat' value='1'>";
                                    echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                    echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                    echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                    echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                    echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                    echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                    echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                    echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                                    echo "<input name='id' type='hidden' value='{$id}'>";
                                    echo "<input name='name' type='hidden' value='{$name}'>";
                                    echo "<input type='hidden' name='email' value='{$email}'>";
                                    echo "<input type='hidden' name='password' value='{$password}'>";
                                    echo "<input type='hidden' name='gender' value='{$gender}'>";
                                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                                    echo "<input type='hidden' name='address1_search' value='全国'>";
                                    echo "<input type='hidden' name='gender_search' value='性別'>";
                                    echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br>{$mark} {$data[$i]['gender']}<br>🎂 {$data[$i]['date_of_Birth']}</button>";
                                    echo "</form>";
                                }
                                $j++;
                                $page_counter += 1.0;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='女性'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1)
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='全国'>";
                    echo "<input name='gender_search' type='hidden' value='女性'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                if ($_POST['gender_search'] == '性別') {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($data[$i]['address1'] == $_POST['address1_search']) {
                            if ($id != $data[$i]['id']) {
                                if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                    if ($data[$i]['login_status'] == 1)
                                        $mark = '🟢';
                                    else
                                        $mark = '🔴';
                                    if ($data[$i]['gender'] == '男性') {
                                        $class = 'list_button_man';
                                        if ($data[$i]['update_image_name'] != NULL)
                                            $icon_other = "{$data[$i]['update_image_name']}";
                                        else
                                            $icon_other = './images/icon_man.png';
                                    } else {
                                        $class = 'list_button_woman';
                                        if ($data[$i]['update_image_name'] != NULL)
                                            $icon_other = "{$data[$i]['update_image_name']}";
                                        else
                                            $icon_other = './images/icon_woman.png';
                                    }
                                    echo "<form class='list_margin' action='./index.php' method='post'>";
                                    echo "<input type='hidden' name='chat' value='1'>";
                                    echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                    echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                    echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                    echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                    echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                    echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                    echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                    echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                                    echo "<input name='id' type='hidden' value='{$id}'>";
                                    echo "<input name='name' type='hidden' value='{$name}'>";
                                    echo "<input type='hidden' name='email' value='{$email}'>";
                                    echo "<input type='hidden' name='password' value='{$password}'>";
                                    echo "<input type='hidden' name='gender' value='{$gender}'>";
                                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                                    echo "<input type='hidden' name='address1_search' value='全国'>";
                                    echo "<input type='hidden' name='gender_search' value='性別'>";
                                    echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br>{$mark} {$data[$i]['gender']}<br>🎂 {$data[$i]['date_of_Birth']}</button>";
                                    echo "</form>";
                                }
                                $j++;
                                $page_counter += 1.0;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='性別'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1)
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='性別'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                } else if ($_POST['gender_search'] == '男性') {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($data[$i]['gender'] == '男性' && $data[$i]['address1'] == $_POST['address1_search']) {
                            if ($id != $data[$i]['id']) {
                                if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                    if ($data[$i]['login_status'] == 1)
                                        $mark = '🟢';
                                    else
                                        $mark = '🔴';
                                        $class = 'list_button_man';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_man.png';
                                    echo "<form class='list_margin' action='./index.php' method='post'>";
                                    echo "<input type='hidden' name='chat' value='1'>";
                                    echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                    echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                    echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                    echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                    echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                    echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                    echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                    echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                                    echo "<input name='id' type='hidden' value='{$id}'>";
                                    echo "<input name='name' type='hidden' value='{$name}'>";
                                    echo "<input type='hidden' name='email' value='{$email}'>";
                                    echo "<input type='hidden' name='password' value='{$password}'>";
                                    echo "<input type='hidden' name='gender' value='{$gender}'>";
                                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                                    echo "<input type='hidden' name='address1_search' value='全国'>";
                                    echo "<input type='hidden' name='gender_search' value='性別'>";
                                    echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br>{$mark} {$data[$i]['gender']}<br>🎂 {$data[$i]['date_of_Birth']}</button>";
                                    echo "</form>";
                                }
                                $j++;
                                $page_counter += 1.0;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='男性'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1)
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='男性'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                } else {
                    echo "<div class='search_list_wrapper'>";
                    $page_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $counter; $i++) {
                        if ($data[$i]['gender'] == '女性' && $data[$i]['address1'] == $_POST['address1_search']) {
                            if ($id != $data[$i]['id']) {
                                if ($j >= ($_POST['user_list'] * 50 - 49) && $j <= ($_POST['user_list'] * 50)) {
                                    if ($data[$i]['login_status'] == 1)
                                        $mark = '🟢';
                                    else
                                        $mark = '🔴';
                                    $class = 'list_button_woman';
                                    if ($data[$i]['update_image_name'] != NULL)
                                        $icon_other = "{$data[$i]['update_image_name']}";
                                    else
                                        $icon_other = './images/icon_woman.png';
                                    echo "<form class='list_margin' action='./index.php' method='post'>";
                                    echo "<input type='hidden' name='chat' value='1'>";
                                    echo "<input type='hidden' name='id_opponent' value='{$data[$i]['id']}'>";
                                    echo "<input type='hidden' name='name_opponent' value='{$data[$i]['name']}'>";
                                    echo "<input type='hidden' name='gender_opponent' value='{$data[$i]['gender']}'>";
                                    echo "<input type='hidden' name='birth_opponent' value='{$data[$i]['date_of_Birth']}'>";
                                    echo "<input type='hidden' name='address1_opponent' value='{$data[$i]['address1']}'>";
                                    echo "<input type='hidden' name='address2_opponent' value='{$data[$i]['address2']}'>";
                                    echo "<input type='hidden' name='introduction_opponent' value='{$data[$i]['introduction']}'>";
                                    echo "<input type='hidden' name='image_opponent' value='{$icon_other}'>";
                                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                                    echo "<input name='id' type='hidden' value='{$id}'>";
                                    echo "<input name='name' type='hidden' value='{$name}'>";
                                    echo "<input type='hidden' name='email' value='{$email}'>";
                                    echo "<input type='hidden' name='password' value='{$password}'>";
                                    echo "<input type='hidden' name='gender' value='{$gender}'>";
                                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                                    echo "<input type='hidden' name='address1_search' value='全国'>";
                                    echo "<input type='hidden' name='gender_search' value='性別'>";
                                    echo "<button class='{$class}'><img style='border-radius: 50%;' class='list_icon' src='{$icon_other}'><br><span class='list_address'>🏠 {$data[$i]['address1']}</span><br><span class='list_name'>{$data[$i]['name']}</span><br>{$mark} {$data[$i]['gender']}<br>🎂 {$data[$i]['date_of_Birth']}</button>";
                                    echo "</form>";
                                }
                                $j++;
                                $page_counter += 1.0;
                            }
                        }
                    }
                    echo "</div>";
                    echo "<div class='list_button_page_position'>";
                    echo "<form action='./index.php' method='post'>";
                    if ($_POST['user_list'] > 1)
                        $back = $_POST['user_list'] - 1;
                    else
                        $back = 1;
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='女性'>";
                    echo "<input name='user_list' type='hidden' value='{$back}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_back' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='list_page'>{$_POST['user_list']}</div>";
                    echo "<form action='./index.php' method='post'>";
                    if ($page_counter / $_POST['user_list'] - 49 > 1 )
                        $next = $_POST['user_list'] + 1;
                    else
                        $next = $_POST['user_list'];
                    echo "<input name='chat' type='hidden' value='0'>";
                    echo "<input name='address1_search' type='hidden' value='{$_POST['address1_search']}'>";
                    echo "<input name='gender_search' type='hidden' value='女性'>";
                    echo "<input name='user_list' type='hidden' value='{$next}'>";
                    echo "<input name='icon' type='hidden' value='{$icon}'>";
                    echo "<input name='id' type='hidden' value='{$id}'>";
                    echo "<input name='name' type='hidden' value='{$name}'>";
                    echo "<input name='email' type='hidden' value='{$email}'>";
                    echo "<input name='password' type='hidden' value='{$password}'>";
                    echo "<input name='gender' type='hidden' value='{$gender}'>";
                    echo "<input type='hidden' name='birth' value='{$birth}'>";
                    echo "<input type='hidden' name='address1' value='{$address1}'>";
                    echo "<input type='hidden' name='address2' value='{$address2}'>";
                    echo "<button class='list_button_next' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";
                }
            }
        } else {
            $id_opponent = $_POST['id_opponent'];
            $birth_opponent = $_POST['birth_opponent'];
            $gender_opponent = $_POST['gender_opponent'];
            $name_opponent = $_POST['name_opponent'];
            $address1_opponent = $_POST['address1_opponent'];
            $address2_opponent = $_POST['address2_opponent'];
            $introduction_opponent = $_POST['introduction_opponent'];
            $icon_other = $_POST['image_opponent'];
            if ($gender_opponent == '男性')
                $class = 'detail_bgcolor_man';
            else
                $class = 'detail_bgcolor_woman';
            echo "<div class='detail_content_position'>";
            echo "<div>";
            echo "<div class='{$class} detail_content'>";
            echo "<div class='detail_content_margin'>";
            echo "<p class='detail_title'>プロフィール詳細</p>";
            echo "<img style='border-radius: 50%;' class='detail_img' src='{$icon_other}'><br>";
            echo "<div class='detail_form_position'>";
            echo "<div class='detail_position_left'>";
            echo "<div class='detail_ownself_form_margin'>";
            echo "<p class='detail_font_size1'>名前：{$name_opponent}</p>";
            echo "<p class='detail_font_size1'>性別：{$gender_opponent}</p>";
            echo "<p class='detail_font_size1'>誕生日：{$birth_opponent}</p>";
            echo "<p class='detail_font_size1'>住所：{$address1_opponent}：{$address2_opponent}</p>";
            echo "<div class='detail_font_size2'>自己紹介</div>";
            echo "<div class='own_self_opponent'><div class='margin'>" . nl2br($introduction_opponent) . "</div></div>";
            echo "</div>";
            echo "</div>";
            echo "<div>";
            echo "<div class='detail_send_text'>メッセージを送信します。";
            echo "<form action='./sendmessage.php' method='post'>";
            echo "<input type='hidden' name='chat' value='0'>";
            echo "<input type='hidden' name='gender' value='{$gender}'>";
            echo "<input name='icon' type='hidden' value='{$icon}'>";
            echo "<input type='hidden' name='id' value='{$id}'>";
            echo "<input type='hidden' name='birth' value='{$birth}'>";
            echo "<input type='hidden' name='name' value='{$name}'>";
            echo "<input type='hidden' name='gender' value='{$gender}'>";
            echo "<input type='hidden' name='address1' value='{$address1}'>";
            echo "<input type='hidden' name='address2' value='{$address2}'>";
            echo "<input type='hidden' name='email' value='{$email}'>";
            echo "<input type='hidden' name='password' value='{$password}'>";
            echo "<input type='hidden' name='address1_search' value='全国'>";
            echo "<input type='hidden' name='gender_search' value='性別'>";
            echo "<input type='hidden' name='id_opponent' value='{$id_opponent}'>";
            echo "<input type='hidden' name='name_opponent' value='{$name_opponent}'>";
            echo "<input class='detail_input_title' name='message_title' type='text' placeholder='件名'><br>";
            echo "<textarea class='detail_input_message' name='message' type='text' placeholder='メッセージ'></textarea><br><br>";
            if ($gender_opponent == '男性')
                $class = 'detail_btn_man';
            else
                $class = 'detail_btn_woman';
            echo "<button type='submit' class='{$class}'><b>送信</b></button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<form class='detail_button_back_position' action='./index.php' method='post'>";
            echo "<input type='hidden' name='user_list' value='1'>";
            echo "<input type='hidden' name='chat' value='0'>";
            echo "<input name='icon' type='hidden' value='{$icon}'>";
            echo "<input type='hidden' name='id' value='{$id}'>";
            echo "<input type='hidden' name='name' value='{$name}'>";
            echo "<input type='hidden' name='gender' value='{$gender}'>";
            echo "<input type='hidden' name='birth' value='{$birth}'>";
            echo "<input type='hidden' name='address1' value='{$address1}'>";
            echo "<input type='hidden' name='address2' value='{$address2}'>";
            echo "<input type='hidden' name='email' value='{$email}'>";
            echo "<input type='hidden' name='password' value='{$password}'>";
            echo "<input type='hidden' name='address1_search' value='全国'>";
            echo "<input type='hidden' name='gender_search' value='性別'>";
            if ($gender == '男性')
                $class = 'detail_btn_man';
            else
                $class = 'detail_btn_woman';
            echo "<button type='submit' class='{$class} return_buttton_margin'><b>戻る</b></button>";
            echo "</form>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
    ?>
    <?php if ($gender == '男性') $class = 'index_header_man'; else $class = 'index_header_woman';  echo "<div class=\"{$class}\">"; ?>
        <div class="index_title_wrapper">
            <p class="index_title">☕️ Community Cafe ☕️</p>
            <p class="index_subtitle">-コミュニティーカフェ-</p>
        </div>
        <div class="account">
            <div class="margin">
                <?php
                    echo "<img src='{$icon}' class='account_image'>";
                ?>
            </div>
            <div id='id_menu' class="menu">
                <?php
                    for ($i = 1; $i <= 3; $i++)
                        echo "<div class='border_{$i}'></div>";
                ?>
                <div class='div'><a href='#id_menu' class='menu_open'></a><a href='#id_close' class='menu_close'></a></div>
                <ul>
                    <div class="item1"><p class="item1_name"><?php echo $name; ?></p><p class="item1_birth">🎂 <?php echo $birth; ?></p><p class="item1_address">🏠 <?php echo $address1 . ':' . $address2; ?></p><p class="item1_email">📬 <?php echo $email; ?></p></div>
                    <li <?php if ($gender == '男性') $class = 'list_bgcolor_man_1'; else $class = 'list_bgcolor_woman_1'; echo "class='{$class}'"; ?>>
                        <form action="./messagebox.php" method="post">
                            <input name="message_view" value="0" type="hidden">
                            <input name="message_list" value="1" type="hidden">
                            <input name="icon" value="<?php echo $icon; ?>" type="hidden">
                            <input name="message_open" value="0" type="hidden">
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                            <input name="name" value="<?php echo $name; ?>" type="hidden">
                            <input name="gender" value="<?php echo $gender; ?>" type="hidden">
                            <input name="email" value="<?php echo $email; ?>" type="hidden">
                            <input name="password" value="<?php echo $password; ?>" type="hidden">
                            <input name="birth" value="<?php echo $birth; ?>" type="hidden">
                            <input name="password" value="<?php echo $password; ?>" type="hidden">
                            <input name="address1" value="<?php echo $address1; ?>" type="hidden">
                            <input name="address2" value="<?php echo $address2; ?>" type="hidden">
                            <button type="submit">💬 メッセージを見る</button>
                        </form>
                    </li>
                    <li <?php if ($gender == '男性') $class = 'list_bgcolor_man_2'; else $class = 'list_bgcolor_woman_2'; echo "class='{$class}'"; ?>>
                        <form action="./editprofile.php" method="post">
                            <input name="select" value="0" type="hidden">
                            <input name="user_list" value="1" type="hidden">
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                            <input name="icon" value="<?php echo $icon; ?>" type="hidden">
                            <input name="name" value="<?php echo $name; ?>" type="hidden">
                            <input name="gender" value="<?php echo $gender; ?>" type="hidden">
                            <input name="email" value="<?php echo $email; ?>" type="hidden">
                            <input name="birth" value="<?php echo $birth; ?>" type="hidden">
                            <input name="password" value="<?php echo $password; ?>" type="hidden">
                            <input name="address1" value="<?php echo $address1; ?>" type="hidden">
                            <input name="address2" value="<?php echo $address2; ?>" type="hidden">
                            <input name="chat" value="0" type="hidden">
                            <input name="address1_search" value="全国" type="hidden">
                            <input name="gender_search" value="性別" type="hidden">
                            <button type="submit"><?php if ($gender == '男性') echo '📘'; else echo '📕';?> プロフィール編集</button>
                        </form>
                    </li>
                    <li <?php if ($gender == '男性') $class = 'list_bgcolor_man_3'; else $class = 'list_bgcolor_woman_3'; echo "class='{$class}'"; ?>>
                        <form action="./logout.php" method="post">
                            <input name="email" value="<?php echo $email; ?>" type="hidden">
                            <button type="submit">🚪 ログアウト</button>
                        </form>
                    </li>
                    <li <?php if ($gender == '男性') $class = 'list_bgcolor_man_4'; else $class = 'list_bgcolor_woman_4'; echo "class='{$class}'"; ?>>
                        <form  action="./deleteaccount.php" method="post">
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                            <input name="gender" value="<?php echo $gender; ?>" type="hidden">
                            <input name="email" value="<?php echo $email; ?>" type="hidden">
                            <button type="submit">🆑 アカウント削除</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
