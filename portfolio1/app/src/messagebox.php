<?php
    $message_counter = 0;
    $id = $_POST['id'];
    $icon = $_POST['icon'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $birth = $_POST['birth'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    try {
        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
        $sql = $pdo->prepare("SELECT * FROM accounts;");
        $sql->execute();
        $data_account = $sql->fetchAll(PDO::FETCH_ASSOC);
        $account_recode_count = $sql->rowCount();
        $sql = $pdo->prepare("SELECT * FROM chat ORDER BY send_date DESC;");
        $sql->execute();
        $data_chat = $sql->fetchAll(PDO::FETCH_ASSOC);
        $chat_recode_count = $sql->rowCount();
        if (!empty($_POST['date'])) {
            $sql = $pdo->prepare("UPDATE chat SET open = ? WHERE message_id = ? AND from_id = ? AND send_date = ?;");
            $sql->bindValue(1, 1,PDO::PARAM_INT);
            $sql->bindValue(2, $_POST['message_id'],PDO::PARAM_INT);
            $sql->bindValue(3, $_POST['from_id'],PDO::PARAM_INT);
            $sql->bindValue(4, $_POST['date'],PDO::PARAM_STR);
            $sql->execute();
        }
        if (!empty($_POST['delete']) && $_POST['delete'] == '1') {
            $sql = $pdo->prepare("DELETE FROM chat WHERE message_id = ? AND from_id = ? AND send_date = ?;");
            $sql->bindValue(1, $_POST['message_id'],PDO::PARAM_INT);
            $sql->bindValue(2, $_POST['from_id'],PDO::PARAM_INT);
            $sql->bindValue(3, $_POST['date'],PDO::PARAM_STR);
            $sql->execute();
        }
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
<body onload="document.FRM.submit();">
    <?php
        if (!empty($_POST['delete']) && $_POST['delete'] == '1') {
            echo "<form name='FRM' action='./messagebox.php' method='post'>";
            echo "<input name='delete' value='0' type='hidden'>";
            echo "<input name='message_list' value='1' type='hidden'>";
            echo "<input name='message_view' value='0' type='hidden'>";
            echo "<input name='id' value='{$id}' type='hidden'>";
            echo "<input name='icon' value='{$icon}' type='hidden'>";
            echo "<input name='name' value='{$name}' type='hidden'>";
            echo "<input name='email' value='{$email}' type='hidden'>";
            echo "<input name='password' value='{$password}' type='hidden'>";
            echo "<input name='gender' value='{$gender}' type='hidden'>";
            echo "<input name='birth' value='{$birth}' type='hidden'>";
            echo "<input name='address1' value='{$address1}' type='hidden'>";
            echo "<input name='address2' value='{$address2}' type='hidden'>";
            echo "</form>";
        }
    ?>
    <?php if ($gender == '男性') $class = 'bgcolor_man'; else $class = 'bgcolor_woman';  echo "<div class=\"{$class}\">"; ?></div>
    <div class="message_box_page_wrapper">
        <div class='message_box_page_margin'>
            <?php
                if ($_POST['message_view'] == '0') {
                    echo "<p class='message_box_title'><b>メッセージBOX一覧</b></p>";
                    if ($gender == '男性')
                        $class='message_box_man';
                    else
                        $class='message_box_woman';
                    echo "<div class='{$class}'>";
                    for ($i = 0; $i < $chat_recode_count; $i++) {
                        if ($id == $data_chat[$i]['message_id'])
                            $message_counter++;
                    }
                    if ($message_counter == 0)
                        echo "<p class='notice_text'>メッセージはありません</p>";
                    else
                        echo "<p class='notice_text'>メッセージが{$message_counter}件あります。</p>";
                    echo "<div class='box_view_size'>";

                    echo "<div>";
                    $mine_message_counter = 0.0;
                    for ($i = 0, $j = 1; $i < $chat_recode_count; $i++) {
                        if ($id == $data_chat[$i]['message_id']) {
                            if ($j >= ($_POST['message_list'] * 10) - 9 && $j <= ($_POST['message_list'] * 10)) {
                                if ($data_chat[$i]['open'] == 1)
                                    $open = '開封済';
                                else
                                    $open = '未開封';
                                echo "<div class='message_button_form'>";
                                echo "<form action='./messagebox.php' method='post'>";
                                echo "<input name='message_view' value='1' type='hidden'>";
                                echo "<input name='id' value='{$id}' type='hidden'>";
                                echo "<input name='icon' value='{$icon}' type='hidden'>";
                                echo "<input name='name' value='{$name}' type='hidden'>";
                                echo "<input name='email' value='{$email}' type='hidden'>";
                                echo "<input name='password' value='{$password}' type='hidden'>";
                                echo "<input name='gender' value='{$gender}' type='hidden'>";
                                echo "<input name='birth' value='{$birth}' type='hidden'>";
                                echo "<input name='address1' value='{$address1}' type='hidden'>";
                                echo "<input name='address2' value='{$address2}' type='hidden'>";
                                echo "<input name='message_id' value='{$data_chat[$i]['message_id']}' type='hidden'>";
                                echo "<input name='from_id' value='{$data_chat[$i]['from_id']}' type='hidden'>";
                                echo "<input name='from_name' value='{$data_chat[$i]['from_name']}' type='hidden'>";
                                echo "<input name='message_title' value='{$data_chat[$i]['message_title']}' type='hidden'>";
                                echo "<input name='message' value='{$data_chat[$i]['message']}' type='hidden'>";
                                echo "<input name='date' value='{$data_chat[$i]['send_date']}' type='hidden'>";
                                echo "<button class='message_button' type='submit'>{$open} {$data_chat[$i]['from_name']} {$data_chat[$i]['send_date']}</button> ";
                                echo "</form>";
                                echo "<form class='message_button_delete_form' action='./messagebox.php' method='post'>";
                                echo "<input name='message_list' value='1' type='hidden'>";
                                echo "<input name='message_view' value='0' type='hidden'>";
                                echo "<input name='icon' value='{$icon}' type='hidden'>";
                                echo "<input name='id' value='{$id}' type='hidden'>";
                                echo "<input name='name' value='{$name}' type='hidden'>";
                                echo "<input name='email' value='{$email}' type='hidden'>";
                                echo "<input name='password' value='{$password}' type='hidden'>";
                                echo "<input name='gender' value='{$gender}' type='hidden'>";
                                echo "<input name='birth' value='{$birth}' type='hidden'>";
                                echo "<input name='address1' value='{$address1}' type='hidden'>";
                                echo "<input name='address2' value='{$address2}' type='hidden'>";
                                echo "<input name='delete' value='1' type='hidden'>";
                                echo "<input name='message_id' value='{$data_chat[$i]['message_id']}' type='hidden'>";
                                echo "<input name='from_id' value='{$data_chat[$i]['from_id']}' type='hidden'>";
                                echo "<input name='date' value='{$data_chat[$i]['send_date']}' type='hidden'>";
                                echo "<button class='message_button_delete'type='submit'>削除</button>";
                                echo "</form>";
                                echo "</div>";
                            }
                            $j++;
                            $mine_message_counter += 1.0;
                        }
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='button_page_wrapper'>";
                    echo "<div style='display: flex;'>";
                    if ($_POST['message_list'] > 1)
                        $back = $_POST['message_list'] - 1;
                    else
                        $back = 1;
                    echo "<form class='message_button_page_back_margin' action='./messagebox.php' method='post'>";
                    echo "<input name='icon' value='{$icon}' type='hidden'>";
                    echo "<input name='message_list' value='{$back}' type='hidden'>";
                    echo "<input name='message_view' value='0' type='hidden'>";
                    echo "<input name='id' value='{$id}' type='hidden'>";
                    echo "<input name='name' value='{$name}' type='hidden'>";
                    echo "<input name='email' value='{$email}' type='hidden'>";
                    echo "<input name='password' value='{$password}' type='hidden'>";
                    echo "<input name='gender' value='{$gender}' type='hidden'>";
                    echo "<input name='birth' value='{$birth}' type='hidden'>";
                    echo "<input name='address1' value='{$address1}' type='hidden'>";
                    echo "<input name='address2' value='{$address2}' type='hidden'>";
                    echo "<button class='message_button_page_change' type='submit'>◀︎</button>";
                    echo "</form>";
                    echo "<div class='message_button_page_list'>{$_POST['message_list']}</div>";
                    if ($mine_message_counter / $_POST['message_list'] - 9 > 1)
                        $next = $_POST['message_list'] + 1;
                    else
                        $next = $_POST['message_list'];
                    echo "<form class='message_button_page_next_margin' action='./messagebox.php' method='post'>";
                    echo "<input name='icon' value='{$icon}' type='hidden'>";
                    echo "<input name='message_list' value='{$next}' type='hidden'>";
                    echo "<input name='message_view' value='0' type='hidden'>";
                    echo "<input name='id' value='{$id}' type='hidden'>";
                    echo "<input name='name' value='{$name}' type='hidden'>";
                    echo "<input name='email' value='{$email}' type='hidden'>";
                    echo "<input name='password' value='{$password}' type='hidden'>";
                    echo "<input name='gender' value='{$gender}' type='hidden'>";
                    echo "<input name='birth' value='{$birth}' type='hidden'>";
                    echo "<input name='address1' value='{$address1}' type='hidden'>";
                    echo "<input name='address2' value='{$address2}' type='hidden'>";
                    echo "<button class='message_button_page_change' type='submit'>▶︎</button>";
                    echo "</form>";
                    echo "</div>";

                    echo "</div>";
                    echo "</div>";
                    echo "<form style='margin-top: 50px; margin-bottom: 100px;' action='./index.php' method='post'>";
                    echo "<input name='icon' value='{$icon}' type='hidden'>";
                    echo "<input name='id' value='{$id}' type='hidden'>";
                    echo "<input name='name' value='{$name}' type='hidden'>";
                    echo "<input name='email' value='{$email}' type='hidden'>";
                    echo "<input name='password' value='{$password}' type='hidden'>";
                    echo "<input name='gender' value='{$gender}' type='hidden'>";
                    echo "<input name='birth' value='{$birth}' type='hidden'>";
                    echo "<input name='address1' value='{$address1}' type='hidden'>";
                    echo "<input name='address2' value='{$address2}' type='hidden'>";
                    echo "<input name='chat' value='0' type='hidden'>";
                    echo "<input name='user_list' value='1' type='hidden'>";
                    echo "<input name='address1_search' value='全国' type='hidden'>";
                    echo "<input name='gender_search' value='性別' type='hidden'>";
                    if ($gender == '男性')
                        $class = 'message_box_button_back_man';
                    else
                        $class = 'message_box_button_back_woman';
                    echo "<div class='button_position'><button class='{$class}'><b>戻る</b></button></div>";
                    echo "</form>";
                    echo "</div>";
                } else {
                    try {
                        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
                        $sql = $pdo->prepare("SELECT * FROM accounts WHERE id = ?;");
                        $sql->bindValue(1, $_POST['from_id'], PDO::PARAM_INT);
                        $sql->execute();
                        $data_opponent_status = $sql->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo 'エラー:' . $e->getMessage() . '<br>';
                        die();
                    }
                    if ($data_opponent_status != NULL) {
                        if ($data_opponent_status['update_image_name'] != NULL)
                            $image_opponent = "{$data_opponent_status['update_image_name']}";
                        else {
                            if ($data_opponent_status['gender'] == '男性')
                                $image_opponent = './images/icon_man.png';
                            else
                                $image_opponent = './images/icon_woman.png';
                        }
                        echo "<div>";
                        echo "<form class='confirmation_form' action='./index.php' method='post'>";
                        echo "<input name='message_view' value='0' type='hidden'>";
                        echo "<input name='chat' value='1' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='id_opponent' value='{$_POST['from_id']}' type='hidden'>";
                        echo "<input name='name_opponent' value='{$_POST['from_name']}' type='hidden'>";
                        echo "<input name='image_opponent' value='{$image_opponent}' type='hidden'>";
                        echo "<input name='name_opponent' value='{$data_opponent_status['name']}' type='hidden'>";
                        echo "<input name='gender_opponent' value='{$data_opponent_status['gender']}' type='hidden'>";
                        echo "<input name='birth_opponent' value='{$data_opponent_status['date_of_Birth']}' type='hidden'>";
                        echo "<input name='address1_opponent' value='{$data_opponent_status['address1']}' type='hidden'>";
                        echo "<input name='address2_opponent' value='{$data_opponent_status['address2']}' type='hidden'>";
                        echo "<input name='introduction_opponent' value='{$data_opponent_status['introduction']}' type='hidden'>";
                        echo "<input name='title' class='message_title' value='件名：{$_POST['message_title']}'><br>";
                        echo "<textarea name='message' class='message'>メッセージ：\n{$_POST['message']}</textarea><br>";
                        if ($gender == '男性')
                            $class = 'button_resend_man';
                        else
                            $class = 'button_resend_woman';
                        echo "<div class='button_position'><button class='{$class}'><b>返信</b></button></div>";
                        echo "</form>";

                        echo "<form class='message_button_back' action='./messagebox.php' method='post'>";
                        echo "<input name='message_view' value='0' type='hidden'>";
                        echo "<input name='message_open' value='1' type='hidden'>";
                        echo "<input name='message_list' value='1' type='hidden'>";
                        echo "<input name='page' value='1' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='from_id' value='{$_POST['from_id']}' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'message_box_button_back_man';
                        else
                            $class = 'message_box_button_back_woman';
                        echo "<div class='button_position'><button class='{$class}'><b>戻る</b></button></div>";
                        echo "</form>";
                        echo "</div>";
                    } else {
                        echo "<p class='message_already_deleted'>このアカウントは既に削除されております。</p>";
                        echo "<form style='margin-top: 50px; margin-bottom: 100px;' action='./messagebox.php' method='post'>";
                        echo "<input name='message_view' value='0' type='hidden'>";
                        echo "<input name='message_open' value='1' type='hidden'>";
                        echo "<input name='message_list' value='1' type='hidden'>";
                        echo "<input name='page' value='1' type='hidden'>";
                        echo "<input name='icon' value='{$icon}' type='hidden'>";
                        echo "<input name='id' value='{$id}' type='hidden'>";
                        echo "<input name='name' value='{$name}' type='hidden'>";
                        echo "<input name='email' value='{$email}' type='hidden'>";
                        echo "<input name='password' value='{$password}' type='hidden'>";
                        echo "<input name='gender' value='{$gender}' type='hidden'>";
                        echo "<input name='birth' value='{$birth}' type='hidden'>";
                        echo "<input name='address1' value='{$address1}' type='hidden'>";
                        echo "<input name='address2' value='{$address2}' type='hidden'>";
                        echo "<input name='from_id' value='{$_POST['from_id']}' type='hidden'>";
                        if ($gender == '男性')
                            $class = 'message_box_button_back_man';
                        else
                            $class = 'message_box_button_back_woman';
                        echo "<div class='button_position'><button class='{$class}'><b>戻る</b></button></div>";
                        echo "</form>";
                    }
                }
            ?>
        </div>
    </div>
    <?php if ($gender == '男性') $class = 'index_header_man'; else $class = 'index_header_woman';  echo "<div class=\"{$class}\">"; ?>
        <div class="index_title_wrapper">
            <p class="index_title">☕️ Community Cafe ☕️</p>
            <p class="index_subtitle">-コミュニティーカフェ-</p>
        </div>
        <div class="account">
            <div class="margin">
                <?php echo "<img src='{$icon}' class='account_image'>"; ?>
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
                            <input name="message_open" value="0" type="hidden">
                            <input name="icon" value="<?php echo $icon; ?>" type="hidden">
                            <input name="id" value="<?php echo $id; ?>" type="hidden">
                            <input name="name" value="<?php echo $name; ?>" type="hidden">
                            <input name="gender" value="<?php echo $gender; ?>" type="hidden">
                            <input name="email" value="<?php echo $email; ?>" type="hidden">
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

