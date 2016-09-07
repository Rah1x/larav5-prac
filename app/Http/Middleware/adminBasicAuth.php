<?php
namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use mainHelper, r;
use App\Http\Helpers\back_adm\adminVisitHelper;

class adminBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        ## Some tests....
        //mainHelper::var_dumpx($request->input());
        //adminVisitHelper::set_last_visit();
        #-


        ###/ Enforce Basic Authentication
        //mainHelper::var_dumpx($_ENV['ADMIN_USERNAME']);
        $ADMIN_USERNAME = @$_ENV['ADMIN_USERNAME'];
        $ADMIN_PASSWORD = @$_ENV['ADMIN_PASSWORD'];

        if (!isset($_SERVER['PHP_AUTH_USER']) ||
		!isset($_SERVER['PHP_AUTH_PW']) ||
		$_SERVER['PHP_AUTH_USER'] != $ADMIN_USERNAME ||
		$_SERVER['PHP_AUTH_PW'] != $ADMIN_PASSWORD)
        {
    		$ret = "<html><body><h1>Rejected!</h1><big>Wrong Username/Password!</big>
            <br/>&nbsp;<br/>&nbsp;</body></html>";

            return response($ret, 401)
            ->header('WWW-Authenticate', "Basic realm=\"Back Admin Login\"");

			exit;
		}
        else
        {
            ###/ Enforce Session based Authentication

            $S_PREFIX = @$_ENV['SESSION_PREFIX'];
            $SESS = $request->session()->all(); //recall it after saving new value
            $cur_route = $request->route()->getName();

            //$GETx = $request->input('ro');
            //@mainHelper::var_dumpx($cur_route, $S_PREFIX, $SESS, $SESS[$S_PREFIX.'admin_usr_id']);

            //$request->session()->put($S_PREFIX.'test', 'x'); $request->session()->save();
            //@mainHelper::var_dumpx(\Request::session()->get($S_PREFIX.'test'));



            if(!in_array($cur_route, array('login', 'logout', 'recover')))
            {
                if(!isset($SESS[$S_PREFIX."admin_usr_id"]) || empty($SESS[$S_PREFIX."admin_usr_id"])) //access only if logged-in
                {
                    return redirect()->route('login');
                    exit;
                }
                else
                {
                    $LAST_ACTIVITY = @$SESS[$S_PREFIX.'LAST_Admin_ACTIVITY'];

                    #/ logout if last activity is over 30 minutes old
                    $activity_diff = (time() - $LAST_ACTIVITY);
                    if ($activity_diff > @$_ENV['ADMIN_INACTIVE_TIME'])
                    {
                        #/ Setup Redirect URI - for relogins and logout
                        adminVisitHelper::set_last_visit();

                        //$request->session()->put($S_PREFIX.'ADM_sess_timeout', 'yes'); $request->session()->save();
                        r::sess_save($this->S_PREFIX."ADM_sess_timeout", 'yes');
                        return redirect()->route('logout');
                        exit;
                    }

                    //$request->session()->put($S_PREFIX.'LAST_Admin_ACTIVITY', time()); $request->session()->save();
                    r::sess_save($this->S_PREFIX."LAST_Admin_ACTIVITY", time());
                    @mainHelper::var_dumpx(\Request::session()->get($S_PREFIX.'LAST_Admin_ACTIVITY'));
                }
            }
            else if(!in_array($cur_route, array('logout')))
            {
                if(isset($SESS[$S_PREFIX.'admin_usr_id']) && ($SESS[$S_PREFIX.'admin_usr_id']>0)) //access only if NOT logged-in
                {
                    return redirect()->route('home');
                    exit;
                }
            }
            #-

		}//end else...
        #-

        return $next($request);
    }
}
