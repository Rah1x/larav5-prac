<?php
namespace App\Http\Helpers\back_adm;

use Illuminate\Http\Request;

class adminMainHelper
{

    /** Check if Admin USer is logged in **/
    public static function usercheck()
    {
        $S_PREFIX = @$_ENV['SESSION_PREFIX'];
        $SESS = \Request::session()->all();

        $ret = array_key_exists($S_PREFIX."admin_usr_id", $SESS);
        //var_dump($ret, $SESS); die();
        return $ret;

    }//end func..


    public static function rtext($s)
    {
    	return htmlspecialchars($s);
    }//end func..


public static function fixgpcvar($a)
{
	if (is_array($a))
	{
		foreach ($a as $k => $x)
		{
			$a[ $k ] = fixgpcvar($a[ $k ]);
		}
	}
	else
	{
		$a = get_magic_quotes_gpc() ? stripslashes(trim($a)) : trim($a);
	}
	return $a;
}


public static function getgpcvar($v, $gpc)
{
	switch ($gpc)
	{
		case "G":
			$v = array_key_exists($v, $_GET) ? $_GET[ $v ] : "";
			break;
		case "P":
			$v = array_key_exists($v, $_POST) ? $_POST[ $v ] : "";
			break;
		case "C":
			$v = array_key_exists($v, $_COOKIE) ? $_COOKIE[ $v ] : "";
			break;
	}
	return fixgpcvar($v);
}

public static function rebuildurl($r = array())
{
	$s = basename($_SERVER[ "PHP_SELF" ]);
	$q = array_key_exists("QUERY_STRING", $_SERVER) && $_SERVER[ "QUERY_STRING" ] ? "&{$_SERVER['QUERY_STRING']}" : "";
	foreach ($r as $n => $v)
	{
		$q = preg_replace("/&$n=[^&]*/", "", $q);
		$q .= $v === "" ? "" : ("&$n=" . urlencode($v));
	}
	if ($q)
	{
		$q[ 0 ] = "?";
	}
	return $s . $q;
}


public static function csvfromintarray($a, $b)
{
	if (is_array($a) == false || count($a) == 0)
	{
		return $b;
	}
	$a = implode(",", $a);
	if (preg_match("/^[0-9]+(,[0-9]+)*$/", $a) == false)
	{
		return $b;
	}
	return $a;
}


public static function rebuildurl_sort($orderby, $orderdi, $orderby_this, $first_dir='ASC')
{
    $dir = $first_dir;
    $dir2 = ($dir=='ASC')? 'DESC':'ASC';
    $ordir = ($orderby == $orderby_this && $orderdi == $dir)? $dir2:$dir;

    $r = array(
    "orderby" => $orderby_this,
    "orderdi" => $ordir,
    );

    return @rebuildurl($r);

}//end func....

/**
 * Generate THs for LIST page
 * @param
 * $cols = array($orderby, $orderdi, array_of_cols)
 * array_of_cols = array([label, width, orderby, orderdir])
*/
public static function generate_THs($orderby, $orderdi, $cols)
{
    if(!is_array($cols) || count($cols)<=0){return false;}

    global $consts;

    echo "<tr>";
    foreach($cols as $colv)
    {
        if(!is_array($colv)){continue;}

        if(!isset($colv['orderby']))
        {
            echo "<th width=\"{$colv['width']}%\" nowrap>{$colv['label']}</th>\n";
        }
        else
        {
            echo "
            <th valign=\"top\" width=\"{$colv['width']}%\" nowrap><a href=\"".rebuildurl_sort($orderby, $orderdi, $colv['orderby'], $colv['orderdir'])."\">
                {$colv['label']}
                ";

                if ($orderby == $colv['orderby'] && $orderdi == "ASC"){
                echo "<img src=\"{$consts['DOC_ROOT_ADMIN']}images/sorta.gif\" alt=\"ASC\" width=\"9\" height=\"9\" border=\"0\">";
                }
                else if ($orderby == $colv['orderby'] && $orderdi == "DESC"){
                echo "<img src=\"{$consts['DOC_ROOT_ADMIN']}images/sortd.gif\" alt=\"DESC\" width=\"9\" height=\"9\" border=\"0\">";
                }

                echo "
                </a>
            </th>
            ";
        }

    }//end foreach...
    echo "</tr>";

}//end func....
}
?>