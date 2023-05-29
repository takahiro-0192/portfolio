<?php
    try {
        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

        $sql = $pdo->prepare("DELETE FROM contact_list WHERE id = :id AND list_id = :list_id;");
        $sql->execute(array(
            ":id" => $_POST['id'],
            ":list_id" => $_POST['list_id']
        ));

        // 連絡先リストデータ
        $sql = $pdo->prepare("SELECT * FROM contact_list WHERE id = :id;");
        $sql->execute(array(
            ":id" => $_POST['id']
        ));
        $contact_list = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <title>友達リスト削除</title>
</head>
<body onload='document.FRM.submit();'>
    <div class='main_wrapper'>
        <?php
            echo "
                <form name='FRM' action='./index.php' method='post'>
                    <input name='login' value={$_POST['login']} type='hidden'>
                    <input name='mode' value={$_POST['mode']} type='hidden'>
                    <input name='friend_list_page' value=1 type='hidden'>
                    <input name='list_id' value={$_POST['list_id']} type='hidden'>
                    <input name='list_name' value={$_POST['list_name']} type='hidden'>
                    <input name='id' value={$_POST['id']} type='hidden'>
                    <input name='id_name' value={$_POST['id_name']} type='hidden'>
                    <input name='email' value={$_POST['email']} type='hidden'>
                    <input name='tel' value={$_POST['tel']} type='hidden'>
                </form>
            ";

            echo "<div class='contact_list'>";
            echo "<h1>連絡先リスト一覧</h1>";
            if (sizeof($contact_list) == 0)
                echo "<p>一覧はありません</p>";
            else {
                for ($i = 0; $i < sizeof($contact_list); $i++) {
                    try {
                        $pdo = new PDO("mysql:dbname=test_db;host=run-php-db;", "test", "test");

                        $sql = $pdo->prepare("SELECT * FROM accounts WHERE id = :id;");
                        $sql->execute(array(
                            ":id" => $contact_list[$i]['list_id']
                        ));
                        $Account_List = $sql->fetchAll(PDO::FETCH_ASSOC);
                        echo "
                            <div class='list'>
                                <p>{$Account_List[0]['id_name']}</p>
                                <div class='flex margin-right'>
                                    <form>
                                        <button>チャット</button>
                                    </form>
                                    <form>
                                        <button>削除</button>
                                    </form>
                                </div>
                            </div>
                        ";
                    } catch (PDOException $e) {
                        echo 'エラー:' . $e->getMessage() . '<br>';
                    }
                }
            }
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