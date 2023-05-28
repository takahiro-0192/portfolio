<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE id = :id;");
        $sql->execute(array(
            ":login_status" => 0,
            ":id" => $_POST['id']
        ));
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
    }

    unset($_POST);
    header('Location: ./index.php');
?>