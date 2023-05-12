
function nl2br(str) {
    return str.replace(/[\n]/g, "<br />");
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "POST"
});
if ((view_mode == 2 && search_view == 3) || (view_mode == 3 && list_view == 2) || (view_mode == 4 && friend_request_view == 2)){
    $.ajax({
        url: "/database/get_tweet",
        data: {"list_id": list_id},
        success: tweet_data => {
            now_tweet_data_size = tweet_data.size;
        }
    });
}
$.ajax({
    url: "/database/get_message_total",
    data: {"list_id": list_id, "login_id": login_id},
    success: chat_total_data => {
            now_chat_total_data_size = chat_total_data.size;
    }
});
if ((view_mode == 1 && chat_view == 1) || (view_mode == 2 && search_view == 4) || (view_mode == 3 && list_view == 3)) {
    $.ajax({
        url: "/database/get_message",
        data: {"now_chat_data_size" : now_chat_data_size, "login_id": login_id, "list_id": list_id},
        success: chat_data => {
            now_chat_data_size = chat_data.size;
        }
    });
}
if (view_mode == 1 && chat_view == 0) {
    $.ajax({
        url: "/database/get_message_detail_1",
        data: {"now_chat_detail_data_size_1": now_chat_detail_data_size_1, "login_id": login_id},
        success: chat_detail_data_1 => {
            now_chat_detail_data_size_1 = chat_detail_data_1.size;
        }
    });
    $.ajax({
        url: "/database/get_message_detail_2",
        data: {"now_chat_detail_data_size_2": now_chat_detail_data_size_2, "login_id": login_id},
        success: chat_detail_data_2 => {
            now_chat_detail_data_size_2 = chat_detail_data_2.size;
        }
    });
}

setInterval(function() {
    $.ajax({
        url: "/database/get_request",
        data: {"now_request_data_size": now_request_data_size, "login_id": login_id},
        success: request_data => {
            if (request_data.flg == 1) {
                $("#request_counter_phone").text('+' + request_data.size);
                $("#request_counter_pc").text('+' + request_data.size);
                if (request_data.size != 0) {
                    if (now_request_data_size != 0)
                        $("#request_list").text('新着リクエストがあります。ページをリロードしてください。');
                }
                if (request_data.size != 0)
                    $("#receive_null").text('');

                now_request_data_size = request_data.size;
            } else {
                if (request_data.size == 1)
                    $("#receive_null").text('新着リクエストがあります。ページをリロードしてください。');
            }
        }
    });
    if (view_mode == 1 && chat_view == 0) {
        $.ajax({
            url: "/database/get_message_detail_1",
            data: {"now_chat_detail_data_size_1": now_chat_detail_data_size_1, "login_id": login_id},
            success: chat_detail_data_1 => {
                if (chat_detail_data_1.flg == 1) {
                    if (chat_detail_data_1.size != 0)
                        $("#chat_not_open").text("新着メッセージがあります。確認するにはページをリロードしてください。");

                    now_chat_detail_data_size_1 = chat_detail_data_1.size;
                }
            }
        });
    }
    if ((view_mode == 2 && search_view == 3) || (view_mode == 3 && list_view == 2) || (view_mode == 4 && friend_request_view == 2) || (view_mode == 4 && friend_request_view == 2)){
        $.ajax({
            url: "/database/get_tweet",
            data: {"now_tweet_data_size": now_tweet_data_size, "list_id": list_id},
            success: tweet_data => {
                if (tweet_data.flg == 1) {
                    date_1 = moment(tweet_data.date, "YYYY-MM-DD");
                    date_db_1 = date_1.format("YYYY-MM-DD");
                    time = new Date(tweet_data.date);
                    hours = time.getHours();
                    hours =  ("0" + hours).slice(-2);
                    minutes = time.getMinutes();
                    minutes =  ("0" + minutes).slice(-2);
                    seconds = time.getSeconds();
                    seconds =  ("0" + seconds).slice(-2);
                    $("#tweet_list").prepend(
                        "<div class='regist_date_tweet'>投稿日時 : " + date_db_1 + ' ' + hours + ':' + minutes + ':' + seconds + "</div>" +
                        "<div class='mumble_box' >" +
                            "<div class='padding'>" + nl2br(tweet_data.text) + "</div>" +
                        "</div>"
                    );
                    now_tweet_data_size = tweet_data.size;
                }
            }
        });
    }
    $.ajax({
        url: "/database/get_message_total",
        data: {"now_chat_total_data_size": now_chat_total_data_size,"login_id": login_id, "view_mode": view_mode, "chat_view": chat_view},
        success: chat_total_data => {
            if (chat_total_data.flg == 1) {
                if (chat_total_data.size != 0)
                    $("#chat_count_total").text('+' + chat_total_data.size);
                now_chat_total_data_size = chat_total_data.size;
            }
        }
    });
    $.ajax({
        url: "/database/chat_open_check",
        data: {"login_id": login_id, "list_id": list_id},
        success: open_check => {
            $(".not_open").text(open_check.text);
        }
    });
    if ((view_mode == 1 && chat_view == 1) || (view_mode == 2 && search_view == 4) || (view_mode == 3 && list_view == 3)) {
        $.ajax({
            url: "/database/get_message",
            data: {"now_chat_data_size": now_chat_data_size, "login_id": login_id, "list_id": list_id},
        }).then(function(res){
            if (res.flg == 1) {
                time = new Date(res.date);
                hours = time.getHours();
                hours =  ("0" + hours).slice(-2);
                minutes = time.getMinutes();
                minutes =  ("0" + minutes).slice(-2);
                if (res.size == 1) {
                    document.getElementById('chat_send').value = '';
                    document.forms["chat_send"].submit();
                } else if (res.size > 1) {
                    if (res.size_list != 0) {
                        $("#chat_list").append(
                            "<div class='realtime position_left'>" +
                                "<img class='icon_size' src=" + image_path + ">" +
                                "<div class='chat_style_2'>" +
                                    "<div class='margin'>" +
                                        nl2br(res.text) +
                                    "</div>" +
                                "</div>" +
                                "<div class='position_bottom font-size-time margin-left'>" +
                                    hours + ":" + minutes +
                                "</div>" +
                            "</div>"
                        );
                        scrollTo(0, document.getElementById('chat').scrollHeight);
                        now_chat_data_size = res.size;
                    }
                }
            }
        });
    }
}, 300);

if ((view_mode == 1 && chat_view == 1) || (view_mode == 2 && search_view == 4) || (view_mode == 3 && list_view == 3) || (view_mode == 4 && friend_request_view == 3))
    scrollTo(0, document.getElementById('chat').scrollHeight);
