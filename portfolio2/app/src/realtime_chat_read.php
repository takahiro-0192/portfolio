<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        // アカウントデータ
        $sql = $pdo->prepare("SELECT * FROM accounts WHERE  id = :id;");
        $sql->execute(array(
            ":id" => $_POST['list_id']
        ));
        $Account_Data = $sql->fetch(PDO::FETCH_ASSOC);
        // チャットデータ1
        $sql = $pdo->prepare("SELECT * FROM chat_1 WHERE  message_id = :message_id AND to_id = :to_id;");
        $sql->execute(array(
            ":message_id" => $_POST['login_id'],
            ":to_id" => $_POST['list_id'],
        ));
        $chat1_data = $sql->fetchAll(PDO::FETCH_ASSOC);
        // チャットデータ2
        $sql = $pdo->prepare("SELECT * FROM chat_2 WHERE  message_id = :message_id AND to_id = :to_id;");
        $sql->execute(array(
            ":message_id" => $_POST['login_id'],
            ":to_id" => $_POST['list_id'],
        ));
        $chat2_data = $sql->fetchAll(PDO::FETCH_ASSOC);

        $text = ["chat_1" => $chat1_data, "chat_2" => $chat2_data, "opponent_data" => $Account_Data];
        header('Content-type: application/json');
        echo json_encode($text);
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }
?>