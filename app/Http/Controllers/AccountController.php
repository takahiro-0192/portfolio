<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountModel;
use App\Models\TweetModel;
use App\Models\Chat_1Model;
use App\Models\Chat_2Model;
use App\Models\MemoryChatModel;
use App\Models\FriendListModel;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    function index(Request $request)
    {
        $login = 0;
        if ($request->login != NULL) {
            $login = $request->login;
            $page = 1;
        }

        if ($request->login == 1 && $login == 1) {
            $Account_Data = AccountModel::all();
            if ($request->view_mode == 1 && $request->chat_view == 1 || ($request->view_mode == 2 && $request->search_view == 4) || ($request->view_mode == 3 && $request->list_view == 3)) {
                DB::table("chat_1")->where("to_account_id", $request->login_id)->where("account_id", $request->list_id)->update(["open" => 1]);
                DB::table("chat_2")->where("to_account_id", $request->login_id)->where("account_id", $request->list_id)->update(["open" => 1]);
                DB::table("accounts")->where("id", $request->login_id)->update(["login_status" => 2]);
            } else {
                DB::table("accounts")->where("id", $request->login_id)->update(["login_status" => 1]);
            }
            if ($request->page != NULL)
                $page = $request->page;
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
                'Account_Data' => $Account_Data,
                'Tweet_Data' => TweetModel::latest('created_at')->get(),
                'Friend_Data' => FriendListModel::latest('created_at')->get(),
                'Chat_Data_1' => Chat_1Model::all(),
                'Chat_Data_2' => Chat_2Model::all(),
                'Memory_Chat_Data' => MemoryChatModel::all(),
                'view_mode' => $request->view_mode,
                'list_view' => $request->list_view,
                'view_edit' => $request->view_edit,
                'chat_view' => $request->chat_view,
                'login' => $login,
                'search_view' => $request->search_view,
                'friend_request_view' => $request->friend_request_view,
                'login_id_flg' => NULL,
                'search_title' => NULL,
                'tweet_MISS' => NULL,
                'chat_MISS' => NULL,
                'edit_image' => NULL,
                'edit_now_password_MISS' => NULL,
                'edit_new_password_MISS' => NULL,
                'edit_new_password_retype_MISS' => NULL,
                'edit_status_birth_MISS' => NULL,
                'edit_status_name_MISS' => NULL,
                'edit_status_tel_MISS' => NULL,
                'edit_status_address2_MISS' => NULL,
                'edit_status_introduction_MISS' => NULL,
                'edit_address1' => NULL,
                'edit_success' => NULL
            ]);
        }else
            return view('account/login', ['email_MISS' => NULL, 'password_MISS' => NULL]);
    }

    function create()
    {
        return view('account/create_account', [
            'select_year' => NULL,
            'select_month' => NULL,
            'select_day' => NULL,
            'select_gender' => NULL,
            'name_MISS' => NULL,
            'email_MISS' => NULL,
            'password_MISS' => NULL,
            'password_retype_MISS' => NULL
        ]);
    }

    function login()
    {
        return view('account/login', ['email_MISS' => NULL, 'password_MISS' => NULL]);
    }
}
