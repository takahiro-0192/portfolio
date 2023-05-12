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
    <div class='content-position-create'>
        <div>
            <div class='title-text-align-create'>
                <h1>Community Space</h1>
                <p class='font-size-smart-phone'>-コミュニティー広場-</p>
                <h2>アカウント作成</h2>
            </div>
            <div class='create_form'>
                <form action={{ route('database.create_check') }} method='post'>
                    @csrf
                    <div class='input_margin_top'>
                        <label>生年月日</label><br class='display_br'>
                        <select <?php if ($select_year == 1) echo "style='color: red;'"; ?> name='year'><br class='display_br'>
                            <option>選択してください</option>
                            @for ($i = 1960; $i <= date("Y") -18; $i++)
                            <option>{{ $i }}</option>
                            @endfor
                        </select>
                        <span>年</span><br class='display_br'>
                        <select <?php if ($select_month == 1) echo "style='color: red;'"; ?> name='month'>
                            <option>選択してください</option>
                            @for ($i = 1; $i <= 12; $i++)
                            <option>{{ $i }}</option>
                            @endfor
                        </select>
                        <span>月</span><br class='display_br'>
                        <select <?php if ($select_day == 1) echo "style='color: red;'"; ?> name='day'>
                            <option>選択してください</option>
                            @for ($i = 1; $i <= 31; $i++)
                            <option>{{ $i }}</option>
                            @endfor
                        </select>
                        <span>日</span><br class='display_br'>
                        <br>
                        <div class='position_center'>
                            <div>
                                <label>性別</label><br class='display_br'>
                                <select <?php if ($select_gender == 1) echo "style='color: red;'"; ?>  name='gender'>
                                    <option>選択してください</option>
                                    <option>男性</option>
                                    <option>女性</option>
                                </select><br>
                                <label>
                                    @if ($name_MISS == 1)
                                        <span class='error_message_create'>未入力です</span><br class='display_br'>
                                    @elseif ($name_MISS == 2)
                                        <span class='error_message_create'>10字以内入力してください</span><br class='display_br'>
                                    @endif
                                    名前
                                </label><br class='display_br'>
                                <input name='name' type='text' placeholder='名前'><br>
                                <label>
                                    @if ($email_MISS == 1)
                                        <span class='error_message_create'>未入力です</span><br class='display_br'>
                                    @elseif ($email_MISS == 2)
                                        <span class='error_message_create'>30字以内入力してください</span><br class='display_br'>
                                    @elseif ($email_MISS == 3)
                                        <span class='error_message_create'>登録されております</span><br class='display_br'>
                                    @endif
                                    メールアドレス
                                </label><br class='display_br'>
                                <input name='email' type='text' placeholder='メールアドレス'><br>
                                <label>
                                    @if ($password_MISS == 1)
                                        <span class='error_message_create'>未入力です</span><br class='display_br'>
                                    @elseif ($password_MISS == 2)
                                        <span class='error_message_create'>255字以内入力してください</span><br class='display_br'>
                                    @elseif ($password_MISS == 3)
                                        <span class='error_message_create'>4字以上入力してください</span><br class='display_br'>
                                    @elseif ($password_MISS == 4)
                                        <span class='error_message_create'>確認用と異なっております</span><br class='display_br'>
                                    @endif
                                    パスワード
                                </label><br class='display_br'>
                                <input name='password' type='password' placeholder='パスワード'><br>
                                <label>
                                    @if ($password_retype_MISS == 1)
                                        <span class='error_message_create'>未入力です</span><br class='display_br'>
                                    @elseif ($password_retype_MISS == 2)
                                        <span class='error_message_create'>255字以内入力してください</span><br class='display_br'>
                                    @elseif ($password_retype_MISS == 3)
                                        <span class='error_message_create'>4字以上入力してください</span><br class='display_br'>
                                    @endif
                                    パスワード確認</label><br class='display_br'>
                                <input name='password_retype' type='password' placeholder='パスワード(確認)'><br>
                            </div>
                        </div>
                    </div>
                    <div class='btn_position_create'>
                    </form>
                    <form action={{route('account.login')}} method='post'>
                        @csrf
                        <button class='btn_back'>戻る</button>
                    </form>
                    <button class='btn_login'>登録</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>