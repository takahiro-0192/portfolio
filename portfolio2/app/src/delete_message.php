<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        if ($_POST['chat_view'] == 1) {
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
        }
    } catch(PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }
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
<body onload='document.FRM.submit();'>
<div class='main_wrapper'>
        <div>
            <?php
                echo "
                    <form name='FRM' action='./index.php' method='post'>
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
                    <div class='chat_area_wrapper'>";


                echo "</div>
                    <div class='chat_input_area_wrapper'>
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
                    </div>";

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