<?php
    if (empty($_POST['login']) || $_POST['login'] == 0)
        header('Location: ./login.php');

    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        // チャットデータ1
        $sql = $pdo->prepare("SELECT * FROM chat_1;");
        $sql->execute();
        $chat_data_1 = $sql->fetchAll(PDO::FETCH_ASSOC);

        // チャットデータ2
        $sql = $pdo->prepare("SELECT * FROM chat_2;");
        $sql->execute();
        $chat_data_2 = $sql->fetchAll(PDO::FETCH_ASSOC);

        // チャットルーム
        $sql = $pdo->prepare("SELECT * FROM chat_room WHERE account_id = :account_id;");
        $sql->execute(array(
            ":account_id" => $_POST['id']
        ));
        $chat_room = $sql->fetchAll(PDO::FETCH_ASSOC);

        if ($_POST['mode'] == 0 && $_POST['chat_mode'] == 1) {
            $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE id = :id");
            $sql->execute(array(
                ":login_status" => 2,
                ":id" => $_POST['id']
            ));

            $sql = $pdo->prepare("UPDATE chat_1 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
            $sql->execute(array(
                ":open1" => 1,
                ":open2" => 0,
                ":message_id" => $_POST['list_id'],
                ":to_id" => $_POST['id']
            ));
            $sql = $pdo->prepare("UPDATE chat_2 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
            $sql->execute(array(
                ":open1" => 1,
                ":open2" => 0,
                ":message_id" => $_POST['list_id'],
                ":to_id" => $_POST['id']
            ));
        } else {
            $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE id = :id");
            $sql->execute(array(
                ":login_status" => 1,
                ":id" => $_POST['id']
            ));
        }
        // アカウントデータ
        $sql = $pdo->prepare("SELECT * FROM accounts;");
        $sql->execute();
        $Account_Data = $sql->fetchAll(PDO::FETCH_ASSOC);

        // 友達リストデータ
        $sql = $pdo->prepare("SELECT * FROM contact_list WHERE id = :id;");
        $sql->execute(array(
            ":id" => $_POST['id']
        ));
        $contact_list = $sql->fetchAll(PDO::FETCH_ASSOC);

        $search_box_error = 0;
        if (!empty($_POST['search_view']) && $_POST['search_view'] == 1 && empty($_POST['search_user'])) {
            $_POST['search_view'] = 0;
            $search_box_error = 1;
        } else if (!empty($_POST['search_view']) && $_POST['search_view'] == 1 && !empty($_POST['search_user'])) {
            if ($_POST['search_mode'] == 1) {
                if (mb_strlen($_POST['search_user']) <= 50) {
                    if (filter_var($_POST['search_user'] , FILTER_VALIDATE_EMAIL)) {
                        $sql = $pdo->prepare("SELECT * FROM accounts WHERE email = :email;");
                        $sql->execute(array(
                            ":email" => $_POST['search_user']
                        ));
                        $User_List = $sql->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $_POST['search_view'] = 0;
                        $search_box_error = 3;
                    }
                } else {
                    $_POST['search_view'] = 0;
                    $search_box_error = 5;
                }
            } else {
                if (mb_strlen($_POST['search_user']) <= 12) {
                    if (preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $_POST['search_user']) == 1) {
                        $sql = $pdo->prepare("SELECT * FROM accounts WHERE tel = :tel;");
                        $sql->execute(array(
                            ":tel" => $_POST['search_user']
                        ));
                        $User_List = $sql->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $_POST['search_view'] = 0;
                        $search_box_error = 4;
                    }
                } else {
                    $_POST['search_view'] = 0;
                    $search_box_error = 6;
                }
            }
        }
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }
    $mode_json = json_encode($_POST['mode']);
    if (!empty($_POST['chat_mode']))
        $chat_mode_json = json_encode($_POST['chat_mode']);
    else
        $chat_mode_json = 0;
    $login_id_json = json_encode($_POST['id']);
    if (!empty($_POST['list_id']))
        $list_id_json = json_encode($_POST['list_id']);
    else
        $list_id_json = 0;

    $message_counter = [0, 0];
    $message_counter_json = [0, 0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>チャット</title>
</head>
<body>
    <div class='main_wrapper'>
        <div>
            <?php
                switch ($_POST['mode']) {
                    case 0:
                        switch ($_POST['chat_mode']){
                            case 0:
                                echo "<h1>チャットルーム一覧</h1>";
                                if (sizeof($chat_room) == 0)
                                    echo '<p class="font-size">一覧はありません</p>';
                                else {
                                    for ($i = $_POST['chat_room_page'] * 10 - 9; $i <= $_POST['chat_room_page'] * 10; $i++) {
                                        if ($i <= sizeof($chat_room)) {
                                            try {
                                                $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                                                $sql = $pdo->prepare("SELECT * FROM accounts WHERE id = :id;");
                                                $sql->execute(array(
                                                    ":id" => $chat_room[$i - 1]['from_id']
                                                ));
                                                $Account_List = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                $sql = $pdo->prepare("SELECT * FROM chat_1 WHERE message_id = :message_id AND to_id = :to_id AND open = :open;");
                                                $sql->execute(array(
                                                    ":message_id" => $Account_List[0]['id'],
                                                    ":to_id" => $_POST['id'],
                                                    ":open" => 0
                                                ));
                                                $chat_1 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                $sql = $pdo->prepare("SELECT * FROM chat_2 WHERE message_id = :message_id AND to_id = :to_id AND open = :open;");
                                                $sql->execute(array(
                                                    ":message_id" => $Account_List[0]['id'],
                                                    ":to_id" => $_POST['id'],
                                                    ":open" => 0
                                                ));
                                                $chat_2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                                if ($chat_room[$i - 1]['account_id'] == $_POST['id']) {
                                                    if ($Account_List[0]['id_name'] == NULL)
                                                        $Account_List[0]['id_name'] = '未設定';
                                                    echo "
                                                        <div class='chat_room_list'>
                                                            <p>{$Account_List[0]['id_name']}";
                                                            if ($chat_room[$i - 1]['room_no'] == $_POST['id']) {
                                                                if (sizeof($chat_1) != 0) {
                                                                    echo " +" . sizeof($chat_1);
                                                                }
                                                            } else {
                                                                if (sizeof($chat_2) != 0) {
                                                                    echo " +" . sizeof($chat_2);
                                                                }
                                                            }
                                                        echo"</p>
                                                            <div class='flex btn'>
                                                                <form action='./index.php' method='post'>
                                                                    <input name='login' value=1 type='hidden'>
                                                                    <input name='mode' value=0 type='hidden'>
                                                                    <input name='chat_mode' value=1 type='hidden'>
                                                                    <input name='list_id' value={$Account_List[0]['id']} type='hidden'>
                                                                    <input name='list_name' value={$Account_List[0]['id_name']} type='hidden'>
                                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                                    <button>チャット</button>
                                                                </form>
                                                                <form action='./delete_chat_room.php' method='post'>
                                                                    <input name='login' value=1 type='hidden'>
                                                                    <input name='mode' value=0 type='hidden'>
                                                                    <input name='chat_mode' value=0 type='hidden'>
                                                                    <input name='list_id' value={$Account_List[0]['id']} type='hidden'>
                                                                    <input name='list_name' value={$Account_List[0]['id_name']} type='hidden'>
                                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                                    <button>削除</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    ";
                                                }
                                            } catch (PDOException $e) {
                                                echo 'エラー:' . $e->getMessage() . '<br>';
                                            }
                                        }
                                    }
                                    if ($_POST['chat_room_page'] > 1)
                                        $back = $_POST['chat_room_page'] - 1;
                                    else
                                        $back = 1;

                                    if (sizeof($chat_room) / $_POST['chat_room_page'] - 9 > 1)
                                        $next = $_POST['chat_room_page'] + 1;
                                    else
                                        $next = $_POST['chat_room_page'];

                                    echo "
                                        <div class='list_page position_center align-item-center margin-top-and-bottom'>
                                            <form action='./index.php' method='post'>
                                                <input name='login' value=1 type='hidden'>
                                                <input name='mode' value=0 type='hidden'>
                                                <input name='chat_mode' value=0 type='hidden'>
                                                <input name='chat_room_page' value={$back} type='hidden'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                <input name='email' value={$_POST['email']} type='hidden'>
                                                <input name='tel' value={$_POST['tel']} type='hidden'>
                                                <button>&#9664;&#65038;</button>
                                            </form>
                                            <p>{$_POST['chat_room_page']}</p>
                                            <form action='./index.php' method='post'>
                                                <input name='login' value=1 type='hidden'>
                                                <input name='mode' value=0 type='hidden'>
                                                <input name='chat_mode' value=0 type='hidden'>
                                                <input name='chat_room_page' value={$next} type='hidden'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                <input name='email' value={$_POST['email']} type='hidden'>
                                                <input name='tel' value={$_POST['tel']} type='hidden'>
                                                <button>&#9654;&#65038;</button>
                                            </form>
                                        </div>
                                    ";
                                }
                                break;
                            case 1:
                                try {
                                    $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                                    $sql = $pdo->prepare("SELECT * FROM chat_room WHERE room_no = :room_no AND account_id = :account_id AND from_id = :from_id;");
                                    $sql->execute(array(
                                        ":room_no" => $_POST['id'],
                                        ":account_id" => $_POST['id'],
                                        ":from_id" => $_POST['list_id']
                                    ));
                                    $chat_room_my1 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                    $sql = $pdo->prepare("SELECT * FROM chat_room WHERE room_no = :room_no AND account_id = :account_id AND from_id = :from_id;");
                                    $sql->execute(array(
                                        ":room_no" => $_POST['list_id'],
                                        ":account_id" => $_POST['id'],
                                        ":from_id" => $_POST['list_id']
                                    ));
                                    $chat_room_my2 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                    $sql = $pdo->prepare("SELECT * FROM chat_room WHERE room_no = :room_no AND account_id = :account_id AND from_id = :from_id;");
                                    $sql->execute(array(
                                        ":room_no" => $_POST['id'],
                                        ":account_id" => $_POST['list_id'],
                                        ":from_id" => $_POST['id']
                                    ));
                                    $chat_room_opponent1 = $sql->fetchAll(PDO::FETCH_ASSOC);

                                    $sql = $pdo->prepare("SELECT * FROM chat_room WHERE room_no = :room_no AND account_id = :account_id AND from_id = :from_id;");
                                    $sql->execute(array(
                                        ":room_no" => $_POST['list_id'],
                                        ":account_id" => $_POST['list_id'],
                                        ":from_id" => $_POST['id']
                                    ));
                                    $chat_room_opponent2 = $sql->fetchAll(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo 'エラー:' . getMessage() . '<br>';
                                }
                                if ((sizeof($chat_room_my1) == 0 && sizeof($chat_room_my2) == 0 && sizeof($chat_room_opponent1) == 0 && sizeof($chat_room_opponent2) == 0) ||
                                    (sizeof($chat_room_my1) != 0) && (sizeof($chat_room_my2) == 0) || (sizeof($chat_room_my1) == 0 && sizeof($chat_room_opponent1) != 0))
                                    $chat_view = 1;
                                else
                                    $chat_view = 2;
                                echo "
                                    <h1>{$_POST['list_name']}とチャット</h1>
                                    <div id='chat_area' class='chat_area_wrapper'>";

                                    if ($chat_view == 1) {
                                        for ($i = 0, $j = 1; $i < sizeof($chat_data_1); $i++) {
                                            if ($chat_data_1[$i]['message_id'] == $_POST['id'] && $chat_data_1[$i]['to_id'] == $_POST['list_id']) {
                                                $date = new DateTime($chat_data_1[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                                echo "<div class='chat_style_1'>" .
                                                        "<div class='time'>";
                                                        echo "<div>";
                                                            if ($chat_data_1[$i]['open'] == 0 || $chat_data_1[$i]['open'] == 2)
                                                                echo "<p id='read1_{$j}' class='read_chat'>未読</p>";
                                                            else
                                                                echo "<p>既読</p>";
                                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                                            "</div>" .
                                                        "</div>" .
                                                        "<div class='margin'>" .
                                                            nl2br($chat_data_1[$i]['message']) .
                                                        "</div>" .
                                                    "</div>";
                                                $j++;
                                                $message_counter[0]++;
                                                $message_counter_json[0] = json_encode($message_counter[0]);
                                            } else if ($chat_data_1[$i]['message_id'] == $_POST['list_id'] && $chat_data_1[$i]['to_id'] == $_POST['id']) {
                                                $date = new DateTime($chat_data_1[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                                echo "<div class='chat_style_2'>" .
                                                        "<div class='margin'>" .
                                                            nl2br($chat_data_1[$i]['message']) .
                                                        "</div>" .
                                                        "<div class='time'>";
                                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                                        "</div>" .
                                                    "</div>";
                                                $message_counter[0]++;
                                                $message_counter_json[0] = json_encode($message_counter[0]);
                                            }
                                        }
                                        echo "<div id='message'></div>";
                                    } else {
                                        for ($i = 0, $j = 1; $i < sizeof($chat_data_2); $i++) {
                                            if ($chat_data_2[$i]['message_id'] == $_POST['id'] && $chat_data_2[$i]['to_id'] == $_POST['list_id']) {
                                                $date = new DateTime($chat_data_2[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                                echo "<div class='chat_style_1'>" .
                                                        "<div class='time'>";
                                                        echo "<div>";
                                                            if ($chat_data_2[$i]['open'] == 0 || $chat_data_2[$i]['open'] == 2)
                                                                echo "<p id='read2_{$j}' class='read_chat'>未読</p>";
                                                            else
                                                                echo "<p>既読</p>";
                                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                                            "</div>" .
                                                        "</div>" .
                                                        "<div class='margin'>" .
                                                            nl2br($chat_data_2[$i]['message']) .
                                                        "</div>" .
                                                    "</div>";
                                                $j++;
                                                $message_counter[1]++;
                                                $message_counter_json[1] = json_encode($message_counter[1]);
                                            } else if ($chat_data_2[$i]['message_id'] == $_POST['list_id'] && $chat_data_2[$i]['to_id'] == $_POST['id']) {
                                                $date = new DateTime($chat_data_2[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                                echo "<div class='chat_style_2'>" .
                                                        "<div class='margin'>" .
                                                            nl2br($chat_data_2[$i]['message']) .
                                                        "</div>" .
                                                        "<div class='time'>";
                                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                                        "</div>" .
                                                    "</div>";
                                                $message_counter[1]++;
                                                $message_counter_json[1] = json_encode($message_counter[1]);
                                            }
                                        }
                                        echo "<div id='message'></div>";
                                    }
                                echo "</div>
                                    <div class='chat_input_area_wrapper'>";
                                    echo "<div class=''>";
                                        if (!empty($_POST['error']) && $_POST['error'] == 1)
                                            echo "<p>未入力です</p>";
                                        if (!empty($_POST['error']) && $_POST['error'] == 2)
                                            echo "<p>1000字以内入力してください</p>";

                                        echo "
                                            <div class='flex align-item-center'>
                                                <form class='btn' action='./index.php' method='post'>
                                                    <input name='login' value=1 type='hidden'>
                                                    <input name='mode' value=0 type='hidden'>
                                                    <input name='chat_mode' value=0 type='hidden'>
                                                    <input name='chat_room_page' value=1 type='hidden'>
                                                    <input name='list_id' value={$_POST['list_id']} type='hidden'>
                                                    <input name='list_name' value={$_POST['list_name']} type='hidden'>
                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                    <button>戻る</button>
                                                </form>
                                                <form style='display: flex; justify-content: center; align-items: center;' action='./send_message.php' method='post'>
                                                    <input name='login' value=1 type='hidden'>
                                                    <input name='mode' value=0 type='hidden'>
                                                    <input name='chat_mode' value=1 type='hidden'>
                                                    <input name='chat_view' value={$chat_view} type='hidden'>
                                                    <input name='list_id' value={$_POST['list_id']} type='hidden'>
                                                    <input name='list_name' value={$_POST['list_name']} type='hidden'>
                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                    <textarea name='message'></textarea>
                                                    <button>送信</button>
                                                </form>
                                                <form style='display: flex; justify-content: center; align-items: center;' action='./delete_message.php' method='post'>
                                                    <input name='login' value=1 type='hidden'>
                                                    <input name='chat_view' value={$chat_view} type='hidden'>
                                                    <input name='mode' value=0 type='hidden'>
                                                    <input name='chat_mode' value=1 type='hidden'>
                                                    <input name='list_id' value={$_POST['list_id']} type='hidden'>
                                                    <input name='list_name' value={$_POST['list_name']} type='hidden'>
                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                    <button>クリア</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                ";
                                break;
                        }
                        break;
                    case 1:
                        echo "<div class='contact_list'>";
                        echo "<h1>友達リスト一覧</h1>";
                        if (sizeof($contact_list) == 0)
                            echo "<p>一覧はありません</p>";
                        else {
                            for ($i = ($_POST['friend_list_page'] * 10) - 9; $i <= $_POST['friend_list_page'] * 10; $i++) {
                                if ($i <= sizeof($contact_list)) {
                                    try {
                                        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                                        $sql = $pdo->prepare("SELECT * FROM accounts WHERE id = :id;");
                                        $sql->execute(array(
                                            ":id" => $contact_list[$i - 1]['list_id']
                                        ));
                                        $Account_List = $sql->fetchAll(PDO::FETCH_ASSOC);

                                        if ($Account_List[0]['id_name'] == NULL)
                                            $Account_List[0]['id_name'] = '未設定';
                                        echo "
                                            <div class='list'>
                                                <p>{$Account_List[0]['id_name']}</p>
                                                <div class='flex margin-right'>
                                                    <form action='./index.php' method='post'>
                                                        <input name='login' value=1 type='hidden'>
                                                        <input name='mode' value=0 type='hidden'>
                                                        <input name='chat_mode' value=1 type='hidden'>
                                                        <input name='list_id' value={$Account_List[0]['id']} type='hidden'>
                                                        <input name='list_name' value={$Account_List[0]['id_name']} type='hidden'>
                                                        <input name='id' value={$_POST['id']} type='hidden'>
                                                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                        <input name='email' value={$_POST['email']} type='hidden'>
                                                        <input name='tel' value={$_POST['tel']} type='hidden'>
                                                        <button>チャット</button>
                                                    </form>
                                                    <form action='./delete_friend.php' method='post'>
                                                        <input name='login' value=1 type='hidden'>
                                                        <input name='mode' value=1 type='hidden'>
                                                        <input name='friend_list_page' value=1 type='hidden'>
                                                        <input name='list_id' value={$Account_List[0]['id']} type='hidden'>
                                                        <input name='list_name' value={$Account_List[0]['id_name']} type='hidden'>
                                                        <input name='id' value={$_POST['id']} type='hidden'>
                                                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                        <input name='email' value={$_POST['email']} type='hidden'>
                                                        <input name='tel' value={$_POST['tel']} type='hidden'>
                                                        <button>削除</button>
                                                    </form>
                                                </div>
                                            </div>
                                        ";
                                    } catch (PDOException $e) {
                                        echo 'エラー:' . $e->getMessage() . '<br>';
                                    }
                                }
                            }
                            if ($_POST['friend_list_page'] > 1)
                                $back = $_POST['friend_list_page'] - 1;
                            else
                                $back = 1;

                            if (sizeof($contact_list) / $_POST['friend_list_page'] - 9 > 1)
                                $next = $_POST['friend_list_page'] + 1;
                            else
                                $next = $_POST['friend_list_page'];

                            echo "
                                <div class='list_page position_center align-item-center margin-top-and-bottom'>
                                    <form action='./index.php' method='post'>
                                        <input name='login' value=1 type='hidden'>
                                        <input name='mode' value=1 type='hidden'>
                                        <input name='friend_list_page' value={$back} type='hidden'>
                                        <input name='id' value={$_POST['id']} type='hidden'>
                                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                        <input name='email' value={$_POST['email']} type='hidden'>
                                        <input name='tel' value={$_POST['tel']} type='hidden'>
                                        <button>&#9664;&#65038;</button>
                                    </form>
                                    <p>{$_POST['friend_list_page']}</p>
                                    <form action='./index.php' method='post'>
                                        <input name='login' value=1 type='hidden'>
                                        <input name='mode' value=1 type='hidden'>
                                        <input name='friend_list_page' value={$next} type='hidden'>
                                        <input name='id' value={$_POST['id']} type='hidden'>
                                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                        <input name='email' value={$_POST['email']} type='hidden'>
                                        <input name='tel' value={$_POST['tel']} type='hidden'>
                                        <button>&#9654;&#65038;</button>
                                    </form>
                                </div>
                            ";
                        }
                        echo "</div>";
                        break;
                    case 2:
                        switch ($_POST['search_view']) {
                            case 0:
                                echo "
                                    <div class='search_user'>
                                        <h1>ユーザー検索</h1>";
                                        if ($search_box_error == 1)
                                            echo "<p>検索ボックスが未入力です</p>";
                                        if ($search_box_error == 2)
                                            echo "<p>30字以内入力してください</p>";
                                        if ($search_box_error == 3)
                                            echo "<p>メールアドレスの入力が正しくありません</p>";
                                        if ($search_box_error == 4)
                                            echo "<p>電話番号の入力が正しくありません</p>";
                                        if ($search_box_error == 5)
                                            echo "<p>メールアドレスは30字以内入力してください</p>";
                                        if ($search_box_error == 6)
                                            echo "<p>電話番号は12字以内入力してください</p>";
                                    echo "<form class='search_form' action='./index.php' method='post'>
                                            <div>
                                                <div class='radio'>
                                                    <input name='login' value=1 type='hidden'>
                                                    <input name='mode' value=2 type='hidden'>
                                                    <input name='search_view' value=1 type='hidden'>
                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                    <input name='search_mode' value=1 type='radio' checked>メール
                                                    <input name='search_mode' value=2 type='radio'>電話番号
                                                </div>
                                                <input name='search_user' class='box_search' type='text' placeholder='検索'><br>
                                                <button>検索</button>
                                            </div>
                                        </form>
                                    </div>";
                                break;
                            case 1:
                                $list_check_count = 0;
                                echo "
                                    <div class='user_list'>
                                        <h1>ユーザー一覧</h1>";
                                        if (sizeof($User_List) == 0)
                                            echo "<p>検索結果はありません</p>";
                                        else {
                                            for ($i = 0; $i < sizeof($User_List); $i++) {
                                                if ($User_List[$i]['id'] != $_POST['id']) {
                                                    if ($User_List[$i]['id_name'] == NULL)
                                                        $User_List[$i]['id_name'] = '未設定';
                                                    echo "
                                                        <div class='list'>
                                                            <p>{$User_List[$i]['id_name']}</p>
                                                            <div class='flex btn_list'>
                                                                <form action='./index.php' method='post'>
                                                                    <input name='login' value=1 type='hidden'>
                                                                    <input name='mode' value=0 type='hidden'>
                                                                    <input name='chat_mode' value=1 type='hidden'>
                                                                    <input name='list_id' value={$User_List[$i]['id']} type='hidden'>
                                                                    <input name='list_name' value={$User_List[$i]['id_name']} type='hidden'>
                                                                    <input name='id' value={$_POST['id']} type='hidden'>
                                                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                                    <input name='email' value={$_POST['email']} type='hidden'>
                                                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                                                    <button>チャット</button>
                                                                </form>";
                                                                for ($j = 0; $j < sizeof($contact_list); $j++) {
                                                                    if ($contact_list[$j]['list_id'] == $User_List[$i]['id'])
                                                                        $list_check_count++;
                                                                }
                                                                if ($list_check_count == 0) {
                                                                    echo "<form action='./add_friend.php' method='post'>
                                                                            <input name='login' value=1 type='hidden'>
                                                                            <input name='mode' value=1 type='hidden'>
                                                                            <input name='friend_list_page' value=1 type='hidden'>
                                                                            <input name='list_id' value={$User_List[$i]['id']} type='hidden'>
                                                                            <input name='list_name' value={$User_List[$i]['id_name']} type='hidden'>
                                                                            <input name='id' value={$_POST['id']} type='hidden'>
                                                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                                            <input name='email' value={$_POST['email']} type='hidden'>
                                                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                                                            <button>友達に追加</button>
                                                                        </form>";
                                                                } else {
                                                                    echo "<form action='./delete_friend.php' method='post'>
                                                                            <input name='search' value=1 type='hidden'>
                                                                            <input name='login' value=1 type='hidden'>
                                                                            <input name='mode' value=1 type='hidden'>
                                                                            <input name='list_id' value={$User_List[$i]['id']} type='hidden'>
                                                                            <input name='list_name' value={$User_List[$i]['id_name']} type='hidden'>
                                                                            <input name='id' value={$_POST['id']} type='hidden'>
                                                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                                            <input name='email' value={$_POST['email']} type='hidden'>
                                                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                                                            <button>友達から削除</button>
                                                                        </form>";
                                                                }
                                                        echo "</div>
                                                        </div>";
                                                } else if (sizeof($User_List) == 1)
                                                    echo "<p>検索結果はありません</p>";
                                            }
                                        }
                                    echo "<form action='./index.php' method='post'>
                                            <input name='login' value=1 type='hidden'>
                                            <input name='mode' value=2 type='hidden'>
                                            <input name='search_view' value=0 type='hidden'>
                                            <input name='id' value={$_POST['id']} type='hidden'>
                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                            <input name='email' value={$_POST['email']} type='hidden'>
                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                            <button>戻る</button>
                                        </form>
                                    </div>
                                ";
                                break;
                            case 2:
                                break;
                        }
                        break;
                    case 3:
                        switch ($_POST['edit_mode']) {
                            case 0:
                                echo "
                                    <div class='position_center edit'>
                                        <div class='title'>
                                            <h1>設定</h1>
                                            <form action='./index.php' method='post'>
                                                <input name='login' value=1 type='hidden'>
                                                <input name='mode' value=3 type='hidden'>
                                                <input name='edit_mode' value=1 type='hidden'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                <input name='email' value={$_POST['email']} type='hidden'>
                                                <input name='tel' value={$_POST['tel']} type='hidden'>
                                                <button>登録情報確認</button>
                                            </form>
                                            <form action='./index.php' method='post'>
                                                <input name='login' value=1 type='hidden'>
                                                <input name='mode' value=3 type='hidden'>
                                                <input name='edit_mode' value=2 type='hidden'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                <input name='email' value={$_POST['email']} type='hidden'>
                                                <input name='tel' value={$_POST['tel']} type='hidden'>
                                                <button>登録情報変更</button>
                                            </form>
                                            <form action='./delete_account.php' method='post'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <button>アカウント削除</button>
                                            </form>
                                        </div>
                                    </div>";
                                break;
                            case 1:
                                echo "
                                    <div class='confirmation_wrapper'>
                                        <h1>登録情報</h1>
                                        <p class='id_number'>No.{$_POST['id']}</p>
                                        <p>ユーザー名 : {$_POST['id_name']}</p>
                                        <p class='email'>email : {$_POST['email']}</p>
                                        <p>TEL : {$_POST['tel']}</p>

                                        <form style='margin-right: 20px;' action='./index.php' method='post'>
                                            <input name='login' value=1 type='hidden'>
                                            <input name='mode' value=3 type='hidden'>
                                            <input name='edit_mode' value=0 type='hidden'>
                                            <input name='id' value={$_POST['id']} type='hidden'>
                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                            <input name='email' value={$_POST['email']} type='hidden'>
                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                            <button>戻る</button>
                                        </form>
                                    </div>";
                                break;
                            case 2:
                                echo '
                                    <div class="position_center edit_profile">
                                        <div>
                                            <h1>登録情報変更</h1>
                                            <div class="border">
                                                <div class="flex_pc margin">';
                                                    if (!empty($_POST['error_password']) && ($_POST['error_password'] == 1 || $_POST['error_password'] == 5)) {
                                                        $class = 'margin-left-1';
                                                        $class_2 = 'margin-left-3';
                                                    } else {
                                                        $class = 'margin-left-2';
                                                        $class_2 = 'margin-left-3';
                                                    }
                                                    echo "<form class='{$class} margin-right-1' action='./update_profile.php' method='post'>";
                                                    if (!empty($_POST['error']) && $_POST['error'] == 1)
                                                        echo '<p>変更項目がありません</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 2)
                                                        echo '<p>ID名は10字以内入力してください</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 3)
                                                        echo '<p>電話番号の入力が正しくありません</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 4)
                                                        echo '<p>ID名が変更されました</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 5)
                                                        echo '<p>電話番号が変更されました</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 6)
                                                        echo '<p>電話番号が既に登録されております</p>';
                                                    if (!empty($_POST['error']) && $_POST['error'] == 7)
                                                        echo '<p>ID名と電話番号が変更されました</p>';
                                                    echo "
                                                            <input name='mode' value={$_POST['mode']} type='hidden'>
                                                            <input name='id' value={$_POST['id']} type='hidden'>
                                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                            <input name='email' value={$_POST['email']} type='hidden'>
                                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                                            <input name='new_id_name' type='text' placeholder='ID名:10字以内'><br>
                                                            <input name='new_tel' type='text' placeholder='電話番号:09012345678'><br>
                                                            <button>変更</button>
                                                        </form>
                                                        <form class='{$class_2} margin-top margin-right-2' action='./update_password.php' method='post'>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 1)
                                                        echo "<p>パスワードとパスワード(確認)が未入力です</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 2)
                                                        echo "<p>パスワードが未入力です</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 3)
                                                        echo "<p>パスワード(確認)が未入力です</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 4)
                                                        echo "<p>パスワードが確認用と異なっております</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 5)
                                                        echo "<p>パスワードは4字以上255字以内入力してください</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 6)
                                                        echo "<p>パスワードは半角文字を入力してください</p>";
                                                    if (!empty($_POST['error_password']) && $_POST['error_password'] == 7)
                                                        echo "<p>パスワードを変更しました</p>";
                                                    echo "
                                                            <input name='mode' value={$_POST['mode']} type='hidden'>
                                                            <input name='id' value={$_POST['id']} type='hidden'>
                                                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                            <input name='email' value={$_POST['email']} type='hidden'>
                                                            <input name='tel' value={$_POST['tel']} type='hidden'>
                                                            <input name='new_password' type='password' placeholder='パスワード:4〜255字(半角文字)'><br>
                                                            <input name='new_password_retype' type='password' placeholder='パスワード確認'><br>
                                                            <button>変更</button>
                                                        </form>
                                                    ";
                                            echo "</div>";
                                        echo "</div>";
                                        echo "
                                            <form action='./index.php' method='post'>
                                                <input name='mode' value=3 type='hidden'>
                                                <input name='edit_mode' value=0 type='hidden'>
                                                <input name='login' value=1 type='hidden'>
                                                <input name='id' value={$_POST['id']} type='hidden'>
                                                <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                                <input name='email' value={$_POST['email']} type='hidden'>
                                                <input name='tel' value={$_POST['tel']} type='hidden'>
                                                <button>戻る</button>
                                            </form>";
                                echo "</div>";
                            echo "</div>";
                            break;
                        }
                        break;
                }
            ?>
        </div>
    </div>
    <?php
        echo "
            <div class='header_wrapper'>
                <div class='header_content_margin'>
                    <div class='flex align-item-center margin-left'>
                        <p class='margin-top-and-bottom margin-right'>ユーザー名<span class='display_none_phone'>:</span><br class='display_br'>{$_POST['id_name']}</p>
                        <form class='margin-right' action='./index.php' method='post'>
                            <input name='login' value=1 type='hidden'>
                            <input name='mode' value=0 type='hidden'>
                            <input name='chat_mode' value=0 type='hidden'>
                            <input name='chat_room_page' value=1 type='hidden'>
                            <input name='id' value={$_POST['id']} type='hidden'>
                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                            <input name='email' value={$_POST['email']} type='hidden'>
                            <input name='tel' value={$_POST['tel']} type='hidden'>
                            <button>チャット</button>
                        </form>
                        <form class='margin-right' action='./index.php' method='post'>
                            <input name='login' value=1 type='hidden'>
                            <input name='mode' value=1 type='hidden'>
                            <input name='friend_list_page' value=1 type='hidden'>
                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                            <input name='id' value={$_POST['id']} type='hidden'>
                            <input name='email' value={$_POST['email']} type='hidden'>
                            <input name='tel' value={$_POST['tel']} type='hidden'>
                            <button>友達リスト</button>
                        </form>
                        <form class='margin-right' action='./index.php' method='post'>
                            <input name='login' value=1 type='hidden'>
                            <input name='mode' value=2 type='hidden'>
                            <input name='search_view' value=0 type='hidden'>
                            <input name='id' value={$_POST['id']} type='hidden'>
                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                            <input name='email' value={$_POST['email']} type='hidden'>
                            <input name='tel' value={$_POST['tel']} type='hidden'>
                            <button>ユーザー検索</button>
                        </form>
                        <form class='margin-right' action='./index.php' method='post'>
                            <input name='login' value=1 type='hidden'>
                            <input name='mode' value=3 type='hidden'>
                            <input name='edit_mode' value=0 type='hidden'>
                            <input name='id' value={$_POST['id']} type='hidden'>
                            <input name='id_name' value={$_POST['id_name']} type='hidden'>
                            <input name='email' value={$_POST['email']} type='hidden'>
                            <input name='tel' value={$_POST['tel']} type='hidden'>
                            <button>設定</button>
                        </form>
                    </div>
                    <form class='margin-right' action='./logout.php' method='post'>
                        <input name='id' value={$_POST['id']} type='hidden'>
                        <button>ログアウト</button>
                    </form>
                </div>
            </div>";
    ?>

    <script type="text/javascript">
        mode = JSON.parse('<?php echo $mode_json; ?>');
        chat_mode = JSON.parse('<?php echo $chat_mode_json; ?>');
        login_id = JSON.parse('<?php echo $login_id_json; ?>');
        list_id = JSON.parse('<?php echo $list_id_json; ?>');
        message_counter_php_1 = JSON.parse('<?php echo $message_counter_json[0]; ?>');
        message_counter_php_2 = JSON.parse('<?php echo $message_counter_json[1]; ?>');
    </script>
    <script src="./javascript/jquery.js" type="text/javascript"></script>
    <script src="./javascript/moment.js" type="text/javascript"></script>
    <script src="./javascript/realtime.js" type="text/javascript"></script>
</body>
</html>
