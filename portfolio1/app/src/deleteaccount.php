<?php
    $login_status = 0;
    $email = $_POST['email'];
    $id = $_POST['id'];
    $gender = $_POST['gender'];

    $dirpass = "./images/{$id}";
    $dir = glob($dirpass . '/*');
    foreach ($dir as $file)
        unlink($file);
    rmdir($dirpass);
    try {
        $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
        $sql = $pdo->prepare("SELECT * FROM chat WHERE message_id = :id;");
        $sql->execute(array(':id' => $id));
        $data = $sql->fetch(PDO::FETCH_ASSOC);
        if ($data != NULL) {
            $sql = $pdo->prepare("DELETE FROM chat WHERE message_id = :id;");
            $sql->execute(array(':id' => $id));
        }
        $sql = $pdo->prepare("DELETE FROM accounts WHERE email = :email;");
        $sql->execute(array(':email' => $email));
        $text = 'アカウントを削除しました。<br>ご利用ありがとうございました。';
    } catch (PDOException $e) {
        echo 'エラー:' . $e->getMessage() . '<br>';
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>☕️ Community Cafe</title>
</head>
<body>
    <div class="index_wrapper <?php if ($_POST['gender'] == '男性') echo 'bgcolor_man'; else echo 'bgcolor_woman'; ?>" style="display: flex; justify-content: center; align-items: center;">
        <div>
            <p class="deleted_form_wrapper"><?php echo $text; ?></p>
            <form action="./login.php" method="post">
                <div class="deleted_button_margin"><button class="<?php if ($gender == '男性') echo "deleted_to_login_man"; else echo "deleted_to_login_woman"; ?>" type='submit'>ログイン画面へ</button></div>
            </form>
        </div>
    </div>
</body>
</html>
