<?php
    $login_id_json = json_encode($login_id);
    $view_mode_json = json_encode($view_mode);
    $chat_view_json = 0;
    $search_view_json = 0;
    $list_view_json = 0;
    $friend_request_view_json = 0;
    $list_gender_json = 0;
    $list_upload_image_name_json = 0;
    $list_id_json = 0;
    $list_get_counter_json = 0;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Community Space</title>
</head>
<body>
    <div class="<?php if ($login_gender == '男性') echo 'bgcolor_man'; else echo 'bgcolor_woman'; ?>"></div>
    <div class="main_contents">
        <div class="main_contents_position">
            @switch ($view_mode)
                @case (0)
                    <div class="margin_pc">
                        <h1>つぶやく</h1>
                        <div class="tweet_content">
                            @if ($tweet_MISS == 1)
                                <p style="color: red;">未入力です</p>
                            @elseif ($tweet_MISS == 2)
                                <p style="color: red;">1000字以内入力してください</p>
                            @elseif ($tweet_MISS == 3)
                                <p style="color: red;">つぶやきが投稿されました</p>
                            @endif
                            <form action={{route('database.regist_tweet')}} method="post">
                                @csrf
                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                <input name="login" value="1" type="hidden">
                                <input name="view_mode" value="0" type="hidden">
                                <textarea name="tweet" placeholder="1000字以内"></textarea><br>
                                <button class="<?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">投稿</button>
                            </form>
                            <div class="tweet_box_wrapper">
                                <div>
                                <?php $tweet_counter = 0; ?>
                                @for ($i = 0, $j = 0; $i < sizeof($Tweet_Data); $i++)
                                    @if ($Tweet_Data[$i]['account_id'] == $login_id)
                                        <div class="regist_date_tweet">投稿日時 : {{$Tweet_Data[$i]['created_at']}}
                                            @if ($j == 0)
                                                <form class="btn_margin" action={{route('database.delete_tweet')}} method="post">
                                                    @csrf
                                                    <input name="tweet_delete_all" value=1 type="hidden">
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="0" type="hidden">
                                                    <button class="btn_delete_all <?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">全て削除する</button>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="">
                                            <div class="mumble_box">
                                                <div class="padding">
                                                    <?php echo nl2br($Tweet_Data[$i]['tweet']); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <form action={{route('database.delete_tweet')}} method="post">
                                            @csrf
                                            <input name="tweet_id" value="{{$Tweet_Data[$i]['id']}}" type="hidden">
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="0" type="hidden">
                                            <button class="<?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman';?>">削除</button>
                                            <span style="display: none;">{{$j++}}</span>
                                        </form>
                                        <?php $tweet_counter++; ?>
                                    @endif
                                @endfor
                                @if ($tweet_counter == 0)
                                    <p>投稿はありません</p>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @break
                @case (1)
                    <div class="margin_pc">
                        @switch ($chat_view)
                            @case (0)
                                <h1>履歴</h1>
                                <div class="position_center">
                                    <div class="chat_history_content_wrapper">
                                        <?php
                                            $chat_history_counter = 0;
                                        ?>
                                        <div id="chat_not_open"></div>
                                        @if (sizeof($Memory_Chat_Data) != 0)
                                            <?php
                                                for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++) {
                                                    $chat_counter_total_detail_1[$i] = 0;
                                                    $chat_counter_total_detail_2[$i] = 0;
                                                }
                                            ?>
                                            @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                                @if ($Memory_Chat_Data[$i]['account_id'] == $login_id)
                                                    <?php
                                                        $list_id = $Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['id'];
                                                        $list_id_json = json_encode($list_id);
                                                    ?>
                                                    <div class="chat_history_list_wrapper position_between">
                                                        <div class="font-size">
                                                            @if ($Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['upload_image_name'] == NULL)
                                                                @if ($Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['gender'] == '男性')
                                                                    <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                                                                @else
                                                                    <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                @endif
                                                            @else
                                                                <img class="icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['id']}/" . $Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['upload_image_name']); ?>">
                                                            @endif
                                                            <?php
                                                                for ($j = 0; $j < sizeof($Chat_Data_1); $j++) {
                                                                    if ($Chat_Data_1[$j]['open'] == NULL && $Chat_Data_1[$j]['account_id'] == $Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['id'] && $Chat_Data_1[$j]['to_account_id'] == $login_id)
                                                                        $chat_counter_total_detail_1[$i]++;
                                                                }
                                                                for ($j = 0; $j < sizeof($Chat_Data_2); $j++) {
                                                                    if ($Chat_Data_1[$j]['open'] == NULL && $Chat_Data_1[$j]['account_id'] == $Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['id'] && $Chat_Data_1[$j]['to_account_id'] == $login_id)
                                                                        $chat_counter_total_detail_1[$i]++;
                                                                }
                                                            ?>
                                                            {{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['name']}} <?php if ($chat_counter_total_detail_1[$i] != 0) echo '+' . $chat_counter_total_detail_1[$i]; ?>
                                                        </div>
                                                        <form action={{route('account.index')}} method="post">
                                                            @csrf
                                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                            <input name="login" value="1" type="hidden">
                                                            <input name="view_mode" value="1" type="hidden">
                                                            <input name="chat_view" value="1" type="hidden">
                                                            <input name="page" value="1" type="hidden">
                                                            <input name="list_birth" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['birth_day']}}" type="hidden">
                                                            <input name="list_id" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['id']}}" type="hidden">
                                                            <input name="list_name" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['name']}}" type="hidden">
                                                            <input name="list_gender" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['gender']}}" type="hidden">
                                                            <input name="list_email" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['email']}}" type="hidden">
                                                            <input name="list_password" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['password']}}" type="hidden">
                                                            <input name="list_tel" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['tel']}}" type="hidden">
                                                            <input name="list_address1" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['address1']}}" type="hidden">
                                                            <input name="list_address2" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['address2']}}" type="hidden">
                                                            <input name="list_introduction" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['introduction']}}" type="hidden">
                                                            <input name="list_upload_image_name" value="{{$Account_Data[$Memory_Chat_Data[$i]['from_account_id'] - 1]['upload_image_name']}}" type="hidden">
                                                            <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">チャット</button>
                                                        </form>
                                                    </div>
                                                    <?php $chat_history_counter++; ?>
                                                @elseif ($Memory_Chat_Data[$i]['from_account_id'] == $login_id)
                                                    <?php
                                                        $list_id = $Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['id'];
                                                        $list_id_json = json_encode($list_id);
                                                    ?>
                                                    <div class="chat_history_list_wrapper position_between">
                                                        <div class="font-size">
                                                            @if ($Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                @if ($Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['gender'] == '男性')
                                                                    <img src={{ asset('images/icon_man.png') }}>
                                                                @else
                                                                    <img src={{ asset('images/icon_woman.png') }}>
                                                                @endif
                                                            @else
                                                                <img class="icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                            @endif
                                                            <?php
                                                                for ($j = 0; $j < sizeof($Chat_Data_1); $j++) {
                                                                    if ($Chat_Data_1[$j]['open'] == NULL && $Chat_Data_1[$j]['account_id'] == $Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['id'] && $Chat_Data_1[$j]['to_account_id'] == $login_id)
                                                                        $chat_counter_total_detail_2[$i]++;
                                                                }
                                                                for ($j = 0; $j < sizeof($Chat_Data_2); $j++) {
                                                                    if ($Chat_Data_1[$j]['open'] == NULL && $Chat_Data_1[$j]['account_id'] == $Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['id'] && $Chat_Data_1[$j]['to_account_id'] == $login_id)
                                                                        $chat_counter_total_detail_2[$i]++;
                                                                }
                                                            ?>
                                                            {{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['name']}} <?php if ($chat_counter_total_detail_2[$i] != 0) echo '+' . $chat_counter_total_detail_2[$i]; ?>
                                                        </div>
                                                        <form action={{route('account.index')}} method="post">
                                                            @csrf
                                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                            <input name="login" value="1" type="hidden">
                                                            <input name="view_mode" value="1" type="hidden">
                                                            <input name="chat_view" value="1" type="hidden">
                                                            <input name="page" value="1" type="hidden">
                                                            <input name="list_birth" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['birth_day']}}" type="hidden">
                                                            <input name="list_id" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['id']}}" type="hidden">
                                                            <input name="list_name" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['name']}}" type="hidden">
                                                            <input name="list_gender" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['gender']}}" type="hidden">
                                                            <input name="list_email" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['email']}}" type="hidden">
                                                            <input name="list_password" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['password']}}" type="hidden">
                                                            <input name="list_tel" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['tel']}}" type="hidden">
                                                            <input name="list_address1" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['address1']}}" type="hidden">
                                                            <input name="list_address2" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['address2']}}" type="hidden">
                                                            <input name="list_introduction" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['introduction']}}" type="hidden">
                                                            <input name="list_upload_image_name" value="{{$Account_Data[$Memory_Chat_Data[$i]['account_id'] - 1]['upload_image_name']}}" type="hidden">
                                                            <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">チャット</button>
                                                        </form>
                                                    </div>
                                                    <?php $chat_history_counter++; ?>
                                                @endif
                                            @endfor
                                        @endif
                                    </div>
                                    @if ($chat_history_counter == 0)
                                        <div class="font-size">チャット履歴はありません</div>
                                    @else
                                    @endif
                                </div>
                                @break
                            @case (1)
                                <?php
                                    $chat_view_json = json_encode($chat_view);
                                    $list_id_json = json_encode($list_id);
                                    $list_gender_json = json_encode($list_gender);
                                    $list_upload_image_name_json = json_encode($list_upload_image_name);
                                ?>
                                <div id="chat" class="margin-pc">
                                    <h1>{{$list_name}}さんとチャット</h1>
                                    <div class="position_center">
                                        <?php
                                            $memory_counter = 0;
                                            $chat_counter = 0;
                                            $receive_chat_counter = 0;
                                        ?>
                                        @if (sizeof($Memory_Chat_Data) != 0)
                                            @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                                @if ($list_id == $Memory_Chat_Data[$i]['account_id'] || $list_id == $Memory_Chat_Data[$i]['from_account_id'])
                                                    <?php $memory_counter++; ?>
                                                @endif
                                            @endfor
                                            @if ($memory_counter != 0)
                                                <div class="chat">
                                            @else
                                                <div class="chat_null">
                                            @endif
                                        @else
                                            <div class="chat_null">
                                        @endif
                                            <div class="chat_view_area">
                                                <div>
                                                    @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                                        @if ($Memory_Chat_Data[$i]['account_id'] == $login_id && $Memory_Chat_Data[$i]['from_account_id'] == $list_id)
                                                            <?php $login_id_flg = 0 ?>
                                                        @elseif($Memory_Chat_Data[$i]['account_id'] == $list_id && $Memory_Chat_Data[$i]['from_account_id'] == $login_id)
                                                            <?php $login_id_flg = 1 ?>
                                                        @endif
                                                    @endfor
                                                    @if ($login_id_flg == 0)
                                                        @for ($i = 0; $i < sizeof($Chat_Data_1); $i++)
                                                            @if ($Chat_Data_1[$i]['account_id'] == $login_id && $Chat_Data_1[$i]['to_account_id'] == $list_id)
                                                                <div class="chat_icon position_right">
                                                                    <div class="position_bottom">
                                                                        <div class="font-size-time">
                                                                            @if ($Chat_Data_1[$i]['open'] == NULL)
                                                                                <div class="not_open">未読</div>
                                                                            @else
                                                                                <div>既読</div>
                                                                            @endif
                                                                            <div class="margin-right">
                                                                                <?php
                                                                                    echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat_style_1">
                                                                        <div class="margin">
                                                                            <?php
                                                                                echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                        @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                            <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                        @else
                                                                            <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                        @endif
                                                                    @else
                                                                        <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                    @endif
                                                                </div>
                                                                <?php $chat_counter++; ?>
                                                            @elseif ($Chat_Data_1[$i]['to_account_id'] == $login_id && $Chat_Data_1[$i]['account_id'] == $list_id)
                                                                <div class="chat_icon position_left">
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                        @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                            <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                        @else
                                                                            <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                        @endif
                                                                    @else
                                                                        <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                    @endif
                                                                    <div class="chat_style_2">
                                                                        <div class="margin">
                                                                            <?php
                                                                                echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="position_bottom">
                                                                        <div class="font-size-time margin-left">
                                                                            <?php
                                                                                echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php $chat_counter++; ?>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < sizeof($Chat_Data_2); $i++)
                                                            @if ($Chat_Data_2[$i]['account_id'] == $login_id && $Chat_Data_2[$i]['to_account_id'] == $list_id)
                                                                <div class="chat_icon position_right">
                                                                    <div class="position_bottom">
                                                                        <div class="font-size-time">
                                                                            @if ($Chat_Data_2[$i]['open'] == NULL)
                                                                                <div class="not_open">未読</div>
                                                                            @else
                                                                                <div>既読</div>
                                                                            @endif
                                                                            <div class="margin-right">
                                                                                <?php
                                                                                    echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="chat_style_1">
                                                                        <div class="margin">
                                                                            <?php
                                                                                echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                        @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                            <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                        @else
                                                                            <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                        @endif
                                                                    @else
                                                                        <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                    @endif
                                                                </div>
                                                                <?php $chat_counter++; ?>
                                                            @elseif ($Chat_Data_2[$i]['to_account_id'] == $login_id && $Chat_Data_2[$i]['account_id'] == $list_id)
                                                                <div class="chat_icon position_left">
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                        @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                            <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                        @else
                                                                            <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                        @endif
                                                                    @else
                                                                        <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                    @endif
                                                                    <div class="chat_style_2">
                                                                        <div class="margin">
                                                                            <?php
                                                                                echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="position_bottom">
                                                                        <div class="font-size-time margin-left">
                                                                            <?php
                                                                                echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php $chat_counter++; ?>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                    <div id="chat_list"></div>
                                                    @if ($memory_counter == 0)
                                                        <div class="font-size">チャットはありません</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="<?php if ($login_gender == '男性') echo 'background-color: skyblue;'; else echo 'background-color: pink;'; ?>" class="chat_box_wrapper">
                                                <form action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="1" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="chat_view" value="0" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                                </form>
                                                <form name="ttt" action={{route('database.send_message')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="1" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="chat_view" value="1" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <textarea style="<?php if ($chat_MISS != NULL) echo 'color: red;'; ?>" name="message" class="message_box"><?php if ($chat_MISS == 1) echo '未入力です'; if ($chat_MISS == 2) echo '3000字以内入力してください'; ?></textarea>
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">送信</button>
                                                </form>
                                                <form class='btn_clear' action={{route('database.clear_message')}} method="post">
                                                    @csrf
                                                    @if ($login_id_flg == 0)
                                                        <?php $flg = 0 ?>
                                                    @else
                                                        <?php $flg = 1 ?>
                                                    @endif
                                                    <input name="flg" value="{{$flg}}" type="hidden">
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="1" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="chat_view" value="1" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button class='margin' style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">クリア</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                    @break
                @case (2)
                    <div class="margin_pc">
                        <?php $search_view_json = json_encode($search_view); ?>
                        @switch ($search_view)
                            @case (0)
                                <h1>友達検索</h1>
                                <div class="search_friend">
                                    <form action={{route('database.search_account')}} method="post">
                                        @csrf
                                        <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                        <input name="login_id" value="{{$login_id}}" type="hidden">
                                        <input name="login_name" value="{{$login_name}}" type="hidden">
                                        <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                        <input name="login_email" value="{{$login_email}}" type="hidden">
                                        <input name="login_password" value="{{$login_password}}" type="hidden">
                                        <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                        <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                        <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                        <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                        <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                        <input name="login" value="1" type="hidden">
                                        <input name="view_mode" value="2" type="hidden">
                                        <input name="search_view" value="0" type="hidden">
                                        <input name="page" value="1" type="hidden">
                                        <div class="position_center">
                                            <div class="flex">
                                                <div class="display_none_phone">
                                                    <div class="input_side_icon" style="background-color: <?php if ($login_gender == '男性') echo '#5090c0'; else echo 'palevioletred'; ?>;">
                                                        <p class="margin">🔍</p>
                                                    </div>
                                                </div>
                                                <input name="search" placeholder="検索:名前・地域・性別">
                                                <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>"><p>検索</p></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="search_list_view">
                                    @for ($i = ($_POST['page'] * 80) - 80; $i < $_POST['page'] * 80; $i++)
                                        @if ($i < sizeof($Account_Data))
                                            <div style="<?php if ($Account_Data[$i]['gender'] == '男性') echo 'background-color: #b0e5ff; border-color: #b0e5ff;'; else echo 'background-color: #ffe0e0; border-color: #ffe0e0;'; ?>" class="search_list">
                                                <div class="position_center">
                                                    <div>
                                                        @if ($Account_Data[$i]['upload_image_name'] == NULL)
                                                            @if ($Account_Data[$i]['gender'] == '男性')
                                                                <img src={{ asset('images/icon_man.png') }}>
                                                            @else
                                                                <img src={{ asset('images/icon_woman.png') }}>
                                                            @endif
                                                        @else
                                                            <img class="icon_size" src="<?php echo asset("storage/images/{$Account_Data[$i]['id']}/" . $Account_Data[$i]['upload_image_name']); ?>">
                                                        @endif
                                                        <p class="list_name">{{$Account_Data[$i]['name']}}</p>
                                                        <p class="list_gender">{{$Account_Data[$i]['gender']}}</p>
                                                        <div class="list_button_position">
                                                            <div>
                                                                @if ($Account_Data[$i]['id'] != $login_id)
                                                                    <?php $check_counter = 0; ?>
                                                                    @for ($j = 0; $j < sizeof($Friend_Data); $j++)
                                                                        @if (($Account_Data[$i]['id'] == $Friend_Data[$j]['account_id'] || $Account_Data[$i]['id'] == $Friend_Data[$j]['account_friend_id']) &&
                                                                        ($login_id == $Friend_Data[$j]['account_id'] || $login_id == $Friend_Data[$j]['account_friend_id']))
                                                                            <?php $check_counter++; ?>
                                                                        @endif
                                                                    @endfor
                                                                    @if ($check_counter == 0)
                                                                        <form action={{route('database.send_friend_request')}} method="post">
                                                                            @csrf
                                                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                            <input name="login" value="1" type="hidden">
                                                                            <input name="view_mode" value="2" type="hidden">
                                                                            <input name="search_view" value="1" type="hidden">
                                                                            <input name="page" value="1" type="hidden">
                                                                            <input name="list_birth" value="{{$Account_Data[$i]['birth_day']}}" type="hidden">
                                                                            <input name="list_id" value="{{$Account_Data[$i]['id']}}" type="hidden">
                                                                            <input name="list_name" value="{{$Account_Data[$i]['name']}}" type="hidden">
                                                                            <input name="list_gender" value="{{$Account_Data[$i]['gender']}}" type="hidden">
                                                                            <input name="list_email" value="{{$Account_Data[$i]['email']}}" type="hidden">
                                                                            <input name="list_password" value="{{$Account_Data[$i]['password']}}" type="hidden">
                                                                            <input name="list_tel" value="{{$Account_Data[$i]['tel']}}" type="hidden">
                                                                            <input name="list_address1" value="{{$Account_Data[$i]['address1']}}" type="hidden">
                                                                            <input name="list_address2" value="{{$Account_Data[$i]['address2']}}" type="hidden">
                                                                            <input name="list_introduction" value="{{$Account_Data[$i]['introduction']}}" type="hidden">
                                                                            <input name="list_upload_image_name" value="{{$Account_Data[$i]['upload_image_name']}}" type="hidden">
                                                                            <button style="<?php if ($Account_Data[$i]['gender'] == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>" name="req_friend">友達申請</button>
                                                                        </form>
                                                                    @endif
                                                                @endif
                                                                <form action={{route('account.index')}} method="post">
                                                                    @csrf
                                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                    <input name="login" value="1" type="hidden">
                                                                    <input name="view_mode" value="2" type="hidden">
                                                                    <input name="page" value="1" type="hidden">
                                                                    <input name="search_view" value="2" type="hidden">
                                                                    <input name="list_birth" value="{{$Account_Data[$i]['birth_day']}}" type="hidden">
                                                                    <input name="list_id" value="{{$Account_Data[$i]['id']}}" type="hidden">
                                                                    <input name="list_name" value="{{$Account_Data[$i]['name']}}" type="hidden">
                                                                    <input name="list_gender" value="{{$Account_Data[$i]['gender']}}" type="hidden">
                                                                    <input name="list_email" value="{{$Account_Data[$i]['email']}}" type="hidden">
                                                                    <input name="list_password" value="{{$Account_Data[$i]['password']}}" type="hidden">
                                                                    <input name="list_tel" value="{{$Account_Data[$i]['tel']}}" type="hidden">
                                                                    <input name="list_address1" value="{{$Account_Data[$i]['address1']}}" type="hidden">
                                                                    <input name="list_address2" value="{{$Account_Data[$i]['address2']}}" type="hidden">
                                                                    <input name="list_introduction" value="{{$Account_Data[$i]['introduction']}}" type="hidden">
                                                                    <input name="list_upload_image_name" value="{{$Account_Data[$i]['upload_image_name']}}" type="hidden">
                                                                    <button style="<?php if ($Account_Data[$i]['gender'] == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>" name="detail_profile">プロフィール詳細</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                                <div class="search_list_button_page_position">
                                    <div>
                                        {{ Form::open(['url' => route('database.search_account'), 'method' => 'post']) }}
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="2" type="hidden">
                                            <input name="search_view" value="0" type="hidden">
                                            <input name="search" value="{{$search_title}}" type="hidden">
                                            @php
                                                $back = $_POST['page'];
                                                if ($back > 1)
                                                    $back--;
                                            @endphp
                                            <input name="page" value="{{$back}}" type="hidden">
                                            <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>" class="">◀︎</button>
                                        {{ Form::close() }}
                                    </div>
                                    <div class="search_page_counter">{{$_POST['page']}}</div>
                                        <div>
                                            {{ Form::open(['url' => route('database.search_account'), 'method' => 'post']) }}
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="2" type="hidden">
                                                <input name="search_view" value="0" type="hidden">
                                                <input name="search" value="{{$search_title}}" type="hidden">
                                                @php
                                                    $next = $_POST['page'];
                                                    if ( ((double)sizeof($Account_Data)) / $_POST['page'] - 79 > 1)
                                                        $next++;
                                                @endphp
                                                <input name="page" value="{{$next}}" type="hidden">
                                                <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>" class="">▶︎</button>
                                            {{ Form::close() }}
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case (1)
                                <h1>{{$list_name}}さんにリクエスト送信しました。</h1>
                                <form action={{route('account.index')}} method="post">
                                    @csrf
                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                    <input name="login" value="1" type="hidden">
                                    <input name="view_mode" value="2" type="hidden">
                                    <input name="search_view" value="0" type="hidden">
                                    <input name="page" value="1" type="hidden">
                                    <input name="search" value="{{$search_title}}" type="hidden">
                                    <button class="<?php if ($login_gender == '男性') echo 'detail_btn_man'; else echo 'detail_btn_woman'; ?>">戻る</button>
                                </form>
                                @break
                            @case (2)
                                <h1>プロフィール詳細</h1>
                                <div class="position_center">
                                    <div>
                                        @if ($login_id != $list_id)
                                            <div class="search_list_btn position_center">
                                                <form action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="2" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="search_view" value="3" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">つぶやき</button>
                                                </form>
                                                <form action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="2" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="search_view" value="4" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">チャット</button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="detail_list">
                                            <div class="margin">
                                                <div>
                                                    <div class="position_center">
                                                        @if ($list_upload_image_name == NULL)
                                                            @if ($list_gender == '男性')
                                                                <img src={{ asset('images/icon_man.png') }}>
                                                            @else
                                                                <img src={{ asset('images/icon_woman.png') }}>
                                                            @endif
                                                        @else
                                                            <img class="icon_size" src="<?php echo asset("storage/images/{$list_id}/" . $list_upload_image_name); ?>">
                                                        @endif
                                                    </div>
                                                    <div>名前 : {{$list_name}}</div>
                                                    <div>性別 : {{$list_gender}}</div>
                                                    <div>誕生日 : {{$list_birth}}</div>
                                                    @if ($login_id == $list_id)
                                                        <div>メール : {{$list_email}}</div>
                                                        <div>電話番号 : {{$list_tel}}</div>
                                                    @endif
                                                    <div>居住地 : {{$list_address1}} : {{$list_address2}}</div>
                                                    <div style="text-align: center;">自己紹介</div>
                                                    <div class="introduction">
                                                        <div class="padding">
                                                            {{$list_introduction}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="2" type="hidden">
                                            <input name="search_view" value="0" type="hidden">
                                            <input name="page" value="1" type="hidden">
                                            <input name="search" value="{{$search_title}}" type="hidden">
                                            <button class="<?php if ($login_gender == '男性') echo 'detail_btn_man'; else echo 'detail_btn_woman'; ?>">戻る</button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case (3)
                                <?php $list_id_json = json_encode($list_id); ?>
                                <div class="position_center">
                                    <div class="tweet_box_wrapper_margin">
                                        <h1>{{$list_name}}さんのつぶやき</h1>
                                        <?php $tweet_counter = 0; ?>
                                        <div class="position_center">
                                            <div>
                                                <div id="tweet_list"></div>
                                                @for ($i = 0; $i < sizeof($Tweet_Data); $i++)
                                                    @if ($Tweet_Data[$i]['account_id'] == $list_id)
                                                        <div class="regist_date_tweet">投稿日時 : {{$Tweet_Data[$i]['created_at']}}</div>
                                                        <div class="mumble_box" ><div class="padding"><?php echo nl2br($Tweet_Data[$i]['tweet']); ?></div></div>
                                                        <?php $tweet_counter++; ?>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($tweet_counter == 0)
                                            <p class="font-size">投稿はありません</p>
                                        @endif
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="2" type="hidden">
                                            <input name="list_view" value="1" type="hidden">
                                            <input name="page" value="1" type="hidden">
                                            <input name="search_view" value="2" type="hidden">
                                            <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                            <input name="list_id" value="{{$list_id}}" type="hidden">
                                            <input name="list_name" value="{{$list_name}}" type="hidden">
                                            <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                            <input name="list_email" value="{{$list_email}}" type="hidden">
                                            <input name="list_password" value="{{$list_password}}" type="hidden">
                                            <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                            <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                            <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                            <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                            <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                            <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                        </form>
                                    <div>
                                </div>
                                @break
                            @case (4)
                                <?php
                                    $list_gender_json = json_encode($list_gender);
                                    $list_id_json = json_encode($list_id);
                                    $list_upload_image_name_json = json_encode($list_upload_image_name);
                                ?>
                                <h1>{{$list_name}}さんとチャット</h1>
                                <div class="position_center">
                                    <?php
                                        $memory_counter = 0;
                                        $chat_counter = 0;
                                        $receive_chat_counter = 0;
                                    ?>
                                    @if (sizeof($Memory_Chat_Data) != 0)
                                        @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                            @if (($login_id == $Memory_Chat_Data[$i]['account_id'] || $login_id == $Memory_Chat_Data[$i]['from_account_id']) &&
                                            ($list_id == $Memory_Chat_Data[$i]['account_id'] || $list_id == $Memory_Chat_Data[$i]['from_account_id']))
                                                <?php $memory_counter++; ?>
                                            @endif
                                        @endfor
                                        @if ($memory_counter != 0)
                                            <div id="chat" class="chat">
                                        @else
                                            <div class="chat_null">
                                        @endif
                                    @else
                                        <div class="chat_null">
                                    @endif
                                        <div class="chat_view_area">
                                            <div>
                                                @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                                    @if ($Memory_Chat_Data[$i]['account_id'] == $login_id && $Memory_Chat_Data[$i]['from_account_id'] == $list_id)
                                                        <?php $login_id_flg = 0 ?>
                                                    @elseif($Memory_Chat_Data[$i]['account_id'] == $list_id && $Memory_Chat_Data[$i]['from_account_id'] == $login_id)
                                                        <?php $login_id_flg = 1 ?>
                                                    @endif
                                                @endfor
                                                @if ($login_id_flg == 0)
                                                    @for ($i = 0; $i < sizeof($Chat_Data_1); $i++)
                                                        @if ($Chat_Data_1[$i]['account_id'] == $login_id && $Chat_Data_1[$i]['to_account_id'] == $list_id)
                                                            <div class="chat_icon position_right">
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time">
                                                                        @if ($Chat_Data_1[$i]['open'] == NULL)
                                                                            <div class="not_open">未読</div>
                                                                        @else
                                                                            <div>既読</div>
                                                                        @endif
                                                                        <div class="margin-right">
                                                                            <?php
                                                                                echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat_style_1">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @elseif ($Chat_Data_1[$i]['to_account_id'] == $login_id && $Chat_Data_1[$i]['account_id'] == $list_id)
                                                            <div class="chat_icon position_left">
                                                                @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                                <div class="chat_style_2">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time margin-left">
                                                                        <?php
                                                                            echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < sizeof($Chat_Data_2); $i++)
                                                        @if ($Chat_Data_2[$i]['account_id'] == $login_id && $Chat_Data_2[$i]['to_account_id'] == $list_id)
                                                            <div class="chat_icon position_right">
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time">
                                                                        @if ($Chat_Data_2[$i]['open'] == NULL)
                                                                            <div class="not_open">未読</div>
                                                                        @else
                                                                            <div>既読</div>
                                                                        @endif
                                                                        <div class="margin-right">
                                                                            <?php
                                                                                echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat_style_1">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @elseif ($Chat_Data_2[$i]['to_account_id'] == $login_id && $Chat_Data_2[$i]['account_id'] == $list_id)
                                                            <div class="chat_icon position_left">
                                                                @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                                <div class="chat_style_2">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time margin-left">
                                                                        <?php
                                                                            echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @endif
                                                    @endfor
                                                @endif
                                                <div id="chat_list"></div>
                                                @if ($memory_counter == 0)
                                                    <div class="font-size">チャットはありません</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="<?php if ($login_gender == '男性') echo 'background-color: skyblue;'; else echo 'background-color: pink;'; ?>" class="chat_box_wrapper">
                                            <form action={{route('account.index')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="2" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search_view" value="2" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                            </form>
                                            <form name="chat_send" action={{route('database.send_message')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="2" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search_view" value="4" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <textarea id="chat_send" style="<?php if ($chat_MISS != NULL) echo 'color: red;'; ?>" name="message" class="message_box"><?php if ($chat_MISS == 1) echo '未入力です'; if ($chat_MISS == 2) echo '3000字以内入力してください'; ?></textarea>
                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">送信</button>
                                            </form>
                                            <form class='btn_clear' action={{route('database.clear_message')}} method="post">
                                                @csrf
                                                @if ($login_id_flg == 0)
                                                    <?php $flg = 0 ?>
                                                @else
                                                    <?php $flg = 1 ?>
                                                @endif
                                                <input name="flg" value="{{$flg}}" type="hidden">
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="2" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search_view" value="4" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <button class='margin' style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">クリア</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                    @break
                @case (3)
                    <div class="margin_pc">
                        <?php $list_view_json = json_encode($list_view); ?>
                        @switch ($list_view)
                            @case (0)
                                <h1>友達リスト</h1>
                                <div>
                                    <?php $friend_counter = 0; ?>
                                    @for ($i = 0; $i < sizeof($Friend_Data); $i++)
                                        @if ($Friend_Data[$i]['approval_flg'] == 1)
                                            @if ($Friend_Data[$i]['account_id'] == $login_id)
                                                <div class="position_center">
                                                    <div class="friend_list">
                                                        <div class="align-item-center margin-left">
                                                            @if ($Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['upload_image_name'] == NULL)
                                                                @if ($Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['gender'] == '男性')
                                                                    <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                                                                @else
                                                                    <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                @endif
                                                            @else
                                                                <img class="icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['id']}/" . $Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['upload_image_name']); ?>">
                                                            @endif
                                                            {{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['name']}}
                                                        </div>
                                                        <div style="display: flex;" class="margin-right">
                                                            <form class="button_size" action={{route('account.index')}} method="post">
                                                                @csrf
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="list_view" value="3" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="list_birth" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['birth_day']}}" type="hidden">
                                                                <input name="list_id" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['id']}}" type="hidden">
                                                                <input name="list_name" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['name']}}" type="hidden">
                                                                <input name="list_gender" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['gender']}}" type="hidden">
                                                                <input name="list_email" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['email']}}" type="hidden">
                                                                <input name="list_password" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['password']}}" type="hidden">
                                                                <input name="list_tel" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['tel']}}" type="hidden">
                                                                <input name="list_address1" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['address1']}}" type="hidden">
                                                                <input name="list_address2" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['address2']}}" type="hidden">
                                                                <input name="list_introduction" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['introduction']}}" type="hidden">
                                                                <input name="list_upload_image_name" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['upload_image_name']}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">チャット</button>
                                                            </form>
                                                            <form action={{route('account.index')}} method="post">
                                                                @csrf
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="list_view" value="1" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="list_birth" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['birth_day']}}" type="hidden">
                                                                <input name="list_id" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['id']}}" type="hidden">
                                                                <input name="list_name" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['name']}}" type="hidden">
                                                                <input name="list_gender" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['gender']}}" type="hidden">
                                                                <input name="list_email" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['email']}}" type="hidden">
                                                                <input name="list_password" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['password']}}" type="hidden">
                                                                <input name="list_tel" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['tel']}}" type="hidden">
                                                                <input name="list_address1" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['address1']}}" type="hidden">
                                                                <input name="list_address2" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['address2']}}" type="hidden">
                                                                <input name="list_introduction" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['introduction']}}" type="hidden">
                                                                <input name="list_upload_image_name" value="{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['upload_image_name']}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">詳細</button>
                                                            </form>
                                                            <form action={{route('database.delete_friend')}} method="post">
                                                                @csrf
                                                                <input name="friend_id" value="{{$Friend_Data[$i]['id']}}" type="hidden">
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="search_view" value="0" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="search" value="{{$search_title}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">削除</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $friend_counter++; ?>
                                            @elseif ($Friend_Data[$i]['account_friend_id'] == $login_id)
                                                <div class="position_center">
                                                    <div class="friend_list">
                                                        <div class="align-item-center margin-left">
                                                            @if ($Account_Data[$Friend_Data[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                @if ($Account_Data[$Friend_Data[$i]['account_id'] - 1]['gender'] == '男性')
                                                                    <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                                                                @else
                                                                    <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                @endif
                                                            @else
                                                                <img class="icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Friend_Data[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                            @endif
                                                            {{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['name']}}
                                                        </div>
                                                        <div style="display: flex;" class="margin-right">
                                                            <form class="button_size" action={{route('account.index')}} method="post">
                                                                @csrf
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="list_view" value="3" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="list_birth" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['birth_day']}}" type="hidden">
                                                                <input name="list_id" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['id']}}" type="hidden">
                                                                <input name="list_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['name']}}" type="hidden">
                                                                <input name="list_gender" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['gender']}}" type="hidden">
                                                                <input name="list_email" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['email']}}" type="hidden">
                                                                <input name="list_password" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['password']}}" type="hidden">
                                                                <input name="list_tel" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['tel']}}" type="hidden">
                                                                <input name="list_address1" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address1']}}" type="hidden">
                                                                <input name="list_address2" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address2']}}" type="hidden">
                                                                <input name="list_introduction" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['introduction']}}" type="hidden">
                                                                <input name="list_upload_image_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['upload_image_name']}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">チャット</button>
                                                            </form>
                                                            <form action={{route('account.index')}} method="post">
                                                                @csrf
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="list_view" value="1" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="search_view" value="2" type="hidden">
                                                                <input name="list_birth" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['birth_day']}}" type="hidden">
                                                                <input name="list_id" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['id']}}" type="hidden">
                                                                <input name="list_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['name']}}" type="hidden">
                                                                <input name="list_gender" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['gender']}}" type="hidden">
                                                                <input name="list_email" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['email']}}" type="hidden">
                                                                <input name="list_password" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['password']}}" type="hidden">
                                                                <input name="list_tel" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['tel']}}" type="hidden">
                                                                <input name="list_address1" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address1']}}" type="hidden">
                                                                <input name="list_address2" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address2']}}" type="hidden">
                                                                <input name="list_introduction" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['introduction']}}" type="hidden">
                                                                <input name="list_upload_image_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['upload_image_name']}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">詳細</button>
                                                            </form>
                                                            <form action={{route('database.delete_friend')}} method="post">
                                                                @csrf
                                                                <input name="friend_id" value="{{$Friend_Data[$i]['id']}}" type="hidden">
                                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                <input name="login" value="1" type="hidden">
                                                                <input name="view_mode" value="3" type="hidden">
                                                                <input name="search_view" value="0" type="hidden">
                                                                <input name="page" value="1" type="hidden">
                                                                <input name="search" value="{{$search_title}}" type="hidden">
                                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">削除</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $friend_counter++; ?>
                                            @endif
                                        @endif
                                    @endfor
                                </div>
                                @if ($friend_counter == 0)
                                    <p class="font-size">友達はいません</p>
                                @endif
                                @break
                            @case (1)
                                <div>
                                    <h1>プロフィール詳細</h1>
                                    <div class="position_center">
                                        <div class="detail_content_margin_top">
                                            <div class="select_btn position_center">
                                                <form action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="3" type="hidden">
                                                    <input name="list_view" value="2" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="search_view" value="2" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">つぶやき</button>
                                                </form>
                                            </div>
                                            <div class="detail_list">
                                                <div class="margin">
                                                    <div>
                                                        <div class="position_center">
                                                            @if ($list_upload_image_name == NULL)
                                                                @if ($list_gender == '男性')
                                                                    <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                                                                @else
                                                                    <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                @endif
                                                            @else
                                                                <img class="icon_size" src="<?php echo asset("storage/images/{$list_id}/" . $list_upload_image_name); ?>">
                                                            @endif
                                                        </div>
                                                        <div>名前 : {{$list_name}}</div>
                                                        <div>性別 : {{$list_gender}}</div>
                                                        <div>誕生日 : {{$list_birth}}</div>
                                                        <div>居住地 : {{$list_address1}} : {{$list_address2}}</div>
                                                        <div style="text-align: center;">自己紹介</div>
                                                        <div class="introduction">
                                                            <div class="padding">
                                                                {{$list_introduction}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <form action={{route('account.index')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="3" type="hidden">
                                                <input name="list_view" value="0" type="hidden">
                                                <input name="search_view" value="0" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search" value="{{$search_title}}" type="hidden">
                                                <button class="<?php if ($login_gender == '男性') echo 'detail_btn_man'; else echo 'detail_btn_woman'; ?>">戻る</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case (2)
                                <?php $list_id_json = json_encode($list_id); ?>
                                <div class="position_center">
                                    <div class="tweet_box_wrapper_margin">
                                        <h1>{{$list_name}}さんのつぶやき</h1>
                                        <div class="position_center">
                                            <div>
                                                <div id="tweet_list"></div>
                                                <?php $tweet_counter = 0; ?>
                                                @for ($i = 0; $i < sizeof($Tweet_Data); $i++)
                                                    @if ($Tweet_Data[$i]['account_id'] == $list_id)
                                                        <div class="regist_date_tweet">投稿日時 : {{$Tweet_Data[$i]['created_at']}}</div>
                                                        <div class="mumble_box" ><div class="padding"><?php echo nl2br($Tweet_Data[$i]['tweet']); ?></div></div>
                                                        <?php $tweet_counter++; ?>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($tweet_counter == 0)
                                            <p class="font-size">投稿はありません</p>
                                        @endif
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="3" type="hidden">
                                            <input name="list_view" value="0" type="hidden">
                                            <input name="page" value="1" type="hidden">
                                            <input name="search_view" value="2" type="hidden">
                                            <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                            <input name="list_id" value="{{$list_id}}" type="hidden">
                                            <input name="list_name" value="{{$list_name}}" type="hidden">
                                            <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                            <input name="list_email" value="{{$list_email}}" type="hidden">
                                            <input name="list_password" value="{{$list_password}}" type="hidden">
                                            <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                            <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                            <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                            <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                            <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                            <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case (3)
                                <?php
                                    $list_id_json = json_encode($list_id);
                                    $list_gender_json = json_encode($list_gender);
                                    $list_upload_image_name_json = json_encode($list_upload_image_name);
                                ?>
                                <h1>{{$list_name}}さんとチャット</h1>
                                <div class="position_center">
                                    <?php
                                        $memory_counter = 0;
                                        $chat_counter = 0;
                                        $receive_chat_counter = 0;
                                    ?>
                                    @if (sizeof($Memory_Chat_Data) != 0)
                                        @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                            @if (($login_id == $Memory_Chat_Data[$i]['account_id'] || $login_id == $Memory_Chat_Data[$i]['from_account_id']) &&
                                                ($list_id == $Memory_Chat_Data[$i]['account_id'] || $list_id == $Memory_Chat_Data[$i]['from_account_id']))
                                                <?php $memory_counter++; ?>
                                            @endif
                                        @endfor
                                        @if (sizeof($Chat_Data_1) != 0)
                                            <div id="chat" class="chat">
                                        @else
                                            <div class="chat_null">
                                        @endif
                                    @else
                                        <div class="chat_null">
                                    @endif
                                        <div class="chat_view_area">
                                            <div>
                                                @for ($i = 0; $i < sizeof($Memory_Chat_Data); $i++)
                                                    @if ($Memory_Chat_Data[$i]['account_id'] == $login_id && $Memory_Chat_Data[$i]['from_account_id'] == $list_id)
                                                        <?php $login_id_flg = 0 ?>
                                                    @elseif($Memory_Chat_Data[$i]['account_id'] == $list_id && $Memory_Chat_Data[$i]['from_account_id'] == $login_id)
                                                        <?php $login_id_flg = 1 ?>
                                                    @endif
                                                @endfor
                                                @if ($login_id_flg == 0)
                                                    @for ($i = 0; $i < sizeof($Chat_Data_1); $i++)
                                                        @if ($Chat_Data_1[$i]['account_id'] == $login_id && $Chat_Data_1[$i]['to_account_id'] == $list_id)
                                                            <div class="chat_icon position_right">
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time">
                                                                        @if ($Chat_Data_1[$i]['open'] == NULL)
                                                                            <div class="not_open">未読</div>
                                                                        @else
                                                                            <div>既読</div>
                                                                        @endif
                                                                        <div class="margin-right">
                                                                            <?php
                                                                                echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat_style_1">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @elseif ($Chat_Data_1[$i]['to_account_id'] == $login_id && $Chat_Data_1[$i]['account_id'] == $list_id)
                                                            <div class="chat_icon position_left">
                                                                @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_1[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                                <div class="chat_style_2">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_1[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time margin-left">
                                                                        <?php
                                                                            echo $Chat_Data_1[$i]['created_at']->format('G:i');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @endif
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < sizeof($Chat_Data_2); $i++)
                                                        @if ($Chat_Data_2[$i]['account_id'] == $login_id && $Chat_Data_2[$i]['to_account_id'] == $list_id)
                                                            <div class="chat_icon position_right">
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time">
                                                                        @if ($Chat_Data_2[$i]['open'] == NULL)
                                                                            <div class="not_open">未読</div>
                                                                        @else
                                                                            <div>既読</div>
                                                                        @endif
                                                                        <div class="margin-right">
                                                                            <?php
                                                                                echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="chat_style_1">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-right icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-right icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @elseif ($Chat_Data_2[$i]['to_account_id'] == $login_id && $Chat_Data_2[$i]['account_id'] == $list_id)
                                                            <div class="chat_icon position_left">
                                                                @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name'] == NULL)
                                                                    @if ($Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['gender'] == '男性')
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_man.png') }}>
                                                                    @else
                                                                        <img class="margin-left icon_size" src={{ asset('images/icon_woman.png') }}>
                                                                    @endif
                                                                @else
                                                                    <img class="margin-left icon_size" src="<?php echo asset("storage/images/{$Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['id']}/" . $Account_Data[$Chat_Data_2[$i]['account_id'] - 1]['upload_image_name']); ?>">
                                                                @endif
                                                                <div class="chat_style_2">
                                                                    <div class="margin">
                                                                        <?php
                                                                            echo nl2br($Chat_Data_2[$i]['chat'], false);
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div class="position_bottom">
                                                                    <div class="font-size-time margin-left">
                                                                        <?php
                                                                            echo $Chat_Data_2[$i]['created_at']->format('G:i');
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $chat_counter++; ?>
                                                        @endif
                                                    @endfor
                                                @endif
                                                <div id="chat_list"></div>
                                                @if ($memory_counter == 0)
                                                    <div class="font-size">チャットはありません</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="<?php if ($login_gender == '男性') echo 'background-color: skyblue;'; else echo 'background-color: pink;'; ?>" class="chat_box_wrapper">
                                            <form action={{route('account.index')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="3" type="hidden">
                                                <input name="list_view" value="0" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search_view" value="2" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                            </form>
                                            <form name="chat_send" action={{route('database.send_message')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="3" type="hidden">
                                                <input name="list_view" value="3" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="search_view" value="4" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <textarea id="chat_send" style="<?php if ($chat_MISS != NULL) echo 'color: red;'; ?>" name="message" class="message_box"><?php if ($chat_MISS == 1) echo '未入力です'; if ($chat_MISS == 2) echo '3000字以内入力してください'; ?></textarea>
                                                <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">送信</button>
                                            </form>
                                            <form class='btn_clear' action={{route('database.clear_message')}} method="post">
                                                @csrf
                                                @if ($login_id_flg == 0)
                                                    <?php $flg = 0 ?>
                                                @else
                                                    <?php $flg = 1 ?>
                                                @endif
                                                <input name="flg" value="{{$flg}}" type="hidden">
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="3" type="hidden">
                                                <input name="page" value="1" type="hidden">
                                                <input name="list_view" value="3" type="hidden">
                                                <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                <input name="list_id" value="{{$list_id}}" type="hidden">
                                                <input name="list_name" value="{{$list_name}}" type="hidden">
                                                <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                <input name="list_email" value="{{$list_email}}" type="hidden">
                                                <input name="list_password" value="{{$list_password}}" type="hidden">
                                                <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                <button class='margin' style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">クリア</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                    @break
                @case (4)
                    <?php
                        $list_id_json = json_encode($list_id);
                        $list_name_json = json_encode($list_name);
                    ?>
                    <div class="margin_pc">
                        <?php $friend_request_view_json = json_encode($friend_request_view); ?>
                        @switch ($friend_request_view)
                            @case (0)
                                <h1>友達リクエスト</h1>
                                <div class="friend_request">
                                    <div class="position_center">
                                        <div>
                                            <?php
                                                $list_get_counter = 0;
                                                $list_send_counter = 0;
                                            ?>
                                            <div>
                                                <form name="request_onload" action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="4" type="hidden">
                                                    <input name="friend_request_view" value="1" type="hidden">
                                                    <input name="search_view" value="0" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="search" value="{{$search_title}}" type="hidden">
                                                </form>
                                                <div id="request_list"></div>
                                                <form action={{route('database.approval_friend')}} method="post">
                                                @for ($i = 0; $i < sizeof($Friend_Data); $i++)
                                                    @if ($Friend_Data[$i]['account_friend_id'] == $login_id && $Friend_Data[$i]['request_flg'] == 1)
                                                        <div class="font-size-name get_request position_between">
                                                            <div class="margin-left margin-right">{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['name']}}さんからのリクエスト</div>
                                                            <div style="display: flex;" class="margin-right flex">
                                                                </form>
                                                                <form action={{route('account.index')}} method="post">
                                                                    @csrf
                                                                    <input name="request_id" value="{{$Friend_Data[$i]['id']}}" type="hidden">
                                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                    <input name="login" value="1" type="hidden">
                                                                    <input name="list_birth" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['birth_day']}}" type="hidden">
                                                                    <input name="list_id" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['id']}}" type="hidden">
                                                                    <input name="list_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['name']}}" type="hidden">
                                                                    <input name="list_gender" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['gender']}}" type="hidden">
                                                                    <input name="list_email" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['email']}}" type="hidden">
                                                                    <input name="list_password" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['password']}}" type="hidden">
                                                                    <input name="list_tel" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['tel']}}" type="hidden">
                                                                    <input name="list_address1" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address1']}}" type="hidden">
                                                                    <input name="list_address2" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['address2']}}" type="hidden">
                                                                    <input name="list_introduction" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['introduction']}}" type="hidden">
                                                                    <input name="list_upload_image_name" value="{{$Account_Data[$Friend_Data[$i]['account_id'] - 1]['upload_image_name']}}" type="hidden">
                                                                    <input name="view_mode" value="4" type="hidden">
                                                                    <input name="friend_request_view" value="1" type="hidden">
                                                                    <input name="search_view" value="0" type="hidden">
                                                                    <input name="page" value="1" type="hidden">
                                                                    <input name="search" value="{{$search_title}}" type="hidden">
                                                                    <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>">詳細</button>
                                                                </form>
                                                                <form action={{route('database.approval_friend')}} method="post">
                                                                    @csrf
                                                                    <input name="request_id" value="{{$Friend_Data[$i]['id']}}" type="hidden">
                                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                    <input name="login" value="1" type="hidden">
                                                                    <input name="view_mode" value="4" type="hidden">
                                                                    <input name="search_view" value="0" type="hidden">
                                                                    <input name="page" value="1" type="hidden">
                                                                    <input name="search" value="{{$search_title}}" type="hidden">
                                                                    <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>">承認</button>
                                                                </form>
                                                                <form action={{route('database.delete_request')}} method="post">
                                                                    @csrf
                                                                    <input name="request_id" value="{{$Friend_Data[$i]['id']}}" type="hidden">
                                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                                    <input name="login" value="1" type="hidden">
                                                                    <input name="view_mode" value="4" type="hidden">
                                                                    <input name="search_view" value="0" type="hidden">
                                                                    <input name="page" value="1" type="hidden">
                                                                    <input name="search" value="{{$search_title}}" type="hidden">
                                                                    <button style="<?php if ($login_gender == '男性') echo 'background-color: #5090c0; border-color: #5090c0;'; else echo 'background-color: palevioletred; border-color: palevioletred;'; ?>">削除</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $list_get_counter++;
                                                            $list_get_counter_json = json_encode($list_get_counter);
                                                        ?>
                                                    @endif
                                                @endfor
                                            </div>
                                            @if (json_decode($list_get_counter_json) == 0)
                                                <div id="receive_null" class="font-size margin">受信リクエストはありません</div>
                                            @endif
                                            <div class="position_center">
                                                <div>
                                                    @for ($i = 0; $i < sizeof($Friend_Data); $i++)
                                                        @if ($Friend_Data[$i]['account_id'] == $login_id && $Friend_Data[$i]['request_flg'] == 1)
                                                            <div class="send_request">{{$Account_Data[$Friend_Data[$i]['account_friend_id'] - 1]['name']}}さんにリスエスト申請中です</div>
                                                            <?php $list_send_counter++; ?>
                                                        @endif
                                                    @endfor
                                                    @if ($list_send_counter == 0)
                                                        <div class="font-size">申請中リクエストはありません</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case (1)
                                <h1>プロフィール詳細</h1>
                                <div class="position_center">
                                    <div>
                                        @if ($login_id != $list_id)
                                            <div class="search_list_btn position_center">
                                                <form action={{route('account.index')}} method="post">
                                                    @csrf
                                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                    <input name="login" value="1" type="hidden">
                                                    <input name="view_mode" value="4" type="hidden">
                                                    <input name="friend_request_view" value="2" type="hidden">
                                                    <input name="page" value="1" type="hidden">
                                                    <input name="search_view" value="3" type="hidden">
                                                    <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                                    <input name="list_id" value="{{$list_id}}" type="hidden">
                                                    <input name="list_name" value="{{$list_name}}" type="hidden">
                                                    <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                                    <input name="list_email" value="{{$list_email}}" type="hidden">
                                                    <input name="list_password" value="{{$list_password}}" type="hidden">
                                                    <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                                    <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                                    <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                                    <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                                    <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                                    <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">つぶやき</button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="detail_list">
                                            <div class="margin">
                                                <div>
                                                    <div class="position_center">
                                                        @if ($list_upload_image_name == NULL)
                                                            @if ($list_gender == '男性')
                                                                <img src={{ asset('images/icon_man.png') }}>
                                                            @else
                                                                <img src={{ asset('images/icon_woman.png') }}>
                                                            @endif
                                                        @else
                                                            <img class="icon_size" src="<?php echo asset("storage/images/{$list_id}/" . $list_upload_image_name); ?>">
                                                        @endif
                                                    </div>
                                                    <div>名前 : {{$list_name}}</div>
                                                    <div>性別 : {{$list_gender}}</div>
                                                    <div>誕生日 : {{$list_birth}}</div>
                                                    @if ($login_id == $list_id)
                                                        <div>メール : {{$list_email}}</div>
                                                        <div>電話番号 : {{$list_tel}}</div>
                                                    @endif
                                                    <div>居住地 : {{$list_address1}} : {{$list_address2}}</div>
                                                    <div style="text-align: center;">自己紹介</div>
                                                    <div class="introduction">
                                                        <div class="padding">
                                                            {{$list_introduction}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="4" type="hidden">
                                            <input name="friend_request_view" value="0" type="hidden">
                                            <input name="search_view" value="0" type="hidden">
                                            <input name="page" value="1" type="hidden">
                                            <input name="search" value="{{$search_title}}" type="hidden">
                                            <button class="<?php if ($login_gender == '男性') echo 'detail_btn_man'; else echo 'detail_btn_woman'; ?>">戻る</button>
                                        </form>
                                    </div>
                                </div>
                                @break
                            @case (2)
                                <?php $list_id_json = json_encode($list_id); ?>
                                <div class="position_center">
                                    <div class="tweet_box_wrapper_margin">
                                        <h1>{{$list_name}}さんのつぶやき</h1>
                                        <div class="position_center">
                                            <div>
                                                <div id="tweet_list"></div>
                                                <?php $tweet_counter = 0; ?>
                                                @for ($i = 0; $i < sizeof($Tweet_Data); $i++)
                                                    @if ($Tweet_Data[$i]['account_id'] == $list_id)
                                                        <div class="regist_date_tweet">投稿日時 : {{$Tweet_Data[$i]['created_at']}}</div>
                                                        <div class="mumble_box" ><div class="padding"><?php echo nl2br($Tweet_Data[$i]['tweet']); ?></div></div>
                                                        <?php $tweet_counter++; ?>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        @if ($tweet_counter == 0)
                                            <p class="font-size">投稿はありません</p>
                                        @endif
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="4" type="hidden">
                                            <input name="friend_request_view" value="1" type="hidden">
                                            <input name="page" value="1" type="hidden">
                                            <input name="search_view" value="2" type="hidden">
                                            <input name="list_birth" value="{{$list_birth}}" type="hidden">
                                            <input name="list_id" value="{{$list_id}}" type="hidden">
                                            <input name="list_name" value="{{$list_name}}" type="hidden">
                                            <input name="list_gender" value="{{$list_gender}}" type="hidden">
                                            <input name="list_email" value="{{$list_email}}" type="hidden">
                                            <input name="list_password" value="{{$list_password}}" type="hidden">
                                            <input name="list_tel" value="{{$list_tel}}" type="hidden">
                                            <input name="list_address1" value="{{$list_address1}}" type="hidden">
                                            <input name="list_address2" value="{{$list_address2}}" type="hidden">
                                            <input name="list_introduction" value="{{$list_introduction}}" type="hidden">
                                            <input name="list_upload_image_name" value="{{$list_upload_image_name}}" type="hidden">
                                            <button style="<?php if ($login_gender == '男性') echo 'border-color: #5090c0; background-color: #5090c0;'; else echo 'border-color: palevioletred; background-color: palevioletred;'; ?>">戻る</button>
                                        </form>
                                    </div>
                                </div>
                                @break
                        @endswitch
                    </div>
                    @break
                @case (5)
                    <div class="margin_pc">
                    <h1 >プロフィール</h1>
                    @switch ($view_edit)
                        @case (0)
                            <div class="edit_select_button_wrapper">
                                <form action={{route('account.index')}} method="post">
                                    @csrf
                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                    <input name="login" value="1" type="hidden">
                                    <input name="view_mode" value="5" type="hidden">
                                    <input name="view_edit" value="1" type="hidden">
                                    <button class="<?php if ($login_gender == '男性') echo 'edit_button_man'; else echo 'edit_button_woman'; ?>">
                                        <?php if ($login_gender == '男性') echo '📘'; else echo '📕'; ?> 登録情報を確認する
                                    </button>
                                </form>
                                <form action={{route('account.index')}} method="post">
                                    @csrf
                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                    <input name="login" value="1" type="hidden">
                                    <input name="view_mode" value="5" type="hidden">
                                    <input name="view_edit" value="2" type="hidden">
                                    <button class="<?php if ($login_gender == '男性') echo 'edit_button_man'; else echo 'edit_button_woman'; ?>">
                                        <?php if ($login_gender == '男性') echo '📘'; else echo '📕'; ?> 登録情報を変更する<br><div class="margin-top">写真・名前・誕生日・電話番号・住所・自己紹介を変更できます。</div><div>※性別・メールアドレスは変更できません</div>
                                    </button>
                                </form>
                                <form action={{route('account.index')}} method="post">
                                    @csrf
                                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                    <input name="login_name" value="{{$login_name}}" type="hidden">
                                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                    <input name="login_password" value="{{$login_password}}" type="hidden">
                                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                    <input name="login" value="1" type="hidden">
                                    <input name="view_mode" value="5" type="hidden">
                                    <input name="view_edit" value="3" type="hidden">
                                    <button class="<?php if ($login_gender == '男性') echo 'edit_button_man'; else echo 'edit_button_woman'; ?>">
                                        🔑 パスワードを変更する<div class="margin-top">4字以上で設定してください</div>
                                    </button>
                                </form>
                                <form action={{route('database.delete_account')}} method="post">
                                    @csrf
                                    <input name="login_id" value="{{$login_id}}" type="hidden">
                                    <input name="login_email" value="{{$login_email}}" type="hidden">
                                    <button class="<?php if ($login_gender == '男性') echo 'edit_button_man'; else echo 'edit_button_woman'; ?>">
                                        🗑️ アカウントを削除する<br><span></span>
                                    </button>
                                </form>
                            <div>
                            @break
                        @case (1)
                            <div class="position_center">
                                <div>
                                    <div class="detail_view">
                                        <div class="margin">
                                            <div style="text-align: center;">
                                                @if ($login_upload_image_name == NULL)
                                                    @if ($login_gender == '男性')
                                                        <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                                                    @else
                                                        <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                                                    @endif
                                                @else
                                                    <img class="icon_size" src="<?php echo asset("storage/images/{$login_id}/" . $login_upload_image_name); ?>">
                                                @endif
                                            </div>
                                            <div>名前 : {{$login_name}}</div>
                                            <div>性別 : {{$login_gender}}</div>
                                            <div>誕生日 : {{$login_birth}}</div>
                                            <div>メール : {{$login_email}}<br><span style="color: red;">※公開されません</span></div>
                                            <div>電話番号 : {{$login_tel}} <br class="display_br"><span style="color: red;">※公開されません</span></div>
                                            <div>居住地 : {{$login_address1}} : {{$login_address2}}</div>
                                            <div style="text-align: center;">自己紹介</div>
                                            <div class="position_center">
                                                <div class="introduction">
                                                    <div class="padding">
                                                        {{$login_introduction}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action={{route('account.index')}} method="post">
                                        @csrf
                                        <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                        <input name="login_id" value="{{$login_id}}" type="hidden">
                                        <input name="login_name" value="{{$login_name}}" type="hidden">
                                        <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                        <input name="login_email" value="{{$login_email}}" type="hidden">
                                        <input name="login_password" value="{{$login_password}}" type="hidden">
                                        <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                        <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                        <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                        <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                        <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                        <input name="login" value="1" type="hidden">
                                        <input name="view_mode" value="5" type="hidden">
                                        <input name="view_edit" value="0" type="hidden">
                                        <button class="<?php if ($login_gender == '男性') echo 'detail_btn_man'; else echo 'detail_btn_woman'; ?>">戻る</button>
                                    </form>
                                </div>
                            </div>
                            @break
                        @case (2)
                            <div class="position_center">
                                <div class="edit_status_form">
                                    <div class="border_in_content_margin">
                                        <p><?php if ($login_gender == '男性') echo '📘'; else echo '📕'; ?> 登録情報変更</p>
                                        <form enctype='multipart/form-data' action={{route('database.update_status')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="5" type="hidden">
                                            <input name="view_edit" value="2" type="hidden">
                                            <div>
                                                <input name="upload_image" type="file">
                                                @if ($edit_image == 1)
                                                    <span>写真を変更しました</span>
                                                @endif
                                                <br>
                                                <label>誕生日</label><br class="display_none_pc">
                                                <select style="<?php if ($edit_status_birth_MISS == 1) echo'color: red;'; ?>" name="new_year">
                                                    <option>選択してください</option>
                                                    @for ($i = 1960; $i <= date("Y") - 18; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <span>年</span><br class="display_none_pc">
                                                <select style="<?php if ($edit_status_birth_MISS == 1) echo'color: red;'; ?>" name="new_month">
                                                    <option>選択してください</option>
                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <span>月</span><br class="display_none_pc">
                                                <select style="<?php if ($edit_status_birth_MISS == 1) echo'color: red;'; ?>" name="new_day">
                                                    <option>選択してください</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <span>日</span><br class="display_none_pc">
                                            </div>
                                            @if ($edit_status_birth_MISS == 2)
                                                <span>誕生日が変更されました</span>
                                            @endif
                                            <div class="edit_name">
                                                <label>名前</label><br class="display_none_pc">
                                                <input name="new_name" placeholder="名前" type="text">
                                                @if ($edit_status_name_MISS == 1)
                                                    <br class="display_none_pc"><span style="color: red;">10字以内入力してください</span>
                                                @elseif ($edit_status_name_MISS == 2)
                                                    <br class="display_none_pc"><span>名前が変更されました</span>
                                                @endif
                                            </div>
                                            <div class="edit_tel">
                                                <label>電話番号</label><br class="display_none_pc">
                                                <input name="new_tel" placeholder="電話番号" type="text">
                                                @if ($edit_status_tel_MISS == 1)
                                                    <br class="display_none_pc"><span style="color: red;">11字以内入力してください</span>
                                                @elseif ($edit_status_tel_MISS == 2)
                                                    <br class="display_none_pc"><span>電話番号が変更されました</span>
                                                @endif
                                            </div>
                                            <div class="edit_address1">
                                                <label>居住地1</label><br class="display_none_pc">
                                                <select name="new_address1">
                                                    <option>選択してください</option>
                                                    @php
                                                        $address1 = [
                                                            '北海道', '青森県', '山形県', '秋田県', '宮城県', '福島県', '岩手県', '栃木県', '群馬県', '茨城県', '埼玉県', '東京都', '千葉県', '神奈川県', '山梨県', '新潟県', '長野県', '静岡県', '愛知県', '岐阜県',
                                                            '滋賀県', '富山県', '石川県', '福井県', '和歌山県', '大阪府', '奈良県', '三重県', '京都府', '兵庫県', '岡山県', '広島県', '山口県', '鳥取県', '広島県', '愛媛県', '香川県', '徳島県', '高知県', '佐賀県',
                                                            '福岡県', '大分県', '熊本県', '宮崎県', '鹿児島県', '長崎県', '沖縄県'
                                                        ];
                                                        foreach($address1 as $address)
                                                            echo "<option>{$address}</option>";
                                                    @endphp
                                                </select><br class="display_none_pc">
                                                @if ($edit_address1 == 1)
                                                <span>居住地1が変更されました</span>
                                            @endif
                                            </div>
                                            <div class="edit_address2">
                                                <label>居住地2</label><br class="display_none_pc">
                                                <input name="new_address2" type="text" placeholder="市町村">
                                                @if ($edit_status_address2_MISS == 1)
                                                    <br class="display_none_pc"><span style="color: red;">10字以内入力してください</span>
                                                @elseif ($edit_status_address2_MISS == 2)
                                                    <br class="display_none_pc"><span>居住地2が変更されました</span>
                                                @endif
                                                <br>
                                            </div>
                                            <div class="edit_introduction">
                                                <label>自己紹介</label><br>
                                                @if ($edit_status_introduction_MISS == 1)
                                                    <span style="color: red;"> 1000字以内入力してください</span>
                                                @elseif ($edit_status_introduction_MISS == 2)
                                                    <span style="color: red;"> 自己紹介が変更されました</span>
                                                @endif
                                                <textarea name="new_introduction" placeholder="自己紹介:1000字以内">{{$login_introduction}}</textarea>
                                            </div>
                                            <div class="edit_button_position">
                                            </form>
                                            <form action={{route('account.index')}} method="post">
                                                @csrf
                                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                                <input name="login" value="1" type="hidden">
                                                <input name="view_mode" value="5" type="hidden">
                                                <input name="view_edit" value="0" type="hidden">
                                                <button class="<?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">戻る</button>
                                            </form>
                                            <button class="edit_btn_margin_left <?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">保存</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (3)
                            <div class="position_center">
                                <div class="edit_password_form">
                                    <form action={{route('database.update_password')}} method="post">
                                        @csrf
                                        <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                        <input name="login_id" value="{{$login_id}}" type="hidden">
                                        <input name="login_name" value="{{$login_name}}" type="hidden">
                                        <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                        <input name="login_email" value="{{$login_email}}" type="hidden">
                                        <input name="login_password" value="{{$login_password}}" type="hidden">
                                        <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                        <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                        <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                        <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                        <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                        <input name="login" value="1" type="hidden">
                                        <input name="view_mode" value="5" type="hidden">
                                        <input name="view_edit" value="3" type="hidden">
                                        <p>🔑 パスワード変更</p>
                                        <label>現在のパスワード</label><br class="display_none_pc">
                                        <input name="password_now" type="password" placeholder="現在のパスワード"><br>
                                        @if ($edit_now_password_MISS == 1)
                                            <div class="edit_password_error_message">未入力です</div>
                                        @elseif ($edit_now_password_MISS == 2)
                                            <div class="edit_password_error_message">現在のパスワードが正しくありません</div>
                                        @elseif ($edit_now_password_MISS == 3)
                                            <div class="edit_password_error_message">255字以内入力してください</div>
                                        @endif
                                        <div class="edit_input_margin">
                                            <label>新しいパスワード</label><br class="display_none_pc">
                                            <input name="password_new" class="input_margin" type="password" placeholder="新しいパスワード"><br>
                                            @if ($edit_new_password_MISS == 1)
                                                <div class="message_margin edit_password_error_message">未入力です</div>
                                            @elseif ($edit_new_password_MISS == 2)
                                                <div class="message_margin edit_password_error_message">4字以上入力してください</div>
                                            @elseif ($edit_new_password_MISS == 3)
                                                <div class="message_margin edit_password_error_message">255字以内入力してください</div>
                                            @endif
                                        </div>
                                        <label>新しいパスワード(確認)</label><br class="display_none_pc">
                                        <input name="password_new_retype" type="password" placeholder="新しいパスワード(確認)">
                                        @if ($edit_new_password_retype_MISS == 1)
                                            <div class="edit_password_error_message">未入力です</div>
                                        @elseif ($edit_new_password_retype_MISS == 2)
                                            <div class="edit_password_error_message">4字以上入力してください</div>
                                        @elseif ($edit_new_password_retype_MISS == 3)
                                            <div class="edit_password_error_message">255字以内入力してください</div>
                                        @endif
                                        @if ($edit_new_password_MISS == 4)
                                            <div class="edit_password_error_message">新しいパスワードが確認用と異なっております</div>
                                        @endif
                                        @if ($edit_success == 1)
                                            <div class="edit_success_message">パスワードが変更されました</div>
                                        @endif
                                        <div class="edit_button_position">
                                        </form>
                                        <form action={{route('account.index')}} method="post">
                                            @csrf
                                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                            <input name="login_id" value="{{$login_id}}" type="hidden">
                                            <input name="login_name" value="{{$login_name}}" type="hidden">
                                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                            <input name="login_email" value="{{$login_email}}" type="hidden">
                                            <input name="login_password" value="{{$login_password}}" type="hidden">
                                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                            <input name="login" value="1" type="hidden">
                                            <input name="view_mode" value="5" type="hidden">
                                            <input name="view_edit" value="0" type="hidden">
                                            <button class="<?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">戻る</button>
                                        </form>
                                        <button class="edit_btn_margin_left <?php if ($login_gender == '男性') echo 'edit_btn_man'; else echo 'edit_btn_woman'; ?>">保存</button>
                                    </div>
                                </div>
                            </div>
                            @break
                    @endswitch
                </div>
                @break
            @endswitch
        </div>
    </div>
    <div class="<?php if ($login_gender == '男性') echo 'side_menu_man'; else echo 'side_menu_woman'; ?> display_none_phone">
        <div style="display: flex; justify-content: center; margin-top: 130px;">
            <div>
                <form action={{route('account.index')}} method="post">
                    @csrf
                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                    <input name="login_id" value="{{$login_id}}" type="hidden">
                    <input name="login_name" value="{{$login_name}}" type="hidden">
                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                    <input name="login_email" value="{{$login_email}}" type="hidden">
                    <input name="login_password" value="{{$login_password}}" type="hidden">
                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                    <input name="login" value="1" type="hidden">
                    <input name="view_mode" value="0" type="hidden">
                    <button style="
                    <?php
                        if ($view_mode == 0) {
                            if ($login_gender == '男性')
                                echo 'color: white; background-color: #5090c0;';
                            else
                                echo 'color: white; background-color: palevioletred;';
                        }
                    ?>
                    ">🗯️ つぶやく
                    </button>
                </form>
                <form action={{route('account.index')}} method="post">
                    @csrf
                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                    <input name="login_id" value="{{$login_id}}" type="hidden">
                    <input name="login_name" value="{{$login_name}}" type="hidden">
                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                    <input name="login_email" value="{{$login_email}}" type="hidden">
                    <input name="login_password" value="{{$login_password}}" type="hidden">
                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                    <input name="login" value="1" type="hidden">
                    <input name="view_mode" value="1" type="hidden">
                    <input name="chat_view" value="0" type="hidden">
                    <button style="
                    <?php
                        $chat_counter_total = 0;

                        for ($i = 0; $i < sizeof($Chat_Data_1); $i++) {
                            if ($Chat_Data_1[$i]['open'] == NULL && $Chat_Data_1[$i]['to_account_id'] == $login_id)
                                $chat_counter_total++;
                        }

                        if ($view_mode == 1) {
                            if ($login_gender == '男性')
                                echo 'color: white; background-color: #5090c0;';
                            else
                                echo 'color: white; background-color: palevioletred;';
                        }
                    ?>
                    ">💬 チャット <span id="chat_count_total"><?php if ($chat_counter_total != 0) echo '+' . $chat_counter_total; ?></span>
                    </button>
                </form>
                <form action={{route('account.index')}} method="post">
                    @csrf
                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                    <input name="login_id" value="{{$login_id}}" type="hidden">
                    <input name="login_name" value="{{$login_name}}" type="hidden">
                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                    <input name="login_email" value="{{$login_email}}" type="hidden">
                    <input name="login_password" value="{{$login_password}}" type="hidden">
                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                    <input name="login" value="1" type="hidden">
                    <input name="view_mode" value="2" type="hidden">
                    <input name="search_view" value="0" type="hidden">
                    <input name="page" value="1" type="hidden">
                    <button style="
                    <?php
                        if ($view_mode == 2) {
                            if ($login_gender == '男性')
                                echo 'color: white; background-color: #5090c0;';
                            else
                                echo 'color: white; background-color: palevioletred;';
                        }
                    ?>
                    ">🔍 友達検索
                    </button>
                </form>
                @if ($login_gender == '男性')
                    <form action={{route('account.index')}} method="post">
                        @csrf
                        <input name="login_birth" value="{{$login_birth}}" type="hidden">
                        <input name="login_id" value="{{$login_id}}" type="hidden">
                        <input name="login_name" value="{{$login_name}}" type="hidden">
                        <input name="login_gender" value="{{$login_gender}}" type="hidden">
                        <input name="login_email" value="{{$login_email}}" type="hidden">
                        <input name="login_password" value="{{$login_password}}" type="hidden">
                        <input name="login_tel" value="{{$login_tel}}" type="hidden">
                        <input name="login_address1" value="{{$login_address1}}" type="hidden">
                        <input name="login_address2" value="{{$login_address2}}" type="hidden">
                        <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                        <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                        <input name="login" value="1" type="hidden">
                        <input name="view_mode" value="3" type="hidden">
                        <input name="list_view" value="0" type="hidden">
                        <button style="<?php if ($view_mode == 3) echo 'color: white; background-color: #5090c0;'; ?>">📘 友達リスト</button>
                    </form>
                @else
                    <form action={{route('account.index')}} method="post">
                        @csrf
                        <input name="login_birth" value="{{$login_birth}}" type="hidden">
                        <input name="login_id" value="{{$login_id}}" type="hidden">
                        <input name="login_name" value="{{$login_name}}" type="hidden">
                        <input name="login_gender" value="{{$login_gender}}" type="hidden">
                        <input name="login_email" value="{{$login_email}}" type="hidden">
                        <input name="login_password" value="{{$login_password}}" type="hidden">
                        <input name="login_tel" value="{{$login_tel}}" type="hidden">
                        <input name="login_address1" value="{{$login_address1}}" type="hidden">
                        <input name="login_address2" value="{{$login_address2}}" type="hidden">
                        <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                        <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                        <input name="login" value="1" type="hidden">
                        <input name="view_mode" value="3" type="hidden">
                        <input name="list_view" value="0" type="hidden">
                        <button style="<?php if ($view_mode == 3) echo 'color: white; background-color: palevioletred;'; ?>">📕 友達リスト</button>
                    </form>
                @endif
                <form action={{route('account.index')}} method="post">
                    @csrf
                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                    <input name="login_id" value="{{$login_id}}" type="hidden">
                    <input name="login_name" value="{{$login_name}}" type="hidden">
                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                    <input name="login_email" value="{{$login_email}}" type="hidden">
                    <input name="login_password" value="{{$login_password}}" type="hidden">
                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                    <input name="login" value="1" type="hidden">
                    <input name="view_edit" value="0" type="hidden">
                    <input name="view_mode" value="4" type="hidden">
                    <input name="friend_request_view" value="0" type="hidden">
                    <button style="
                    <?php
                        $request_counter = 0;

                        for ($i = 0; $i < sizeof($Friend_Data); $i++) {
                            if ($Friend_Data[$i]['account_friend_id'] == $login_id && $Friend_Data[$i]['request_flg'] == 1)
                                $request_counter++;
                        }

                        if ($view_mode == 4) {
                            if ($login_gender == '男性')
                                echo 'color: white; background-color: #5090c0;';
                            else
                                echo 'color: white; background-color: palevioletred;';
                        }
                    ?>
                    ">🔔 友達リクエスト <span id="request_counter_pc"><?php if ($request_counter != 0) echo  '+' .$request_counter; ?></span>
                    </button>
                </form>
                <form action={{route('account.index')}} method="post">
                    @csrf
                    <input name="login_birth" value="{{$login_birth}}" type="hidden">
                    <input name="login_id" value="{{$login_id}}" type="hidden">
                    <input name="login_name" value="{{$login_name}}" type="hidden">
                    <input name="login_gender" value="{{$login_gender}}" type="hidden">
                    <input name="login_email" value="{{$login_email}}" type="hidden">
                    <input name="login_password" value="{{$login_password}}" type="hidden">
                    <input name="login_tel" value="{{$login_tel}}" type="hidden">
                    <input name="login_address1" value="{{$login_address1}}" type="hidden">
                    <input name="login_address2" value="{{$login_address2}}" type="hidden">
                    <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                    <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                    <input name="login" value="1" type="hidden">
                    <input name="view_edit" value="0" type="hidden">
                    <input name="view_mode" value="5" type="hidden">
                    <button style="
                    <?php
                        if ($view_mode == 5) {
                            if ($login_gender == '男性')
                                echo 'color: white; background-color: #5090c0;';
                            else
                                echo 'color: white; background-color: palevioletred;';
                        }
                    ?>
                    ">📝 プロフィール
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="<?php if ($login_gender == '男性') echo 'bgcolor_man_header'; else echo 'bgcolor_woman_header'; ?>">
        <div class="text-align">
            <div class="title_margin">
                <p class="title">Community Space</p>
                <p class="sub_title">-コミュニティー広場-</p>
            </div>
            <div class="header_content_left_status">
                <div class='display_none_phone'>
                    <p class="header_content_left_status_1">🎂 <?php echo $login_birth; ?></p>
                    <p class="header_content_left_status_2">🏠 <?php echo $login_address1 . ' : ' . $login_address2 ; ?></p>
                    <p>📮 <?php echo $login_email; ?></p>
                </div>
            </div>
        </div>
        <div class="<?php if ($login_gender == '男性') echo 'header_content_right_wrapper_man'; else echo 'header_content_right_wrapper_woman';?>">
            <div style="margin-top: 0px;">
                @if ($login_upload_image_name == NULL)
                    @if ($login_gender == '男性')
                        <img class="icon_size" src={{ asset('images/icon_man.png') }}>
                    @else
                        <img class="icon_size" src={{ asset('images/icon_woman.png') }}>
                    @endif
                @else
                    <img class="icon_size" src="<?php echo asset("storage/images/{$login_id}/" . $login_upload_image_name); ?>">
                @endif
            </div>
            <div id="menu" class="menu display_none_pc">
                <div class="div"><a href="#menu" class="open"></a><a href="#close" class="close"></a></div>
                <ul>
                    <div class="<?php if ($login_gender == '男性') echo 'list_personal_status_man'; else echo 'list_personal_status_woman'; ?>">
                        <div>
                            <p class="status_name">{{$login_name}}</p>
                            <p class="status_address">🏠 {{$login_address1}} : {{$login_address2}}</p>
                            <p class="status_email">📮 {{$login_email}}</p>
                            <p class="status_birth">🎂 {{$login_birth}}</p>
                        </div>
                    </div>
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('account.index')}} method="post">
                            @csrf
                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                            <input name="login_id" value="{{$login_id}}" type="hidden">
                            <input name="login_name" value="{{$login_name}}" type="hidden">
                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                            <input name="login_email" value="{{$login_email}}" type="hidden">
                            <input name="login_password" value="{{$login_password}}" type="hidden">
                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                            <input name="login" value="1" type="hidden">
                            <input name="view_mode" value="0" type="hidden">
                            <button>🗯️ つぶやく</button>
                        </form>
                    </li>
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('account.index')}} method="post">
                            @csrf
                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                            <input name="login_id" value="{{$login_id}}" type="hidden">
                            <input name="login_name" value="{{$login_name}}" type="hidden">
                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                            <input name="login_email" value="{{$login_email}}" type="hidden">
                            <input name="login_password" value="{{$login_password}}" type="hidden">
                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                            <input name="login" value="1" type="hidden">
                            <input name="view_mode" value="1" type="hidden">
                            <input name="chat_view" value="0" type="hidden">
                            <button style="
                            <?php
                                $chat_counter_total = 0;

                                for ($i = 0; $i < sizeof($Chat_Data_1); $i++) {
                                    if ($Chat_Data_1[$i]['open'] == NULL && $Chat_Data_1[$i]['to_account_id'] == $login_id)
                                        $chat_counter_total++;
                                }
                            ?>
                            ">💬 チャット <span id="chat_count_total"><?php if ($chat_counter_total != 0) echo '+' . $chat_counter_total; ?></span>
                            </button>
                        </form>
                    </li>
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('account.index')}} method="post">
                            @csrf
                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                            <input name="login_id" value="{{$login_id}}" type="hidden">
                            <input name="login_name" value="{{$login_name}}" type="hidden">
                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                            <input name="login_email" value="{{$login_email}}" type="hidden">
                            <input name="login_password" value="{{$login_password}}" type="hidden">
                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                            <input name="login" value="1" type="hidden">
                            <input name="view_mode" value="2" type="hidden">
                            <input name="page" value="1" type="hidden">
                            <button>🔍 友達検索</button>
                        </form>
                    </li>
                    @if ($login_gender == '男性')
                        <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                            <form action={{route('account.index')}} method="post">
                                @csrf
                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                <input name="login" value="1" type="hidden">
                                <input name="view_mode" value="3" type="hidden">
                                <input name="list_view" value="0" type="hidden">
                                <button>📘 友達リスト</button>
                            </form>
                        </li>
                    @else
                        <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                            <form action={{route('account.index')}} method="post">
                                @csrf
                                <input name="login_birth" value="{{$login_birth}}" type="hidden">
                                <input name="login_id" value="{{$login_id}}" type="hidden">
                                <input name="login_name" value="{{$login_name}}" type="hidden">
                                <input name="login_gender" value="{{$login_gender}}" type="hidden">
                                <input name="login_email" value="{{$login_email}}" type="hidden">
                                <input name="login_password" value="{{$login_password}}" type="hidden">
                                <input name="login_tel" value="{{$login_tel}}" type="hidden">
                                <input name="login_address1" value="{{$login_address1}}" type="hidden">
                                <input name="login_address2" value="{{$login_address2}}" type="hidden">
                                <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                                <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                                <input name="login" value="1" type="hidden">
                                <input name="view_mode" value="3" type="hidden">
                                <input name="list_view" value="0" type="hidden">
                                <button>📕 友達リスト</button>
                            </form>
                        </li>
                    @endif
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('account.index')}} method="post">
                            @csrf
                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                            <input name="login_id" value="{{$login_id}}" type="hidden">
                            <input name="login_name" value="{{$login_name}}" type="hidden">
                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                            <input name="login_email" value="{{$login_email}}" type="hidden">
                            <input name="login_password" value="{{$login_password}}" type="hidden">
                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                            <input name="login" value="1" type="hidden">
                            <input name="view_mode" value="4" type="hidden">
                            <input name="friend_request_view" value="0" type="hidden">
                            <button style="
                            <?php
                                $request_counter = 0;

                                for ($i = 0; $i < sizeof($Friend_Data); $i++) {
                                    if ($Friend_Data[$i]['account_friend_id'] == $login_id && $Friend_Data[$i]['request_flg'] == 1)
                                        $request_counter++;
                                }
                            ?>
                            ">🔔 友達リクエスト <span id="request_counter_phone"><?php if ($request_counter != 0) echo  '+' .$request_counter; ?></span>
                            </button>
                        </form>
                    </li>
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('account.index')}} method="post">
                            @csrf
                            <input name="login_birth" value="{{$login_birth}}" type="hidden">
                            <input name="login_id" value="{{$login_id}}" type="hidden">
                            <input name="login_name" value="{{$login_name}}" type="hidden">
                            <input name="login_gender" value="{{$login_gender}}" type="hidden">
                            <input name="login_email" value="{{$login_email}}" type="hidden">
                            <input name="login_password" value="{{$login_password}}" type="hidden">
                            <input name="login_tel" value="{{$login_tel}}" type="hidden">
                            <input name="login_address1" value="{{$login_address1}}" type="hidden">
                            <input name="login_address2" value="{{$login_address2}}" type="hidden">
                            <input name="login_introduction" value="{{$login_introduction}}" type="hidden">
                            <input name="login_upload_image_name" value="{{$login_upload_image_name}}" type="hidden">
                            <input name="login" value="1" type="hidden">
                            <input name="view_mode" value="5" type="hidden">
                            <button>📝 プロフィール</button>
                        </form>
                    </li>
                    <li class="<?php if ($login_gender == '男性') echo 'menu_item_man'; else echo 'menu_item_woman'; ?>">
                        <form action={{route('database.logout')}} method="post">
                            @csrf
                            <input name="login_email" value={{$login_email}} type="hidden">
                            <button>🚪 ログアウト</button>
                        </form>
                    </li>
                    <div class="item_border_bottom"></div>
                </ul>
            </div>
            <div class="display_none_pc">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="border_{{$i}}"></div>
                @endfor
            </div>
            <div class="display_none_phone">
                <p class="user_name"><?php echo $login_name; ?></p>
                <form action={{route('database.logout')}} method="post">
                    @csrf
                    <input name="login_email" value={{$login_email}} type="hidden">
                    <button >ログアウト</button>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        view_mode = JSON.parse('<?php echo $view_mode_json; ?>');
        chat_view = JSON.parse('<?php echo $chat_view_json; ?>');
        search_view = JSON.parse('<?php echo $search_view_json; ?>');
        list_view = JSON.parse('<?php echo $list_view_json; ?>');
        friend_request_view = JSON.parse('<?php echo $friend_request_view_json; ?>');
        login_id = JSON.parse('<?php echo $login_id_json; ?>');
        list_id = JSON.parse('<?php echo $list_id_json; ?>');
        list_gender = JSON.parse('<?php echo $list_gender_json; ?>');
        list_upload_image_name = JSON.parse('<?php echo $list_upload_image_name_json; ?>');
        if (list_upload_image_name == null) {
            if (list_gender == "男性")
                image_path = "{{ asset('images/icon_man.png') }}";
            else
                image_path = "{{ asset('images/icon_woman.png') }}";
        } else {
            image_path = `{{ asset('storage/images/${list_id}/${list_upload_image_name}') }}`;
        }
        now_chat_detail_data_size_1 = 0;
        now_chat_detail_data_size_2 = 0;
        now_chat_total_data_size = 0;
        now_chat_data_size = 0;
        now_tweet_data_size = 0;
        now_request_data_size = 0;
    </script>
    <script src="{{asset('js/jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/moment.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/realtime.js')}}" type="text/javascript"></script>
</body>
</html>