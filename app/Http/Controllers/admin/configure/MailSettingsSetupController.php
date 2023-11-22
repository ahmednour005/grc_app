<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\EmailConfig;

class MailSettingsSetupController extends Controller
{
    public function index(){
        // Assuming you want to edit a specific record, you need its ID
        $emailConfigId = 1; // Replace with the ID of the record you want to edit
    
        // Retrieve the specific EmailConfig record by its ID
        $emailSettings = EmailConfig::find($emailConfigId);
    
        return view("admin.content.configure.mail_settings.create", compact('emailSettings'));
    }
    public function store(Request $request)
    {

        // validation of insert survey
        $rules = [
            // 'name' => ['required', 'max:512', 'unique:awareness_surveys,name'],
            'email_type' => ['required', 'max:500'],
            'smtp_server' => ['required', 'max:500'],
            'smtp_port' => ['required', 'max:500'],
            'smtp_username' => ['required', 'max:500'],
            'smtp_password' => ['required', 'max:500'],
            'smtp_security' => ['required', 'max:500'],
            'smtp_from_username' => ['nullable'],
            'ssl_tls' => ['nullable'],
            'is_active' => ['nullable'],
        ];


        // Validation rules
        $validator = Validator::make($request->all(), $rules);

        // Check if there is any validation errors
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();

            $response = array(
                'status' => false,
                'errors' => $errors,
                'message' => __('locale.ThereWasAProblemAddingSurvey')
                    . "<br>" . __('locale.Validation error'),
            );
            return response()->json($response, 422);
        } else {
            try {
                $emailConfig = EmailConfig::find(1);

                if ($emailConfig) {
                    // Update the attributes of the email_config
                    $emailConfig->email_type = $request->input('email_type');
                    $emailConfig->smtp_username = $request->input('smtp_username');
                    $emailConfig->smtp_password = $request->input('smtp_password');
                    $emailConfig->smtp_server = $request->input('smtp_server');
                    $emailConfig->smtp_port = $request->input('smtp_port');
                    $emailConfig->ssl_tls = $request->input('smtp_security');
                    $emailConfig->smtp_auth = $request->input('smtp_auth');
                    $emailConfig->smtp_from_username = $request->input('smtp_from_username');
            
                    // Save the updated email_config
                    $emailConfig->save();
                }
                DB::commit();
                $message = __('locale.A New Email Setting Config') . __('locale.CreatedBy') . ' "' . (auth()->user()->name ?? '[No User Name]') . '".';
                write_log($emailConfig->id, auth()->id(), $message, 'Creating Email Settings');
            } catch (\Throwable $th) {
                DB::rollBack();

                $response = array(
                    'status' => false,
                    'errors' => [],
                    'message' => $th->getMessage(),
                    'message' => __('locale.Error'),
                );
                return response()->json($response);
            }
        }
    }
}
