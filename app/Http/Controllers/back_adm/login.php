<?php
namespace App\Http\Controllers\back_adm;

#/ Core
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session, Validator, DB;

#/ Helpers
use mainHelper, r, checkAttempts, encHelper;
use App\Http\Helpers\back_adm\permissionManagerHelper;

#/ Model
use App\Admin_user;
use App\Admin_permission;

class login extends Controller
{
    private $req, $last_visited;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->req = $request;
        $this->last_visited = '';
    }

    public function logout()
    {
        $SESS = $this->SESS;

        $sess_timeout = @$SESS[$this->S_PREFIX.'ADM_sess_timeout'];
        $route_path = @$SESS[$this->S_PREFIX.'last_visited_uri_ADMIN'];

        $this->req->session()->flush();
        //@mainHelper::var_dumpx(Session::get($this->S_PREFIX.'test2'));

        if(!empty($sess_timeout)){
        r::sess_save($this->S_PREFIX."last_visited_uri_ADMIN", $route_path);
        }

        return redirect()->route('login');
    }//end func....


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
        #/*
        if(checkAttempts::check_attempts(3, $this->S_PREFIX.'ADMIN_MSG_GLOBAL')==false){
        checkAttempts::update_attempt_counts();
        return 1;
        }
        #*/


        ##/ Validate Fields
        $validator = Validator::make($this->req->all(), [
            'email_add' => 'required|email|max:100',
            'pass_w' => 'required|min:8|max:20',
        ]/*, [
            'email_add.required' => 'The Email field is required',
            'email_add.email' => 'The Email must be a valid Email Address',
            'pass_w.required' => 'The Password field is required'
        ]*/
        )->setAttributeNames([
        'email_add'=>'Email Address',
        'pass_w'=>'Password'
        ]);

        //r::var_dumpx($validator->errors()->messages());
        if($validator->errors()->count()>0)
        {
            r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", $validator->errors()->messages());
            checkAttempts::update_attempt_counts();
            return $validator->errors()->count();
        }
        else
        {
            #/ Check if User Exists
            $email_add = mysql_real_escape_string($POST['email_add']);
            $pass_w = encHelper::enc($email_add, $POST['pass_w']);
            //r::var_dumpx($email_add, $pass_w);

            $chk_email_add = Admin_user::where('email_add', $email_add) //."1 AND 1=1 -- "
            ->where('pass_w', $pass_w)
            //->toSql();
            ->first();

            //r::last_query();
            //r::var_dumpx($chk_email_add);

            if(is_null($chk_email_add))
            {
                r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", '<strong>INVALID Login Credentials.</strong> &nbsp;Please try again or contact Administrator.');
                checkAttempts::update_attempt_counts();
                return 1;
            }
            else
            {
                //r::var_dumpx($email_add, $POST['pass_w'], $pass_w, $chk_email_add->count(), $chk_email_add->email_add, $chk_email_add->all());
                if($chk_email_add->is_active!='1')
                {
                    r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", '<strong>Your Account is BLOCKED.</strong> &nbsp;Please contact Administrator.');
                    checkAttempts::update_attempt_counts();
                    return 1;
                }
                else
                {
                    #/ Process Login
                    $chk_email_add->pass_w = ''; //remove password
                    $user_prof = serialize($chk_email_add);

                    //var_dumpx($SESS);
                    r::sess_save($this->S_PREFIX."admin_usr_id", $chk_email_add->id);
                    r::sess_save($this->S_PREFIX."adm_usr_info", $user_prof);
                    r::sess_save($this->S_PREFIX."LAST_Admin_ACTIVITY", time());

                    $this->last_visited = @$SESS[$this->S_PREFIX.'last_visited_uri_ADMIN'];
                    r::flush_sess($this->S_PREFIX.'last_visited_uri_ADMIN');

                    #/ Set Permissions
                    $adm_perm = Admin_permission::get_admin_user_perms($chk_email_add->id, 'admin_section_id');
                    $adm_perm = array_keys(r::cb89($adm_perm, 'admin_section_id'));
                    //r::var_dumpx($adm_perm);
                    r::sess_save($this->S_PREFIX."adm_perm", $adm_perm);

                    r::global_msg($this->S_PREFIX."ADMIN_MSG_GLOBAL", 'Welcome to the PickTheWinner Administration Section.');
                    checkAttempts::reset_attempt_counts();
                    return 0;
                }
            }
        }
        #-

    }//end func....


    public function index()
    {
        $POST = $this->POST;
        //r::var_dumpx($this->req->input(), $POST);

        if(isset($POST['email_add']))
        {
            $tot_errors = (int)@$this->process_post();
            if($tot_errors>0){
            return redirect()->route('login');
            }

            if(!empty($this->last_visited))
            return redirect()->route($this->last_visited);
            else{
            return redirect()->route('home');
            }
        }


        $view_ar = array(
        'pg_title' => 'Admin Login'
        );

        return view('back_adm.login', $view_ar);

    }//end func...
}