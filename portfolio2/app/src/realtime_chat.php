<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        // チャットデータ1
        $sql = $pdo->prepare("SELECT * FROM chat_1 WHERE open = :open AND message_id = :message_id AND to_id = :to_id ORDER BY send_date DESC;");
        $sql->execute(array(
            ":open" => 0,
            ":message_id" => $_POST['list_id'],
            ":to_id" => $_POST['login_id'],
        ));
        $chat_data = $sql->fetchAll(PDO::FETCH_ASSOC);

        $sql = $pdo->prepare("UPDATE chat_1 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
        $sql->execute(array(
            ":open1" => 1,
            ":open2" => 0,
            ":message_id" => $_POST['list_id'],
            ":to_id" => $_POST['login_id']
        ));
        $sql = $pdo->prepare("UPDATE chat_2 SET open = :open1 WHERE open = :open2 AND message_id = :message_id AND to_id = :to_id;");
        $sql->execute(array(
            ":open1" => 1,
            ":open2" => 0,
            ":message_id" => $_POST['list_id'],
            ":to_id" => $_POST['login_id']
        ));

        if (sizeof($chat_data) == 0 && sizeof($chat_data) == $_POST['now_chat_size']) {
            $text = ["flg" => 0, "size" => sizeof($chat_data)];
            header('Content-type: application/json');
            echo json_encode($text);
        } else {
            $text = ["flg" => 1, "size" => sizeof($chat_data), "message" => $chat_data[0]['message'], "time" => $chat_data[0]['send_date']];
            header('Content-type: application/json');
            echo json_encode($text);
        }
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }
?>