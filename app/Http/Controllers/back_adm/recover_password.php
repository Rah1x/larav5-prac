<?php
namespace App\Http\Controllers\back_adm;

#/ Core
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session, Validator, DB;

#/ Helpers
use mainHelper, r, checkAttempts, encHelper, format_str;

#/ Model
use App\Admin_user;

class recover_password extends Controller
{
    private $req;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->req = $request;
    }


    /**
     * Function process_post
     * Return '0' for no errors, or return total number of errors (i.e. at least '1')
    */
    private function process_post()
    {
        $POST = $this->POST;
        $SESS = $this->SESS;
        //r::var_dumpx($POST);

        #/ Check Attempts
        /*
        if(checkAttempts::check_attempts(3, $this->S_PREFIX.'ADMIN_MSG_GLOBAL')==false){
        checkAttempts::update_attempt_counts();
        return 1;
        }
        #*/

        $fv_errors = array();

        ##/ Validate Fields
        $validator = Validator::make($this->req->all(), [
            'email_add' => 'required|email|max:100',
        ]/*, [
            'email_add.required' => 'The Email field is required',
            'email_add.email' => 'The Email must be a valid Email Address',
        ]*/
        )->setAttributeNames([
        'email_add'=>'Email Address',
        ]);



        //r::var_dumpx($validator->errors()->messages());
        if($validator->errors()->count()>0)
        {
            foreach($validator->errors()->messages() as $ev){
            $fv_errors[] = implode('<br />- ', $ev);
            }
        }

        #// Check Captcha Code
        if( (empty($SESS['cap_code'])) || (empty($POST['vercode'])) || ($SESS['cap_code']!=$POST['vercode']) )
        {
            $fv_errors[] = 'The Verification Code you entered does not match the one given in the image! Please try again.';
        }

        if(empty($fv_errors) || (count($fv_errors)<=0))
        {
            ##/ Check Credentials
            $email_add = format_str::format_str($POST['email_add']);
            $chk_email_add = Admin_user::where('email_add', $email_add)->first();
            //r::var_dumpx($POST, $email_add, $chk_email_add);
            //r::last_query(); die();

            #/ Check If Account Exists
            if(empty($chk_email_add))
            {
                r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", '<strong>INVALID Login Credentials.</strong> &nbsp;Please try again or contact Administrator.');
                checkAttempts::update_attempt_counts();
                return 1;
            }
            else
            {
                $chk_email_add_ar = @$chk_email_add->toArray();
                if($chk_email_add->is_active!='1')
                {
                    r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", '<strong>Your Account is BLOCKED.</strong> &nbsp;Please contact Administrator.');
                    checkAttempts::update_attempt_counts();
                    return 1;
                }
                else
                {
                    #/ Process recovery
                    $user_prof = format_str::format_str($chk_email_add_ar);
                    $pass_new = encHelper::createRandomPassword();
                    $pass_w = encHelper::enc($email_add, $pass_new);
                    r::var_dumpx($user_prof, $pass_new, $pass_w);

                    #/ Setup & Send Email
                    //$site_url = SITE_URL.'back_adm/';
                }
            }
        }
        else
        {
            $fv_msg = 'Please clear the following Error(s):<br /><br />- ';
            $fv_msg.=@implode('<br />- ', $fv_errors);
            //r::var_dumpx($fv_msg);

            r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", $fv_msg);
            checkAttempts::update_attempt_counts();
            return 1;
        }

    }//end func....


    public function index()
    {
        $POST = $this->POST;
        //r::var_dumpx($this->req->input(), $POST);

        if(isset($POST['email_add']))
        {
            $tot_errors = (int)@$this->process_post();
            if($tot_errors>0){
            return redirect()->route('recover');
            }
        }


        $view_ar = array(
        'pg_title' => 'Recover Access'
        );

        return view('back_adm.recover_access', $view_ar);

    }//end func...
}