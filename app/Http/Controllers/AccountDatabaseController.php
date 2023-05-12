<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\AccountModel;
use App\Models\Chat_1Model;
use App\Models\Chat_2Model;
use App\Models\MemoryChatModel;
use App\Models\TweetModel;
use App\Models\FriendListModel;
use DateTime;

class AccountDatabaseController extends Controller
{
    function create_check(Request $request)
    {
        $select_null_year = NULL;
        $select_null_month = NULL;
        $select_null_day = NULL;
        $select_null_gender = NULL;
        $name_miss = NULL;
        $email_miss = NULL;
        $password_miss = NULL;
        $password_retype_miss = NULL;

        if ($request->year == '選択してください')
            $select_null_year = 1;
        if ($request->month == '選択してください')
            $select_null_month = 1;
        if ($request->day == '選択してください')
            $select_null_day = 1;
        if ($request->gender == '選択してください')
            $select_null_gender = 1;

        if (empty($request->name))
            $name_miss = 1;
        if (empty($request->email))
            $email_miss = 1;
        if (empty($request->password))
            $password_miss = 1;
        if (empty($request->password_retype))
            $password_retype_miss = 1;

        if (mb_strlen($request->name) > 10)
            $name_miss = 2;
        if (mb_strlen($request->email) > 30)
            $email_miss = 2;
        if (mb_strlen($request->password) > 255)
            $password_miss = 2;
        if (mb_strlen($request->password) < 4 && !empty($request->password))
            $password_miss = 3;
        if (mb_strlen($request->password_retype) > 255)
            $password_retype_miss = 2;
        if (mb_strlen($request->password_retype) < 4 && !empty($request->password_retype))
            $password_retype_miss = 3;

        $Account_Data = AccountModel::all();
        for ($i = 0; $i < sizeof($Account_Data); $i++) {
            if ($request->email == $Account_Data[$i]['email'])
                $email_miss = 3;
        }

        if ($password_miss == NULL && $password_miss != 3 && $password_retype_miss == NULL && $password_retype_miss != 3) {
            if ($request->password != $request->password_retype)
                $password_miss = 4;
        }

        if ($select_null_year == NULL && $select_null_month == NULL && $select_null_day == NULL && $select_null_gender == NULL &&
            $name_miss == NULL && $email_miss == NULL && $password_miss == NULL && $password_retype_miss == NULL) {

            DB::table('accounts')->insert([
                'birth_day' => $request->year . '年' . $request->month . '月' . $request->day . '日',
                'name' => $request->name,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => password_hash($request->password, PASSWORD_DEFAULT),
                'tel' => '未設定',
                'introduction' => 'よろしくお願い致します',
                'address1' => '未設定',
                'address2' => '未設定',
                'upload_image_name' => NULL,
                'login_status' => 0
            ]);

            return view('account/login', ['email_MISS' => NULL, 'password_MISS' => NULL]);
        } else
            return view('account/create_account', ['select_year' => $select_null_year, 'select_month' => $select_null_month, 'select_day' => $select_null_day, 'select_gender' => $select_null_gender, 'name_MISS' => $name_miss, 'email_MISS' => $email_miss, 'password_MISS' => $password_miss, 'password_retype_MISS' => $password_retype_miss]);
    }

    function login_check(Request $request)
    {
        $email_miss = NULL;
        $password_miss = NULL;

        if ($request->email == NULL)
            $email_miss = 1;
        if (mb_strlen($request->email) > 30)
            $email_miss = 3;

        if ($request->password == NULL)
            $password_miss = 1;
        if (mb_strlen($request->password) > 255)
            $password_miss = 3;

        if ($email_miss == NULL && $password_miss == NULL) {
            $Account_Data = AccountModel::all();
            $email_miss_counter = 0;
            $password_counter = 0;
            for ($i = 0; $i < sizeof($Account_Data); $i++) {
                if ($request->email == $Account_Data[$i]['email']) {
                    if (password_verify($request->password, $Account_Data[$i]['password'])) {
                        DB::table('accounts')->where('id', $Account_Data[$i]['id'])->update([
                            'login_status' => 1
                        ]);
                        return view('account/index', [
                            'login_birth' => $Account_Data[$i]['birth_day'],
                            'login_id' => $Account_Data[$i]['id'],
                            'login_name' => $Account_Data[$i]['name'],
                            'login_gender' => $Account_Data[$i]['gender'],
                            'login_email' => $request->email,
                            'login_password' => $request->password,
                            'login_tel' => $Account_Data[$i]['tel'],
                            'login_address1' => $Account_Data[$i]['address1'],
                            'login_address2' => $Account_Data[$i]['address2'],
                            'login_introduction' => $Account_Data[$i]['introduction'],
                            'login_upload_image_name' => $Account_Data[$i]['upload_image_name'],
                            'list_birth' => NULL,
                            'list_id' => NULL,
                            'list_name' => NULL,
                            'list_gender' => NULL,
                            'list_email' => NULL,
                            'list_password' => NULL,
                            'list_tel' => NULL,
                            'list_address1' => NULL,
                            'list_address2' => NULL,
                            'list_introduction' => NULL,
                            'list_upload_image_name' => NULL,
                            'Account_Data' => $Account_Data,
                            'Tweet_Data' => TweetModel::latest('created_at')->get(),
                            'Friend_Data' => FriendListModel::latest('created_at')->get(),
                            'Chat_Data_1' => Chat_1Model::all(),
                            'Chat_Data_2' => Chat_2Model::all(),
                            'Memory_Chat_Data' => MemoryChatModel::all(),
                            'view_mode' => 0,
                            'view_edit' => 0,
                            'login' => 1,
                            'search_page' => 1,
                            'tweet_MISS' => NULL,
                            'edit_now_password_MISS' => NULL,
                            'edit_new_password_MISS' => NULL,
                            'edit_new_password_retype_MISS' => NULL,
                            'edit_success' => NULL
                        ]);
                    } else
                        return view('account/login', ['email_MISS' => $email_miss, 'password_MISS' => 2]);
                } else
                    $email_miss_counter++;
            }
            if ($email_miss_counter == sizeof($Account_Data))
                return view('account/login', ['email_MISS' => 2, 'password_MISS' => $password_miss]);
        } else
            return view('account/login', ['email_MISS' => $email_miss, 'password_MISS' => $password_miss]);
    }

    function logout(Request $request)
    {
        DB::table('accounts')->where('email', $request->login_email)->update([
            'login_status' => 0
        ]);

        return view('account/login', ['email_MISS' => NULL, 'password_MISS' => NULL]);
    }

    function regist_tweet(Request $request)
    {
        $tweet_miss = NULL;

        if ($request->tweet == NULL)
            $tweet_miss = 1;
        else if (mb_strlen($request->tweet) > 1000)
            $tweet_miss = 2;
        else {
            $tweet_miss = 3;
            $Account_Data = AccountModel::all();
            for ($i = 0; $i < sizeof($Account_Data); $i++) {
                if ($request->login_email == $Account_Data[$i]['email'])
                    $id = $Account_Data[$i]['id'];
            }

            DB::table('tweet')->insert([
                'account_id' => $id,
                'tweet' => $request->tweet,
                'created_at' => date("Y/m/d H:i:s"),
                'updated_at' => date("Y/m/d H:i:s")
            ]);
        }
        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => $tweet_miss
        ]);
    }

    function delete_tweet(Request $request)
    {
        if ($request->tweet_delete_all != 1)
            DB::table('tweet')->where('id', $request->tweet_id)->where('account_id', $request->login_id)->delete();
        else
            DB::table('tweet')->where('account_id', $request->login_id)->delete();

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => NULL
        ]);
    }

    function send_message(Request $request)
    {
        $memory_counter = [0, 0];
        $chat_miss = NULL;

        if ($request->message != NULL && $request->message != '未入力です' && $request->message != '3000字以内入力してください'
            && mb_strlen($request->message) <= 3000) {
            DB::table('chat_1')->insert([
                'chat' => $request->message,
                'history_no' => $request->list_id,
                'account_id' => $request->login_id,
                'to_account_id' => $request->list_id,
                'created_at' => date("Y/m/d H:i:s"),
                'updated_at' => date("Y/m/d H:i:s")
            ]);

            DB::table('chat_2')->insert([
                'chat' => $request->message,
                'history_no' => $request->list_id,
                'account_id' => $request->login_id,
                'to_account_id' => $request->list_id,
                'created_at' => date("Y/m/d H:i:s"),
                'updated_at' => date("Y/m/d H:i:s")
            ]);

            $Chat_All_1 = Chat_1Model::all();
            $Chat_All_2 = Chat_2Model::all();
            if (sizeof($Chat_All_1) != 0) {
                for ($i = 0; $i < sizeof($Chat_All_1); $i++) {
                    if (($request->login_id == $Chat_All_1[$i]['account_id'] && $request->list_id == $Chat_All_1[$i]['to_account_id']) ||
                        ($request->list_id == $Chat_All_1[$i]['account_id'] && $request->login_id == $Chat_All_1[$i]['to_account_id']))
                        $memory_counter[0]++;
                }
            }
            if (sizeof($Chat_All_2) != 0) {
                for ($i = 0; $i < sizeof($Chat_All_2); $i++) {
                    if (($request->login_id == $Chat_All_2[$i]['account_id'] && $request->list_id == $Chat_All_2[$i]['to_account_id']) ||
                        ($request->list_id == $Chat_All_2[$i]['account_id'] && $request->login_id == $Chat_All_2[$i]['to_account_id']))
                        $memory_counter[1]++;
                }
            }
            $date = new DateTime();
            $Chat_Data_1 = Chat_1Model::where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->get();
            $Chat_Data_2 = Chat_1Model::where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->get();
            $Chat_Data_3 = Chat_2Model::where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->get();
            $Chat_Data_4 = Chat_2Model::where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->get();
            if ((sizeof($Chat_Data_1) == 1 || sizeof($Chat_Data_2) == 1) && (sizeof($Chat_Data_3) == 1 || sizeof($Chat_Data_4) == 1)) {
                $Memory_1 = DB::table('memory_chat')->where("account_id", $request->login_id)->where("from_account_id", $request->list_id)->get();
                $Memory_2 = DB::table('memory_chat')->where("account_id", $request->list_id)->where("from_account_id", $request->login_id)->get();
                if (sizeof($Memory_1) == 0 && sizeof($Memory_2) == 0) {
                    if (sizeof($Chat_Data_1) == 1 || sizeof($Chat_Data_3) == 1) {
                        if ($memory_counter[0] == 1 && $memory_counter[1] == 1) {
                            DB::table('memory_chat')->insert([
                                'account_id' => $request->login_id,
                                'from_account_id' => $request->list_id,
                                'created_at' => $date->format("Y/m/d H:i:s"),
                                'updated_at' => $date->format("Y/m/d H:i:s")
                            ]);
                        }
                    }
                    if (sizeof($Chat_Data_2) == 1 || sizeof($Chat_Data_4) == 1) {
                        if ($memory_counter[0] == 1 && $memory_counter[1] == 1) {
                            DB::table('memory_chat')->insert([
                                'account_id' => $request->list_id,
                                'from_account_id' => $request->login_id,
                                'created_at' => $date->format("Y/m/d H:i:s"),
                                'updated_at' => $date->format("Y/m/d H:i:s")
                            ]);
                        }
                    }
                }
            }
        } else if ($request->message == NULL || $request->message == '未入力です')
            $chat_miss = 1;
        else if (mb_strlen($request->message) > 3000 || $request->message == '3000字以内入力してください')
            $chat_miss = 2;

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_birth' => $request->list_birth,
            'list_id' => $request->list_id,
            'list_name' => $request->list_name,
            'list_gender' => $request->list_gender,
            'list_email' => $request->list_email,
            'list_password' => $request->list_password,
            'list_tel' => $request->list_tel,
            'list_address1' => $request->list_address1,
            'list_address2' => $request->list_address2,
            'list_introduction' => $request->list_introduction,
            'list_upload_image_name' => $request->list_upload_image_name,
            'Account_Data' => AccountModel::all(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'list_view' => $request->list_view,
            'friend_request_view' => $request->friend_request_view,
            'view_edit' => $request->view_edit,
            'chat_view' => $request->chat_view,
            'search_view' => $request->search_view,
            'login' => $request->login,
            'search_view' => $request->search_view,
            'login_id_flg' => NULL,
            'tweet_MISS' => NULL,
            'chat_MISS' => $chat_miss
        ]);
    }

    function clear_message(Request $request)
    {
        $Memory_Chat_All = MemoryChatModel::all();

        if ($request->flg == 0) {
            DB::table('chat_1')->where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->delete();
            DB::table('chat_1')->where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->delete();
        } else {
            DB::table('chat_2')->where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->delete();
            DB::table('chat_2')->where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->delete();
        }


        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_birth' => $request->list_birth,
            'list_id' => $request->list_id,
            'list_name' => $request->list_name,
            'list_gender' => $request->list_gender,
            'list_email' => $request->list_email,
            'list_password' => $request->list_password,
            'list_tel' => $request->list_tel,
            'list_address1' => $request->list_address1,
            'list_address2' => $request->list_address2,
            'list_introduction' => $request->list_introduction,
            'list_upload_image_name' => $request->list_upload_image_name,
            'Account_Data' => AccountModel::all(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'list_view' => $request->list_view,
            'friend_request_view' => $request->friend_request_view,
            'view_edit' => $request->view_edit,
            'chat_view' => $request->chat_view,
            'search_view' => $request->search_view,
            'login' => $request->login,
            'search_view' => $request->search_view,
            'login_id_flg' => NULL,
            'tweet_MISS' => NULL,
            'chat_MISS' => NULL
        ]);
    }

    function get_message_total(Request $request)
    {
        $Chat_Data = CHat_1Model::where("open", NULL)->where("to_account_id", $request->login_id)->get();

        if ($request->now_chat_total_data_size == sizeof($Chat_Data))
            $flg = 0;
        else
            $flg = 1;

        $chat = ["size" => sizeof($Chat_Data), "flg" => $flg];
        return response()->json($chat);
    }

    function get_message_detail_1(Request $request)
    {
        $Chat_Data = DB::table("chat_1")->where("open", NULL)->where("to_account_id", $request->login_id)->get();

        if ($request->now_chat_detail_data_size_1 == sizeof($Chat_Data))
            $flg = 0;
        else
            $flg = 1;


        $chat = ["size" => sizeof($Chat_Data), "flg" => $flg];
        return response()->json($chat);
    }

    function get_message_detail_2(Request $request)
    {
        $Chat_Data = DB::table("chat_1")->where("open", NULL)->where("account_id", $request->login_id)->get();

        if ($request->now_chat_detail_data_size_2 == sizeof($Chat_Data))
            $flg = 0;
        else
            $flg = 1;

        $chat = ["size" => sizeof($Chat_Data), "flg" => $flg];
        return response()->json($chat);
    }

    function chat_open_check (Request $request)
    {
        $Account_Data = AccountModel::where("id", $request->list_id)->where("login_status", 2)->get();
        $Chat_Data = Chat_1Model::where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->where("open", NULL)->get();

        if (sizeof($Account_Data) == 0 && sizeof($Chat_Data) != 0)
            $text = '未読';
        else
            $text = '既読';

        $chat = ["text" => $text];
        return response()->json($chat);
    }

    function get_message(Request $request)
    {
        $Chat_Counter = [0, 0, 0];
        $Chat_Login_Data = DB::table("chat_1")->where("account_id", $request->login_id)->where("to_account_id", $request->list_id)->get();
        $Chat_List_Data = DB::table("chat_1")->where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->get();

        DB::table("chat_1")->where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->update([
            "open" => 1
        ]);
        DB::table("chat_2")->where("account_id", $request->list_id)->where("to_account_id", $request->login_id)->update([
            "open" => 1
        ]);

        $Chat_All = Chat_1Model::all();
        for ($i = 0; $i < sizeof($Chat_All); $i++) {
            if (($Chat_All[$i]['account_id'] == $request->list_id && $Chat_All[$i]['to_account_id'] == $request->login_id) ||
                ($Chat_All[$i]['account_id'] == $request->login_id && $Chat_All[$i]['to_account_id'] == $request->list_id)) {
                $Chat_Counter[0]++;
            }
        }
        if ($Chat_Counter[0] == $request->now_chat_data_size)
            $flg = 0;
        else
            $flg = 1;
        for ($i = sizeof($Chat_All) - 1; $i >= 0; $i--) {
            if ($Chat_All[$i]['account_id'] == $request->list_id && $Chat_All[$i]['to_account_id'] == $request->login_id) {
                $open = $Chat_All[$i]['open'];
                $index = $i;
                break;
            }
        }
        if ($Chat_Counter[0] != 0) {
            if (sizeof($Chat_Login_Data) != 0 && sizeof($Chat_List_Data) == 0) {
                $chat = ["size" => $Chat_Counter[0], "size_login" => sizeof($Chat_Login_Data), "size_list" => sizeof($Chat_List_Data), "flg" => $flg];
                return response()->json($chat);
            }else{
                $chat = ["size" => $Chat_Counter[0], "size_login" => sizeof($Chat_Login_Data), "size_list" => sizeof($Chat_List_Data), "open" => $open, "date" => $Chat_All[$index]['created_at']->format('Y/m/d H:m:s'), "text" => $Chat_All[$index]['chat'], "flg" => $flg];
                return response()->json($chat);
            }
        } else {
            $chat = ["size" => $Chat_Counter[0], "flg" => $flg];
            return response()->json($chat);
        }
    }

    function get_tweet(Request $request)
    {
        $Tweet_Data = DB::table("tweet")->where("account_id", $request->list_id)->get();
        if (sizeof($Tweet_Data) == $request->now_tweet_data_size)
            $flg = 0;
        else
            $flg = 1;

        $Tweet_All = TweetModel::all();
        for ($i = sizeof($Tweet_All) - 1; $i>= 0; $i--) {
            if ($Tweet_All[$i]['account_id'] == $request->list_id) {
                $index = $i;
                break;
            }
        }

        if (sizeof($Tweet_Data) != 0) {
            $tweet = ["size" => sizeof($Tweet_Data), "date" => $Tweet_All[$index]['created_at'], "text" => $Tweet_All[$index]['tweet'], "flg" => $flg];
            return response()->json($tweet);
        } else {
            $tweet = ["size" => sizeof($Tweet_Data), "flg" => $flg];
            return response()->json($tweet);
        }
    }

    function get_request(Request $request)
    {
        $Request_Data = DB::table("friend_list")->where("account_friend_id", $request->login_id)->where("request_flg", 1)->get();
        if (sizeof($Request_Data) == $request->now_request_data_size)
            $flg = 0;
        else {
            $flg = 1;
        }

        $req = ["size" => sizeof($Request_Data), "flg" => $flg];
        return response()->json($req);
    }

    function search_account(Request $request)
    {
        if ($request->search != NULL)
            $Account_Data = AccountModel::where('name', 'like', "%$request->search%")->orwhere('address1', 'like', "%$request->search%")->orwhere('address2', 'like', "%$request->search%")->orwhere('gender', 'like', "%$request->search%")->get();
        else
            $Account_Data = AccountModel::all();

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'search_view' => $request->search_view,
            'search_title' => $request->search,
            'Account_Data' => $Account_Data,
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => NULL
        ]);
    }

    function send_friend_request(Request $request)
    {
        DB::table('friend_list')->insert([
            'account_id' => $request->login_id,
            'account_friend_id' => $request->list_id,
            'request_flg' => 1,
            'approval_flg' => 0,
            'created_at' => date("Y/m/d H:i:s"),
            'updated_at' => date("Y/m/d H:i:s"),
        ]);

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_id' => $request->list_name,
            'list_name' => $request->list_name,
            'search_view' => $request->search_view,
            'search_title' => $request->search,
            'Account_Data' => AccountModel::all(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
        ]);
    }

    function delete_request(Request $request)
    {
        DB::table('friend_list')->where('id', $request->request_id)->delete();

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_id' => $request->list_id,
            'list_name' => $request->list_name,
            'search_view' => $request->search_view,
            'search_title' => $request->search,
            'Account_Data' => AccountModel::all(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'friend_request_view' => $request->friend_request_view,
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => NULL
        ]);
    }

    function approval_friend(Request $request)
    {
        DB::table('friend_list')->where('id', $request->request_id)->update([
            'approval_flg' => 1,
            'request_flg' => 0
        ]);

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_id' => $request->list_id,
            'list_name' => $request->list_name,
            'search_view' => $request->search_view,
            'search_title' => $request->search,
            'Account_Data' => AccountModel::all(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'friend_request_view' => $request->friend_request_view,
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => NULL
        ]);
    }

    function delete_friend(Request $request)
    {
        DB::table('friend_list')->where('id', $request->friend_id)->delete();

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'list_name' => $request->list_name,
            'list_view' => $request->list_view,
            'search_view' => $request->search_view,
            'search_title' => $request->search,
            'Account_Data' => AccountModel::all(),
            'Friend_Data' => FriendListModel::latest('created_at')->get(),
            'Tweet_Data' => TweetModel::latest('created_at')->get(),
            'Chat_Data_1' => Chat_1Model::all(),
            'Chat_Data_2' => Chat_2Model::all(),
            'Memory_Chat_Data' => MemoryChatModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'tweet_MISS' => NULL
        ]);

    }

    function update_status(Request $request)
    {
        $image_edit = NULL;
        $birth_miss = NULL;
        $name_miss = NULL;
        $tel_miss = NULL;
        $address2_miss = NULL;
        $introduction_miss = NULL;
        $edit_address1 = NULL;
        $new_image_name = $request->upload_image_name;
        $new_birth = $request->login_birth;
        $new_name = $request->login_name;
        $new_tel = $request->login_tel;
        $new_address1 = $request->login_address1;
        $new_address2 = $request->login_address2;
        $new_introduction = $request->login_introduction;

        if ($request->file('upload_image') != NULL) {
            $path = Storage::putFile("public/images/{$request->login_id}", $request->file('upload_image'));
            $new_image_name = basename($path);
            DB::table('accounts')->where('id', $request->login_id)->update([
                'upload_image_name' => $new_image_name
            ]);
            $image_edit = 1;
        }

        if (!($request->new_year != '選択してください' && $request->new_month != '選択してください' && $request->new_day != '選択してください')) {
            if ($request->new_year != '選択してください' || $request->new_month != '選択してください' || $request->new_day != '選択してください')
                $birth_miss = 1;
        } else {
            $birth_miss = 2;
            $new_birth = $request->new_year . '年' . $request->new_month . '月' . $request->new_day . '日';
            DB::table('accounts')->where('email', $request->login_email)->update([
                'birth_day' => $new_birth
            ]);
        }

        if (mb_strlen($request->new_name) > 10)
            $name_miss = 1;
        else if ($request->new_name != NULL){
            $name_miss = 2;
            $new_name = $request->new_name;
            DB::table('accounts')->where('email', $request->login_email)->update([
                'name' => $new_name
            ]);
        }

        if (mb_strlen($request->new_tel) > 11)
            $tel_miss = 1;
        else if ($request->new_tel != NULL){
            $tel_miss = 2;
            $new_tel = $request->new_tel;
            DB::table('accounts')->where('email', $request->login_email)->update([
                'tel' => $new_tel
            ]);
        }

        if ($request->new_address1 != '選択してください') {
            $edit_address1 = 1;
            $new_address1 = $request->new_address1;
            DB::table('accounts')->where('email', $request->login_email)->update([
                'address1' => $new_address1
            ]);
        }

        if (mb_strlen($request->new_address2) > 10)
            $address2_miss = 1;
        else if ($request->new_address2 != NULL) {
            $address2_miss = 2;
            $new_address2 = $request->new_address2;
            DB::table('accounts')->where('email', $request->login_email)->update([
                'address2' => $new_address2
            ]);
        }

        $Account_Data = AccountModel::all();
        for ($i = 0; $i < sizeof($Account_Data); $i++){
            if ($request->login_email == $Account_Data[$i]['email'])
                $Index = $i;
        }
        if (mb_strlen($request->new_introduction) > 1000)
            $introduction_miss = 1;
        else if ($request->new_introduction != NULL && $request->new_introduction != $Account_Data[$Index]['introduction']){
            $introduction_miss = 2;
            $new_introduction = $request->new_introduction;
            DB::table('accounts')->where('email', $request->login_email)->update([
                'introduction' => $new_introduction
            ]);
        }

        return view('account/index', [
            'login_birth' => $new_birth,
            'login_id' => $request->login_id,
            'login_name' => $new_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $new_tel,
            'login_address1' => $new_address1,
            'login_address2' => $new_address2,
            'login_introduction' => $new_introduction,
            'login_upload_image_name' => $new_image_name,
            'Account_Data' => AccountModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'edit_image' => $image_edit,
            'edit_status_birth_MISS' => $birth_miss,
            'edit_status_name_MISS' => $name_miss,
            'edit_status_tel_MISS' => $tel_miss,
            'edit_status_address2_MISS' => $address2_miss,
            'edit_address1' => $edit_address1,
            'edit_status_introduction_MISS' => $introduction_miss
        ]);
    }

    function update_password(Request $request)
    {
        $now_password_miss = NULL;
        $new_password_miss = NULL;
        $new_password_retype_miss = NULL;
        $edit_success = NULL;

        if ($request->password_now == NULL)
            $now_password_miss = 1;
        else if (mb_strlen($request->password_now) > 255)
            $now_password_miss = 3;
        $Account_Data = AccountModel::all();
        for ($i = 0; $i < sizeof($Account_Data); $i++) {
            if ($request->login_email == $Account_Data[$i]['email']) {
                if (!password_verify($request->password_now, $Account_Data[$i]['password']))
                    $now_password_miss = 2;
            }
        }

        if ($request->password_new == NULL)
            $new_password_miss = 1;
        else if (mb_strlen($request->password_new) < 4)
            $new_password_miss = 2;
        else if (mb_strlen($request->password_new) > 255)
            $new_password_miss = 3;

        if ($request->password_new_retype == NULL)
            $new_password_retype_miss = 1;
        else if (mb_strlen($request->password_new_retype) < 4)
            $new_password_retype_miss = 2;
        else if (mb_strlen($request->password_new_retype) > 255)
            $new_password_retype_miss = 3;

        if ($now_password_miss == NULL && $new_password_miss == NULL && $new_password_retype_miss == NULL) {
            if ($request->password_new != $request->password_new_retype)
                $new_password_miss = 4;
            else {
                DB::table('accounts')->where('email', $request->login_email)->update([
                    'password' => password_hash($request->password_new ,PASSWORD_DEFAULT)
                ]);

                $edit_success = 1;
            }
        }

        return view('account/index', [
            'login_birth' => $request->login_birth,
            'login_id' => $request->login_id,
            'login_name' => $request->login_name,
            'login_gender' => $request->login_gender,
            'login_email' => $request->login_email,
            'login_password' => $request->login_password,
            'login_tel' => $request->login_tel,
            'login_address1' => $request->login_address1,
            'login_address2' => $request->login_address2,
            'login_introduction' => $request->login_introduction,
            'login_upload_image_name' => $request->login_upload_image_name,
            'Account_Data' => AccountModel::all(),
            'view_mode' => $request->view_mode,
            'view_edit' => $request->view_edit,
            'login' => $request->login,
            'edit_now_password_MISS' => $now_password_miss,
            'edit_new_password_MISS' => $new_password_miss,
            'edit_new_password_retype_MISS' => $new_password_retype_miss,
            'edit_success' => $edit_success
        ]);
    }

    function delete_account(Request $request)
    {
        DB::table('tweet')->where('account_id', $request->login_id)->delete();

        DB::table('chat')->where('account_id', $request->login_id)->delete();
        DB::table('chat')->where('to_account_id', $request->login_id)->delete();

        DB::table('memory_chat')->where('account_id', $request->login_id)->delete();
        DB::table('memory_chat')->where('from_account_id', $request->login_id)->delete();

        DB::table('friend_list')->where('account_id', $request->login_id)->delete();
        DB::table('friend_list')->where('account_friend_id', $request->login_id)->delete();


        DB::table('accounts')->where('email', $request->login_email)->delete();

        return view('account/login', ['email_MISS' => NULL, 'password_MISS' => NULL]);
    }
}