<?php
    for ($j = 0; $j < 50; $j++) {
        $loop_id_name = rand(5, 10);
        $id_name = '';
        for ($i = 0; $i < $loop_id_name; $i++) {
            $id_name .= chr(rand(0x0061, 0x007a));
        }

        $email_domain_data = ['@yahoo.co.jp', '@gmail.com', '@icloud.com', '@aol.com', '@jcom.zaq.ne.jp'];
        $email_domain = $email_domain_data[rand(0, 4)];
        $loop_email = rand(10, 35);
        $email = '';
        for ($i = 0; $i < $loop_email; $i++) {
            $email .= chr(rand(0x0061, 0x007a));
        }
        $email .= $email_domain;

        try {
            $pdo = new PDO('mysql:dbname=test_db;host=run-php-db;', 'test', 'test');

            $sql = $pdo->prepare("INSERT INTO accounts SET id_name = :id_name, email = :email, password = :password;");
            $sql->execute(array(
                ":id_name" => $id_name,
                ":email" => $email,
                ":password" => password_hash('1111', PASSWORD_DEFAULT)
            ));
        } catch (PDOException $e) {
            echo 'エラー:' . $e->getMessage() . '<br>';
            die();
        }
    }
?>