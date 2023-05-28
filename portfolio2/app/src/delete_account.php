<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        $sql = $pdo->prepare("DELETE FROM contact_list WHERE id = :id;");
        $sql->execute(array(
            ":id" => $_POST['id']
        ));
        $sql = $pdo->prepare("DELETE FROM contact_list WHERE list_id = :list_id;");
        $sql->execute(array(
            ":list_id" => $_POST['id']
        ));

        $sql = $pdo->prepare("DELETE FROM chat_room WHERE account_id = :account_id;");
        $sql->execute(array(
            ":account_id" => $_POST['id']
        ));
        $sql = $pdo->prepare("DELETE FROM chat_room WHERE from_id = :from_id;");
        $sql->execute(array(
            ":from_id" => $_POST['id']
        ));

        $sql = $pdo->prepare("DELETE FROM chat_1 WHERE message_id = :message_id;");
        $sql->execute(array(
            ":message_id" => $_POST['id']
        ));
        $sql = $pdo->prepare("DELETE FROM chat_1 WHERE to_id = :to_id;");
        $sql->execute(array(
            ":to_id" => $_POST['id']
        ));

        $sql = $pdo->prepare("DELETE FROM chat_2 WHERE message_id = :message_id;");
        $sql->execute(array(
            ":message_id" => $_POST['id']
        ));
        $sql = $pdo->prepare("DELETE FROM chat_2 WHERE to_id = :to_id;");
        $sql->execute(array(
            ":to_id" => $_POST['id']
        ));

        $sql = $pdo->prepare("DELETE FROM accounts WHERE id = :id;");
        $sql->execute(array(
            ":id" => $_POST['id']
        ));
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }
    unset($_POST);
    header('Location: ./index.php');
?>