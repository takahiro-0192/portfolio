<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Community Space</title>
</head>
<body>
    <div class='bgcolor_fixed'></div>
    <div class='content-position-login'>
        <div>
            <h1>Community Space</h1>
            <p class='font-size-smart-phone'>-コミュニティー広場-</p>
            <h2>ログイン</h2>
            <div class='login_form'>
                {{ Form::open(['url' => route('database.login_check'), 'method' => 'post']) }}
                    <div class='input_margin_top'>
                        <input name='email' type='text' placeholder='メールアドレス'><br>
                        @if ($email_MISS == 1)
                            <div class='error_message_position_login'><p class='error_message_login'>メールアドレスが未入力です</p></div>
                        @elseif ($email_MISS == 2)
                            <div class='error_message_position_login'><p class='error_message_login'>メールアドレスが存在しません</p></div>
                        @elseif ($email_MISS == 3)
                            <div class='error_message_position_login'><p class='error_message_login'>メールアドレスは30字以内入力してください</p></div>
                        @endif
                        <input name='password' type='password' placeholder='パスワード'>
                            @if ($password_MISS == 1)
                            <div class='error_message_position_login'><p class='error_message_login'>パスワードが未入力です</p></div>
                        @elseif ($password_MISS == 2)
                            <div class='error_message_position_login'><p class='error_message_login'>パスワードが正しくありません</p></div>
                        @elseif ($password_MISS == 3)
                            <div class='error_message_position_login'><p class='error_message_login'>パスワードは255字以内入力してください</p></div>
                        @endif
                    </div>
                    <div class='btn_center'>
                        <div class='btn_position_login'>
                        {{ Form::close() }}
                        {{ Form::open(['url' => route('account.create'), 'method' => 'post']) }}
                        <button type='submit' class='btn_to_create'>アカウント新規作成</button>
                        {{ Form::close() }}
                        <button type='submit' class='btn_login'>ログイン</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>