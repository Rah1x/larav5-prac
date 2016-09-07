<?php
namespace App\Http\Helpers\back_adm;

use Illuminate\Http\Request;
use App\Http\Helpers\mainHelper;

class adminVisitHelper {

public static function test()
{
    die('d');
}

/**
 * function to set Last Visit Location for Redirection after relogin
 * [params]
 * $cur_route = set current page value to filter it out.
 * Its not used for redirection but for filtering.
*/
public static function set_last_visit($cur_route='')
{
    $S_PREFIX = @$_ENV['SESSION_PREFIX'];
    if($cur_route==''){$cur_route = \Request::route()->getName();}

    //ignore these pages
    $no_need_pages = array(
    'logout',
    'login',
    '403P',
    '404',
    'recover-access',
    'user_em_srch_ajax',
    'offer_tag_srch_ajax',
    'offer_brand_srch_ajax',
    'stats',
    );

    $GET_ro = \Request::input('ro'); //readonly pages
    //mainHelper::var_dumpx($GET_ro);

    //@mainHelper::var_dumpx(\Request::session()->all());
    if(in_array($cur_route, $no_need_pages)==false && !isset($GET_ro))
    {
        \Request::session()->put($S_PREFIX.'last_visited_uri_ADMIN', $cur_route); \Request::session()->save();
    }
    else
    {
        \Request::session()->put($S_PREFIX.'last_visited_uri_ADMIN', ''); \Request::session()->save();
    }
    //@mainHelper::var_dumpx(\Request::session()->all());

}//end func..
}
?>