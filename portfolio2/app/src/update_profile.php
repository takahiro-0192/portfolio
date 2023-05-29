<?php
    $error = 0;
    $id_name = $_POST['id_name'];
    $tel = $_POST['tel'];
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        if (empty($_POST['new_id_name']) && empty($_POST['new_tel']))
            $error = 1;
        else if (empty($_POST['new_tel']) && mb_strlen($_POST['new_id_name']) > 10)
            $error = 2;
        else if (empty($_POST['new_id_name']) && preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $_POST['new_tel']) != 1)
            $error = 3;
        else if (!empty($_POST['new_id_name']) && empty($_POST['new_tel']) && mb_strlen($_POST['new_id_name']) <= 10) {
            $error = 4;
            $id_name = $_POST['new_id_name'];
            $sql = $pdo->prepare("UPDATE accounts SET id_name = :id_name WHERE id = :id;");
            $sql->execute(array(
                ":id_name" => $_POST['new_id_name'],
                ":id" => $_POST['id']
            ));
        } else if (empty($_POST['new_id_name']) && preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $_POST['new_tel']) == 1) {
            $sql = $pdo->prepare("SELECT * FROM accounts WHERE tel = :tel;");
            $sql->execute(array(
                ":tel" => $_POST['new_tel']
            ));
            $tel_list = $sql->fetchAll(PDO::FETCH_ASSOC);
            if (sizeof($tel_list) == 0) {
                $error = 5;
                $tel = $_POST['new_tel'];
                $sql = $pdo->prepare("UPDATE accounts SET tel = :tel WHERE id = :id;");
                $sql->execute(array(
                    ":tel" => $_POST['new_tel'],
                    ":id" => $_POST['id']
                ));
            } else {
                $error = 6;
            }
        } else if (!empty($_POST['new_id_name']) && !empty($_POST['new_tel'])) {
            if (mb_strlen($_POST['new_id_name']) <= 10 && preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $_POST['new_tel']) == 1) {
                $sql = $pdo->prepare("SELECT * FROM accounts WHERE tel = :tel;");
                $sql->execute(array(
                    ":tel" => $_POST['new_tel']
                ));
                $tel_list = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (sizeof($tel_list) == 0) {
                    $error = 7;

                    $id_name = $_POST['new_id_name'];
                    $sql = $pdo->prepare("UPDATE accounts SET id_name = :id_name WHERE id = :id;");
                    $sql->execute(array(
                        ":id_name" => $_POST['new_id_name'],
                        ":id" => $_POST['id']
                    ));

                    $tel = $_POST['new_tel'];
                    $sql = $pdo->prepare("UPDATE accounts SET tel = :tel WHERE id = :id;");
                    $sql->execute(array(
                        ":tel" => $_POST['new_tel'],
                        ":id" => $_POST['id']
                    ));
                } else {
                    $error = 6;
                }
            } else if (mb_strlen($_POST['new_id_name']) > 10)
                $error = 2;
            else if (preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $_POST['new_tel']) != 1)
                $error = 3;
        }
    } catch (PDOException $e) {
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
    <title>登録情報更新</title>
</head>
<body onload='document.FRM.submit();'>
    <div class='main_wrapper'>
        <?php
            echo "
                <form name='FRM' action='./index.php' method='post'>
                    <input name='login' value=1 type='hidden'>
                    <input name='mode' value=3 type='hidden'>
                    <input name='edit_mode' value=2 type='hidden'>
                    <input name='id' value={$_POST['id']} type='hidden'>
                    <input name='mode' value={$_POST['mode']} type='hidden'>
                    <input name='id_name' value={$id_name} type='hidden'>
                    <input name='email' value={$_POST['email']} type='hidden'>
                    <input name='tel' value={$tel} type='hidden'>
                    <input name='error' value={$error} type='hidden'>
                </form>";

            echo '
                <div class="position_center edit_profile">
                    <div>
                        <h1>登録情報変更</h1>
                        <div class="border">
                            <div class="flex_pc margin">';
                                if (!empty($_POST['error_password']) && ($_POST['error_password'] == 1 || $_POST['error_password'] == 5)) {
                                    $class = 'margin-left-1';
                                    $class_2 = 'margin-left-3';
                                } else {
                                    $class = 'margin-left-2';
                                    $class_2 = 'margin-left-3';
                                }
                            echo "<form class='{$class} margin-right-1' action='./update_profile.php' method='post'>
                                    <input name='mode' value={$_POST['mode']} type='hidden'>
                                    <input name='id' value={$_POST['id']} type='hidden'>
                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                    <input name='email' value={$_POST['email']} type='hidden'>
                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                    <input name='new_id_name' value='{$_POST['new_id_name']}' type='text' placeholder='ID名:10字以内'><br>
                                    <input name='new_tel' value='{$_POST['new_tel']}' type='text' placeholder='電話番号:09012345678'><br>
                                    <button>変更</button>
                                </form>
                                <form class='{$class_2} margin-top margin-right-2' action='./update_password.php' method='post'>
                                    <input name='mode' value={$_POST['mode']} type='hidden'>
                                    <input name='id' value={$_POST['id']} type='hidden'>
                                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                                    <input name='email' value={$_POST['email']} type='hidden'>
                                    <input name='tel' value={$_POST['tel']} type='hidden'>
                                    <input name='new_password' type='password' placeholder='パスワード:4〜255字(半角文字)'><br>
                                    <input name='new_password_retype' type='password' placeholder='パスワード確認'><br>
                                    <button>変更</button>
                                </form>";
                        echo "</div>";
                    echo "</div>";
                    echo "
                    <form action='./index.php' method='post'>
                        <input name='mode' value=3 type='hidden'>
                        <input name='edit_mode' value=0 type='hidden'>
                        <input name='login' value=1 type='hidden'>
                        <input name='id' value={$_POST['id']} type='hidden'>
                        <input name='id_name' value={$_POST['id_name']} type='hidden'>
                        <input name='email' value={$_POST['email']} type='hidden'>
                        <input name='tel' value={$_POST['tel']} type='hidden'>
                        <button>戻る</button>
                    </form>";
                echo "</div>";
            echo "</div>";

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
</body>
</html>