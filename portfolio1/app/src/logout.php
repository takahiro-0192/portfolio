<?php
    $login_status = 0;
    $email = $_POST['email'];
    try {
        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
        $sql = $pdo->prepare("UPDATE accounts SET login_status = :login_status WHERE email = :email;");
        $sql->execute(array(
            ':login_status' => $login_status,
            ':email' => $email
        ));
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
        die();
    }
    unset($_POST);
    header('Location: ./index.php');
?>