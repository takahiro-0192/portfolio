function nl2br(str) {
    return str.replace(/[\n]/g, "<br />");
}

now_chat_size = 0;
message_counter = 0;
if (mode == 0 && chat_mode == 1) {
    $.post('../realtime_chat.php', {now_chat_size: now_chat_size, login_id: login_id, list_id: list_id}).done(function(res){
        now_chat_size = res.size;
    });
    if ((message_counter + message_counter_php_1 >= 6) || (message_counter + message_counter_php_2 >= 6))
        scrollTo(0, document.getElementById('chat_area').scrollHeight);
}

setInterval(function () {
    if (mode == 0 && chat_mode == 1) {
        $.post('../realtime_chat_read.php', {login_id: login_id, list_id: list_id}).done(function(res) {
            if (res.opponent_data['login_status'] == 2) {
                for (i = 0; i < res.chat_1.length; i++) {
                    if (res.chat_1[i]['open'] == 0 || res.chat_1[i]['open'] == 2)
                        $("#read1_" + (i + 1)).text("未読");
                    else
                        $("#read1_" + (i + 1)).text("既読");
                }
                for (i = 0; i < res.chat_2.length; i++) {
                    if (res.chat_2[i]['open'] == 0 || res.chat_2[i]['open'] == 2)
                        $("#read2_" + (i + 1)).text("未読");
                    else
                        $("#read2_" + (i + 1)).text("既読");
                }
            }
        });
        $.post('../realtime_chat.php', {now_chat_size: now_chat_size, login_id: login_id, list_id: list_id}).done(function(res){
            if (res.flg == 1) {
                time = new Date(res.time.replace(/-/g,"/"));
                hours = time.getHours();
                hours = ("0" + hours).slice(-2);
                minutes = time.getMinutes();
                minutes = ("0" + minutes).slice(-2);
                $("#message").append(
                    "<div class='chat_style_2'>" +
                        "<div class='margin'>" +
                            nl2br(res.message) +
                        "</div>" +
                        "<div class='time'>" +
                            "<p>" + hours + ":" + minutes + "</p>" +
                        "</div>" +
                    "</div>"
                );
                message_counter++;
                if ((message_counter + message_counter_php_1 >= 6) || (message_counter + message_counter_php_2 >= 6))
                    scrollTo(0, document.getElementById('chat_area').scrollHeight);
            }
            now_chat_size = res.size;
        });
    }
}, 500);


