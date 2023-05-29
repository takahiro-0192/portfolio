<?php
    $error = 0;
    if (!empty($_POST['message']) && mb_strlen($_POST['message']) <= 1000) {
        try {
            date_default_timezone_set('Asia/Tokyo');
            $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

            $sql = $pdo->prepare("INSERT INTO chat_1 SET message_id = :message_id, message = :message, to_id = :to_id, send_date = :send_date, open = :open;");
            $sql->execute(array(
                ":message_id" => $_POST['id'],
                ":message" => $_POST['message'],
                "to_id" => $_POST['list_id'],
                "send_date" => date('Y/m/d G:i:s'),
                "open" => 0
            ));

            $sql = $pdo->prepare("INSERT INTO chat_2 SET message_id = :message_id, message = :message, to_id = :to_id, send_date = :send_date, open = :open;");
            $sql->execute(array(
                ":message_id" => $_POST['id'],
                ":message" => $_POST['message'],
                "to_id" => $_POST['list_id'],
                "send_date" => date('Y/m/d G:i:s'),
                "open" => 0
            ));

            $sql = $pdo->prepare("SELECT * FROM chat_room WHERE account_id = :account_id AND from_id = :from_id;");
            $sql->execute(array(
                ":account_id" => $_POST['id'],
                ":from_id" => $_POST['list_id']
            ));
            $Chat_Room_1 = $sql->fetchAll(PDO::FETCH_ASSOC);

            $sql = $pdo->prepare("SELECT * FROM chat_room WHERE account_id = :account_id AND from_id = :from_id;");
            $sql->execute(array(
                ":account_id" => $_POST['list_id'],
                ":from_id" => $_POST['id']
            ));
            $Chat_Room_2 = $sql->fetchAll(PDO::FETCH_ASSOC);

            if (sizeof($Chat_Room_1) == 0 && sizeof($Chat_Room_2) == 0) {
                $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                $sql->execute(array(
                    ":room_no" => $_POST['id'],
                    ":account_id" => $_POST['id'],
                    ":from_id" => $_POST['list_id'],
                ));
                $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                $sql->execute(array(
                    ":room_no" => $_POST['id'],
                    ":account_id" => $_POST['list_id'],
                    ":from_id" => $_POST['id'],
                ));
            } else if (sizeof($Chat_Room_1) == 0 && sizeof($Chat_Room_2) != 0) {
                if ($Chat_Room_2[0]['room_no'] == $_POST['id']) {
                    $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                    $sql->execute(array(
                        ":room_no" => $_POST['id'],
                        ":account_id" => $_POST['id'],
                        ":from_id" => $_POST['list_id'],
                    ));
                } else {
                    $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                    $sql->execute(array(
                        ":room_no" => $_POST['list_id'],
                        ":account_id" => $_POST['id'],
                        ":from_id" => $_POST['list_id'],
                    ));
                }
            } else if (sizeof($Chat_Room_1) != 0 && sizeof($Chat_Room_2) == 0) {
                if ($Chat_Room_1[0]['room_no'] == $_POST['id']) {
                    $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                    $sql->execute(array(
                        ":room_no" => $_POST['id'],
                        ":account_id" => $_POST['list_id'],
                        ":from_id" => $_POST['id'],
                    ));
                } else {
                    $sql = $pdo->prepare("INSERT INTO chat_room SET room_no = :room_no, account_id = :account_id, from_id = :from_id;");
                    $sql->execute(array(
                        ":room_no" => $_POST['list_id'],
                        ":account_id" => $_POST['list_id'],
                        ":from_id" => $_POST['id'],
                    ));
                }
            }
        } catch(PDOException $e) {
            echo 'エラー:' . $e->getMessage() . '<br>';
        }
    } else if (empty($_POST['message']))
        $error = 1;
    elseif (mb_strlen($_POST['message']) > 1000)
        $error = 2;

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
    } catch (PDOException $e) {
        echo "エラー:" . $e->getMessage() . "<br>";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='./css/style.css' type='text/css' rel='stylesheet'>
    <title>チャット</title>
</head>
<body onload='document.FRM.submit();'>
    <div class='main_wrapper'>
        <div>
            <?php
                echo "
                    <form name='FRM' action='./index.php' method='post'>
                        <input name='error' value={$error} type='hidden'>
                        <input name='login' value=1 type='hidden'>
                        <input name='mode' value=0 type='hidden'>
                        <input name='chat_mode' value=1 type='hidden'>
                        <input name='list_id' value={$_POST['list_id']} type='hidden'>
                        <input name='list_name' value={$_POST['list_name']} type='hidden'>
                        <input name='id' value={$_POST['id']} type='hidden'>
                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                        <input name='email' value={$_POST['email']} type='hidden'>
                        <input name='tel' value={$_POST['tel']} type='hidden'>
                    </form>
                ";

                echo "
                    <h1>{$_POST['list_name']}とチャット</h1>
                    <div id='chat_area' class='chat_area_wrapper'>";
                    if ($_POST['chat_view'] == 1) {
                        for ($i = 0; $i < sizeof($chat_data_1); $i++) {
                            if ($chat_data_1[$i]['message_id'] == $_POST['id'] && $chat_data_1[$i]['to_id'] == $_POST['list_id']) {
                                $date = new DateTime($chat_data_1[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                echo "<div class='chat_style_1'>" .
                                        "<div class='time'>";
                                        echo "<div>";
                                            if ($chat_data_1[$i]['open'] == 0 || $chat_data_1[$i]['open'] == 2)
                                                echo "<p class='read_1'>未読</p>";
                                            else
                                                echo "<p>既読</p>";
                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                            "</div>" .
                                        "</div>" .
                                        "<div class='margin'>" .
                                            nl2br($chat_data_1[$i]['message']) .
                                        "</div>" .
                                    "</div>";
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
                            }
                        }
                        echo "<div id='message'></div>";
                    } else {
                        for ($i = 0; $i < sizeof($chat_data_2); $i++) {
                            if ($chat_data_2[$i]['message_id'] == $_POST['id'] && $chat_data_2[$i]['to_id'] == $_POST['list_id']) {
                                $date = new DateTime($chat_data_2[$i]['send_date'], new DateTimeZone('Asia/Tokyo'));
                                echo "<div class='chat_style_1'>" .
                                        "<div class='time'>";
                                        echo "<div>";
                                            if ($chat_data_2[$i]['open'] == 0 || $chat_data_2[$i]['open'] == 2)
                                                echo "<p class='read_2'>未読</p>";
                                            else
                                                echo "<p>既読</p>";
                                            echo "<p>" . $date->format('G:i') . "</p>" .
                                            "</div>" .
                                        "</div>" .
                                        "<div class='margin'>" .
                                            nl2br($chat_data_2[$i]['message']) .
                                        "</div>" .
                                    "</div>";
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
                            }
                        }
                        echo "<div id='message'></div>";
                    }

                    echo "<div class='chat_input_area_wrapper'>";
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
                                    <input name='chat_view' value={$_POST['chat_view']} type='hidden'>
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
                                    <input name='chat_view' value={$_POST['chat_view']} type='hidden'>
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
        </div>
    </div>
    <script type="text/javascript">
        scrollTo(0, document.getElementById('chat_area').scrollHeight);
    </script>
</body>
</html>