<?php
    for ($j = 0; $j < 400; $j++) {
        $birth = rand(1960, 2023) . '年'. rand(1, 12) . '月'. rand(1, 31) . '日';
        $gender_data = ['男性', '女性'];
        $gender = $gender_data[rand(0, 1)];
        $family_name = [
            '新井', '荒木', '青木', '青山', '安藤', '秋田', '秋山', '秋元', '相川', '赤井', '石井' ,'石川', '岩田', '岩崎', '石田', '石山', '飯塚', '飯島', '飯田', '池田',
            '池上', '遠藤', '江藤', '江森', '上田', '宇野', '上野', '江口', '太田', '大江', '小倉' ,'岡田', '岡本', '大崎', '沖矢', '沖田', '奥村', '奥田', '柿沼', '角田',
            '片桐', '勝又', '加藤', '金沢', '金本', '加納', '笠井', '木下', '菊池', '北川', '北山' ,'北村', '木村', '久米', '北岡', '金子', '日下部', '楠田', '楠木', '倉田',
            '倉本', '倉沢', '栗田', '栗林', '黒澤', '黒田', '黒川', '佐藤', '佐々木', '斎藤', '佐山' ,'坂口', '坂田', '坂本', '坂井', '井上', '大島', '清水', '下田', '品川',
            '篠田', '篠崎', '篠原', '墨田', '須藤', '菅井', '菅原', '須田', '千堂', '瀬川', '瀬戸' ,'小暮', '外山', '小林', '近藤', '小峰', '田口', '田中', '多田', '高橋',
            '高山', '高垣', '滝口', '滝本', '竹田', '武井', '竹下', '谷口', '手塚', '戸川', '土屋' ,'土井', '遠山', '戸田', '戸塚', '中川', '中井', '中山', '中西', '中村',
            '西田', '西川', '西山', '二宮', '西口', '二村', '沼田', '田村', '田沼', '根本', '根岸' ,'野村', '野々村', '野木', '野口', '野田', '奥山', '原', '原田', '長谷川',
            '波多野', '花井', '羽田', '樋口', '久川', '久本', '芳賀', '布施', '深井', '深田', '深川' ,'福山', '福井', '福田', '福西', '加山', '片山', '門倉', '工藤', '橋田',
            '橋本', '浜田', '濱口', '船井', '船木', '船橋', '杉田', '杉本', '堀口', '堀江', '本田' ,'穂村', '本堂', '本木', '本山', '真田', '前田', '前川', '前沢', '牧田',
            '増田', '伊藤', '池山', '皆川', '三木', '峰', '向井', '武藤', '岸', '岸田', '小池' ,'小泉', '村井', '村山', '村田', '村上', '金城', '竹内', '内田', '内川',
            '川崎', '川村', '緒方', '大久保', '久保', '久保田', '浅井', '朝倉', '岩井', '森', '森本' ,'森川', '森山', '森田', '蓮見', '稲葉', '山田', '山崎', '山下', '山本',
            '山川', '山西', '柳', '柳田', '柳沢', '矢野', '山口', '矢沢', '結城', '吉田', '吉川' ,'吉井', '米田', '米山', '米川', '米倉', '吉澤', '深澤', '富田', '内村',
            '松井', '松山', '松平', '平野', '平井', '渡辺', '若林', '平林', '藤井', '藤倉', '藤沢', '宮川', '宮沢', '宮下', '宮島', '宮崎', '宮内', '古川', '古谷', '井口',
            '島田', '島村', '寺島', '高梨', '樅山', '松田', '松本', '神田', '内山', '木田', '鈴木', '松浦', '西浦', '植木', '植松', '吉村', '三浦', '和田', '丸山', '杉山',
            '佐野', '星野', '保科', '新田', '新山', '堀', '三井', '宮城', '栗山', '近江', '小笠原', '海老原', '関', '関口', '豊田', '新島', '塚本', '塚田', '川田', '石塚',
            '駒田', '鳥谷', '折原', '横田', '横井', '藤田', '市原', '市川','林', '岡村', '岡安', '岡部', '浜崎', '本間', '服部', '白鳥', '魚住', '吉住', '住吉', '早川',
            '小野', '小野寺', '小野塚', '鬼久保', '鬼崎', '鬼塚', '櫻井', '佐久間', '陣内', '馬場', '間宮', '内海', '川原', '黒柳', '西条', '仲間'
        ];

        $name = [
            [
                '真一', '亮太', '亮平', '雅也', '淳也', '晃一', '康平', '晃', '翔', '翔太', '翔平', '孝宏', '隆史', '修平', '修一', '博', '裕二', '優太', '隼人', '祐希',
                '裕也', '将司', '雅文', '慎也', '信介', '真司', '宏明', '裕之', '雄平', '雄一', '祐三', '涼介', '聡', '大智', '雄馬', '洋平', '陽一', '敏也', '克敏', '克哉',
                '竜太', '大貴', '昂輝', '浩二', '駿', '智樹', '智之', '純一', '哲也', '啓太', '圭佑', '敬司', '達也', '達夫', '辰徳', '敦也', '弘樹', '拓哉', '巧', '拓馬',
                '徹', '純平', '正広', '正明', '義仁', '正義', '健人', '賢治', '健吾', '健太', '健一', '文也', '修', '玲', '義明', '義雄', '貴一', '和希', '和正', '和俊',
                '太郎', '二郎', '雅彦', '誠也', '正樹', '正雄', '雄太', '拓郎', '海斗', '悠斗', '明弘', '誠', '智也', '力哉', '雅人', '竜斗', '慎吾', '篤人', '直樹', '直也',
                '努', '進', '剛志', '忠司', '博忠', '康雄', '和哉', '肇', '卓'
            ],
            [
                '沙也加', '彩夏', '夏菜', '里奈', '理恵', '里帆', '美穂', '彩', '彩乃', '紗綾', '沙菜', '真菜', '杏奈', '絵里', '絵梨花', '友紀', '結衣', '優香', '優子', '洋子',
                '友美', '智子', '智香', '薫', '香織', '真奈美', '奈美', '美奈', '景子', '涼子', '紘子', '宏美', '瞳', '恵美', '由恵', '由子', '紀香', '紀子', '文華', '文恵',
                '文子', '真美', '麻美', 'さやか', 'ひとみ', 'あやか', '明日香', '梢枝', 'あかね', '美佳', '美樹', '由実', '由紀子', '萌', 'ひかり', 'ひかる', '菜々', '菜々恵', '里美', '美里',
                '美波', '優樹菜', '友梨亜', '沙奈恵', '美由紀', '春香', '千春', '千里', '千佳', '清美', '成美', '百花', '桃子', '百合', '小百合', '澄子','茉優' , '真弓', '梓', '朱里',
                '瀬奈', '瀬里菜', '香里奈', '真里', '真理亜', '美智子', '真知子', '蘭', '純子', '京子', '亜美', '由香', '由香里', '由紀恵', '奈津美', '夏子', '亜希子', '美沙', '美咲', '美沙子',
                '穂乃果', '野乃花', '沙紀', '咲枝', '佳代' , '佳代子', '美代', '美代子', '瑞樹', '美月'
            ]
        ];

        if ($gender == '男性')
            $full_name = $family_name[rand(0, 335)] . $name[0][rand(0, 108)];
        else
            $full_name = $family_name[rand(0, 335)] . $name[1][rand(0, 109)];

        $address1 = [
            '北海道', '青森県', '山形県', '秋田県', '宮城県', '福島県', '岩手県', '栃木県', '群馬県', '茨城県', '埼玉県', '東京都', '千葉県', '神奈川県', '山梨県', '新潟県', '長野県', '静岡県', '愛知県', '岐阜県',
            '滋賀県', '富山県', '石川県', '福井県', '和歌山県', '大阪府', '奈良県', '三重県', '京都府', '兵庫県', '岡山県', '広島県', '山口県', '鳥取県', '広島県', '愛媛県', '香川県', '徳島県', '高知県', '佐賀県',
            '福岡県', '大分県', '熊本県', '宮崎県', '鹿児島県', '長崎県', '沖縄県'
        ];

        $email_domain_data = ['@yahoo.co.jp', '@gmail.com', '@icloud.com', '@aol.com', '@jcom.zaq.ne.jp'];
        $email_domain = $email_domain_data[rand(0, 4)];

        $address = $address1[rand(0, 46)];
        $address2 = '市町村';
        $password = '1234';
        $loop = rand(15, 25);
        $email = '';
        for ($i = 0; $i < $loop; $i++) {
            $email .= chr(rand(0x0061, 0x007a));
        }
        $email .= $email_domain;

        echo $birth . '<br>';
        echo $full_name . '<br>';
        echo $gender . '<br>';
        echo $email . '<br>';
        echo $password . '<br>';
        echo $address . '<br>';
        echo $address2 . '<br>';

        try {
            $pdo = new PDO('mysql:dbname=test_db;host=run-php-db', 'test', 'test');
            $sql = $pdo->prepare("INSERT INTO accounts SET date_of_Birth = ?, name = ?, gender = ?, email = ?, password = ?, address1 = ?, address2 = ?, introduction = ?;");
            $sql->bindValue(1, $birth, PDO::PARAM_STR);
            $sql->bindValue(2, $full_name, PDO::PARAM_STR);
            $sql->bindValue(3, $gender, PDO::PARAM_STR);
            $sql->bindValue(4, $email, PDO::PARAM_STR);
            $sql->bindValue(5, password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $sql->bindValue(6, $address, PDO::PARAM_STR);
            $sql->bindValue(7, $address2, PDO::PARAM_STR);
            $sql->bindValue(8, 'よろしくお願い致します。', PDO::PARAM_STR);
            $sql->execute();
        } catch (PDOException $e) {
            echo 'エラー:' . $e->getMessage() . '<br>';
            die();
        }
    }
?>