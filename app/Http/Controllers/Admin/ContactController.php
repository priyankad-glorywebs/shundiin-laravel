<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use App\Models\MailSetting;
use Symfony\Component\Mime\Part\HtmlPart;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $contactList = Contact::select(
                'id',
                'email',  
                // DB::RAW("JSON_UNQUOTE(JSON_EXTRACT(content, '$.firstname')) AS firstname"),
                // DB::RAW("JSON_UNQUOTE(JSON_EXTRACT(content, '$.lastname')) AS lastname"),
                DB::RAW("CONCAT(
                    JSON_UNQUOTE(JSON_EXTRACT(content, '$.firstname')),
                    ' ',
                    JSON_UNQUOTE(JSON_EXTRACT(content, '$.lastname'))
                ) AS fullname"),
                DB::RAW("JSON_UNQUOTE(JSON_EXTRACT(content, '$.phone')) AS phone"),
                DB::RAW("JSON_UNQUOTE(JSON_EXTRACT(content, '$.message')) AS message"),   
                DB::RAW('DATE_FORMAT(created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
                 'created_at'
            )->get();
            // dd($contactList);
            // $contactList = Contact::select(
            //     'id',
            //     DB::RAW('CONCAT(firstname," ",lastname) as fullname'),
            //     'email',  
            //     'phone',
            //     'message',          
            //     DB::RAW('DATE_FORMAT(created_at, "%M %d, %Y %h:%i:%s %p") as display_created_at'),
            //      'created_at',
            // );
            // dd($contactList);
            return DataTables::of($contactList)->make(true);
        }
        $contactList = array(
            'title' => 'Contacts',
            'name' => 'contacts',
            'add_route' => 'post-type.contacts',
            'list_route' => 'admin.contacts',
        );

       // $modulesname = Modulename::all();

        return view('admin.contacts.index', array('contactList' => $contactList));
    }

    public function createcontact(Request $request){
        // $data = $request->all();
        // unset($data['_token']);
        // dd($request->all());
        if ($request->ajax()) {

            $module_data = Module::where('title', '=', 'contact-us-module')->select('content')->first();
            $dataArray = json_decode($module_data->content, true);
            $validate_arr = [];
            foreach ($dataArray['inputs'] as $key => $value) {
                if(isset($value['fieldrequired']) && $value['fieldrequired'][0] == 'true'){
                    $validate_arr[$value['fieldname']] = 'required';
                }
            }
            // dd($validate_arr);
            $validator = \Validator::make($request->all(), $validate_arr,
            // $validator = \Validator::make($request->all(), [
            //     'name' => 'required',
            //     'email' => 'required',
            //     'subject' => 'required',
            //     'message' => 'required',
            // ],
            [
                'required'  => 'The field is required.',
            ]);

            if (!$validator->passes()) {
                return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
            } else {
                
                // parse_str($request->all(), $searcharray);
                $data = $request->all();
                unset($data['_token']);
                unset($data['email']);
                $contact_data =  json_encode($data);
                //  dd($contact_data);
                
                $CreatedInfo = new Contact();
                $CreatedInfo->email = $request->email;
                $CreatedInfo->content = $contact_data;
                $CreatedInfo->save();
                // Contact::create(
                //     ['email'     =>  $request->email],
                //     ['content'    =>  $contact_data],
                // );
                // dd($CreatedInfo);
                // $CreatedInfo = Contact::create($request->all());

                if(!$CreatedInfo){
                    return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
                } else {
                    $user_mail = $request->email;
                    $generalSetting = get_general_settings();
                    $admin_mail = $generalSetting['gs_email'];

                    $mailTemplate = MailSetting::where('name', 'mail_settings')->select('value')->first();
                    $mailTemplate = json_decode($mailTemplate['value']);

                    $user_subject = $mailTemplate->umail_subject;
                    $admin_subject = $mailTemplate->amail_subject;

                    $umailTemplate = html_entity_decode($mailTemplate->umail_template);
                    $amailTemplate = html_entity_decode($mailTemplate->amail_template);

                    $user_content = $this->renderTemplate($request->all(), $umailTemplate);
                    $admin_content = $this->renderTemplate($request->all(), $amailTemplate);


                     

                    // Mail::send('admin.mail.mail_template', [
                    //     'template' => $user_content
                    // ],
                    //  function($message) use ($user_mail, $user_subject){
                    //     $message->from('anil.test35@gmail.com')
                    //     ->to($user_mail)
                    //             ->subject($user_subject);
                    // });

                    // Mail::send('admin.mail.mail_template', [
                    //     'template' => $admin_content
                    // ],
                    //  function($message) use ($admin_mail, $admin_subject){
                    //     $message->from('anil.test35@gmail.com')
                    //     ->to($admin_mail)
                    //     ->subject($admin_subject);
                    // });
                    
                    // Mail::send('admin.mail.mail_template', [
                    //     'template' => $user_content
                    // ], function ($message) use ($user_mail, $user_subject) {
                    //     $message->from('anil.test341@gmail.com')
                    //         ->to($user_mail)
                    //         ->subject($user_subject);
                    // });
                    
                    // Mail::send('admin.mail.mail_template', [
                    //     'template' => $admin_content
                    // ], function ($message) use ($admin_mail, $admin_subject) {
                    //     $message->from('anil.test341@gmail.com')
                    //         ->to($admin_mail)
                    //         ->subject($admin_subject);
                    // });


           $userMailSent =  Mail::to($user_mail)->send(new ContactFormSubmitted($user_subject, $user_content));
        //   dd($userMailSent);
           $adminMailSent = Mail::to($admin_mail)->send(new ContactFormSubmitted($admin_subject, $admin_content));
           // return redirect()->route('mail.send', ['data'=> $request->all()]);
     return response()->json(['status' => 1, 'msg' => 'Response Send Successfully']);
                }
            }
        }
    }

    private function renderTemplate($data, $mailTemplate)
    {
       // Replace placeholders in the template content with data
        foreach ($data as $key => $value) {
            $mailTemplate = str_replace('{'.$key.'}', $value, $mailTemplate);
        }
         return $mailTemplate;
    }

    public function bulkActionContact(Request $request){ 
        $id     = $request->ids;
        $action = $request->action;

     try {
            if(!empty($action) && $action === 'delete'){
                Contact::whereIn('id', $id)->delete();
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'Module deleted successfully.',
                    ),
                ];
            }else{
                Contact::whereIn('id', $id)->update(['status' => $action]);
                return $response = [
                    'status'  => true,
                    'data'    => array(
                        'status'  => true, 
                        'redirect' => '',
                        'message' => 'Module status update successfully.',
                    ),
                ];
            }
        }
        catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => 'Something is wrong, Please ask devlopment team.',
            ], 200);
		}
    }

    public function destroy(int $id)
	{
		try {
            Contact::destroy($id);
            return response()->json([
                'success' => true,
                'icon'    => 'delete',
                'type'    => 'danger',
                'message' => 'Contact deleted successfully.',
            ], 200);
		}
		catch(\Exception $ex) {
            return response()->json([
                'success' => true,
                'message' => $ex->getMessage(),
            ], 200);
		}
	}
}
