<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMailSettings;
use Illuminate\Http\Request;
use App\Models\MailSetting;

class MailSettingController extends Controller
{
    public function index() {
        $settings = MailSetting::all();
        $dataArr  = [];
        if(!empty($settings)){
            $settings = $settings->toArray();
            if(!empty($settings)){
                foreach($settings as $settingsVal){
                    $dataArr = json_decode($settingsVal['value'], true);
                }
            }
        }        
        return view('admin.mail.index', array('data' => $dataArr));
    }
    public function updateMailSettings(StoreMailSettings $request) {
        
        // parse_str($request->formData, $searcharray);
        $searcharray = $request->all();
        $data = array(
            "mail_username"          => $searcharray['mail_username'],
            "mail_password"       => $searcharray['mail_password'],
            "from_address"          => $searcharray['from_address'],
            "from_name"          => $searcharray['from_name'],
            "umail_subject"          => $searcharray['umail_subject'],
            "umail_template"          => $searcharray['umail_template'],
            "amail_subject"          => $searcharray['amail_subject'],
            "amail_template"          => $searcharray['amail_template'],
        );
        $mailSettingData =  json_encode($data);
        
        $generalSetting = MailSetting::updateOrCreate(
            ['name'     =>  'mail_settings'],
            ['value'    =>  $mailSettingData],
        );
        return response()->json(['status' => 1, 'msg' => 'Mail Setting updated successfuly.']);
    }

    // public function sendMail(Request $request){
    //     Mail::send('admin.mail.user_template', [
    //         'body' => $request->all(),
    //     ], function($message) use ($request){
    //         $message->to($request->email);
    //         $message->subject('test Mail');
    //     });    
    // }
}
