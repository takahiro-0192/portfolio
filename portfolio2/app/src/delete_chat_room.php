<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        $sql = $pdo->prepare("SELECT * FROM chat_room WHERE account_id = :account_id AND from_id = :from_id;");
        $sql->execute(array(
            ":account_id" => $_POST['id'],
            ":from_id" => $_POST['list_id']
        ));
        $chat_room1 = $sql->fetchAll(PDO::FETCH_ASSOC);

        if (sizeof($chat_room1) != 0) {
            if ($chat_room1[0]['room_no'] == $_POST['id']) {
                $sql = $pdo->prepare("DELETE FROM chat_1 WHERE message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":message_id" => $_POST['id'],
                    ":to_id" => $_POST['list_id']
                ));
                $sql = $pdo->prepare("DELETE FROM chat_1 WHERE message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":message_id" => $_POST['list_id'],
                    ":to_id" => $_POST['id']
                ));

                $sql = $pdo->prepare("UPDATE chat_2 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":open1" => 2,
                    ":open2" => 0,
                    ":message_id" => $_POST['id'],
                    ":to_id" => $_POST['list_id']
                ));
                $sql = $pdo->prepare("UPDATE chat_2 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":open1" => 2,
                    ":open2" => 0,
                    ":message_id" => $_POST['list_id'],
                    ":to_id" => $_POST['id']
                ));
            } else {
                $sql = $pdo->prepare("DELETE FROM chat_2 WHERE message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":message_id" => $_POST['id'],
                    ":to_id" => $_POST['list_id']
                ));
                $sql = $pdo->prepare("DELETE FROM chat_2 WHERE message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":message_id" => $_POST['list_id'],
                    ":to_id" => $_POST['id']
                ));

                $sql = $pdo->prepare("UPDATE chat_1 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":open1" => 2,
                    ":open2" => 0,
                    ":message_id" => $_POST['id'],
                    ":to_id" => $_POST['list_id']
                ));
                $sql = $pdo->prepare("UPDATE chat_1 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
                $sql->execute(array(
                    ":open1" => 2,
                    ":open2" => 0,
                    ":message_id" => $_POST['list_id'],
                    ":to_id" => $_POST['id']
                ));
            }
        }

        $sql = $pdo->prepare("DELETE FROM chat_room WHERE account_id = :account_id AND from_id = :from_id;");
        $sql->execute(array(
            ":account_id" => $_POST['id'],
            ":from_id" => $_POST['list_id']
        ));

        // チャットルームデータ
        $sql = $pdo->prepare("SELECT * FROM chat_room;");
        $sql->execute();
        $chat_room = $sql->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
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
                    </form>
                ";
                echo "<h1>チャットルーム一覧</h1>";
                if (sizeof($chat_room) == 0)
                    echo '<p class="font-size">一覧はありません</p>';
                else {
                    for ($i = 0; $i < sizeof($chat_room); $i++) {
                        try {
                            $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                            $sql = $pdo->prepare("SELECT * FROM accounts WHERE id = :id;");
                            $sql->execute(array(
                                ":id" => $chat_room[$i]['from_id']
                            ));
                            $Account_List = $sql->fetchAll(PDO::FETCH_ASSOC);
                            if ($chat_room[$i]['account_id'] == $_POST['id']) {
                                echo "
                                    <div class='chat_room_list'>
                                        <p>{$Account_List[0]['id_name']}</p>
                                        <div class='flex btn'>
                                            <form>
                                                <button>チャット</button>
                                            </form>
                                            <form>
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
</body>
</html>