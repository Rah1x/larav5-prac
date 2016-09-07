<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <?php if(defined('ADMIN_SESSION_TIMEOUT')){ echo '<meta http-equiv="refresh" content="'.(ADMIN_SESSION_TIMEOUT+5).'" />'; } ?>

	<title><?php if(isset($pg_title) && !empty($pg_title)) echo $pg_title.' | '; ?> {{@$_ENV['PROJECT_NAME']}} Admin Portal</title>
    <link rel="shortcut icon" href="{{asset('favicon_31.ico')}}" />

    <link type="text/css" rel="stylesheet" href="{{asset('assets/back_adm/css/template_1.css')}}" />


    <?php if(!isset($no_header)){ ?>

    <script type="text/javascript" src="{{asset('assets/js/custom.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/back_adm/js/local_storage.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/back_adm/js/var_dump.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/jquery-1.11.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/back_adm/js/main.js')}}"></script>

    <?php if(isset($load_fancy)) { ?>
    <link rel="stylesheet" href="{{asset('assets/js/fancybox/source/jquery.fancybox.css?v=2.1.5')}}" type="text/css" media="screen" />
    <script src="{{asset('assets/js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('assets/back_adm/js/fancy_inits.js')}}"></script>
    <?php } ?>

    <?php if(isset($load_jquery_ui)) { ?>
    <link rel="stylesheet" media="screen" type="text/css" href="{{asset('assets/js/jquery-ui-1.11.4.paleBrown/jquery-ui.min.css')}}" />
    <script type="text/javascript" src="{{asset('assets/js/jquery-ui-1.11.4.paleBrown/jquery-ui.min.js')}}"></script>
    <?php } ?>

    <?php }//end no header... ?>

    <style>
    <?php if(stristr($browser, 'msie')!=false){
    echo "
    input.button{
    line-height: 16px;
    }
    ";
    } ?>
    </style>

    <?php /*<script>var DOC_ROOT_ADMIN = '<?=DOC_ROOT_ADMIN?>';</script>*/ ?>

    <!-- /* for select all * / -->
    <script>var del_fieldx='RecordID[]';</script>
    <script type="text/javascript" src="{{asset('assets/back_adm/js/select_all.js')}}"></script>

    <?php //{!! r::var_dumpx($browser) !!} ?>
    <?php //r::var_dumpx(r::sess()) ?>

</head>

<body>
<?php
## define vars for the whole theme
$_SESS = r::sess();
$S_PREFIX = @$_ENV['SESSION_PREFIX'];
$cur_route = r::cur_route();
#-
?>

<div style="text-align:center;">
<!--<div style="display:inline-block; text-align:left;">-->
<div id="main_par_div" style="width:97%; text-align:left; max-width:1400px; display:inline-block;">
<br /><br />

<?php if(!isset($no_header)){ ?>
<div style="text-align:center; margin-top:-10px;">
    <div style="padding:0 0 16px 0; margin-left:-10px;"><img src="{{asset('assets/back_adm/images/logo_y1.png')}}" title="{{@$_ENV['PROJECT_NAME']}} Admin"
    style="border-radius:40%; order:solid 1px #FFFFFF; adding:10px 50px;" /></div>
</div>

<table align="center" border="0" cellpadding="0" cellspacing="0" width="92%" id="HEADER" class="no_print">
<tr>
    <td>
    <div style="float:left;">
        <div style="padding:0;">{{@$_ENV['PROJECT_NAME']}} - Administration Area</div>
    </div>

    <div style="float:right; padding:0; margin-top:18px;">
        <?php if(adminMainHelper::usercheck()!=false){ ?>
            <span>
            Logged in as <b><?php echo @adminMainHelper::rtext($_SESS[$S_PREFIX."adm_usr_info"]['first_name'].' '.$_SESS[$S_PREFIX."adm_usr_info"]['last_name']); ?></b>
            [<a href="{{route('logout')}}">Logout</a>]
            </span>
        <?php } ?>
    </div>
    <div style="clear:both; padding:0; height:0px; font-size:0px;"></div>
    </td>
</tr>
</table>

<?php }//end no header... ?>


<?php if(!isset($no_header) && (adminMainHelper::usercheck())){ ?>
<style>
.tog_on{width:10px; cursor:pointer; border:solid 1px #C2CCD6; background:url({{asset('assets/back_adm/images/close_tog_2.png')}}) #FFFFFF repeat-y 100% center;}
.tog_off{width:10px; cursor:pointer; background:url({{asset('assets/back_adm/images/open_tog.png')}}) #FFFFFF no-repeat 100% center;}
</style>

<script type="text/javascript" src="{{asset('assets/back_adm/js/left_menu.js')}}"></script>
<?php } ?>


<div class="table_dv">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" id="CONTENT">

<tr><td colspan="4">
<div style="height:20px; background:#fff;">
</div></td></tr>

<tr valign="top">
<?php
if(!isset($no_header)){
if(adminMainHelper::usercheck())
{
    $oc_adm_perm = @$_SESS[$S_PREFIX.'adm_perm'];
    ?>
    <td id="COL1" class="no_print" style="padding-right:1px;">
	   <ul class="leftmenu">

        <?php if(is_array($oc_adm_perm) && in_array(1, $oc_adm_perm)) { ?>
        <li style="width:180px;">
            <span id="m_1"><b>Admin Users Mgt</b></span>
			<ul class="leftmenusub">
            <li><a href="{{route('admin-users')}}" <?php if($cur_route=='admin-users' || $cur_route=='admin-users-opp') echo "class='selected'"; ?>>Admin Users</a></li>
			</ul>
		</li>
        <?php } ?>


        <li style="width:180px;">
            <span id="m_9"><b>Administration&nbsp;Area</b></span>
			<ul class="leftmenusub">
            <li><a href="{{route('my-settings/opp')}}" <?php if($cur_route=='my-settings/opp') echo "class='selected'"; ?>>My Settings</a></li>
            <li><a href="{{route('home')}}" <?php if($cur_route=='home') echo "class='selected'"; ?>>Admin Home</a></li>
            <li><a href="{{route('home')}}" target="_blank">Front / Website</a></li>
            <li><a href="{{route('logout')}}">Log Out</a></li>
            </ul>
		</li>

	   </ul>
    <br />
    </td>

    <td style="background:#ffffff;"></td>

    <td id="tog_it" valign="center" class="tog_on" title="click to show/hide the Left Menu Panel" onclick="toggle_left();">
    <div style="width:10px;"></div>
    </td>

    <?php
}
}
?>


<td id="COL2" style="width:100%">
<?php
if(adminMainHelper::usercheck())
{
    if(!isset($no_header)){
	echo '<div style="min-height:450px;">';
    }else{
    echo '<div>';
    }

    if($cur_route=='home'){
    ?>
	<div class="no_print" id="USERMENU">Welcome <b><?php echo @adminMainHelper::rtext($_SESS[$S_PREFIX."adm_usr_info"]['first_name'].' '.$_SESS[$S_PREFIX."adm_usr_info"]['last_name']); ?></b>
    &nbsp;<span style="color: #003366;">[<a href="{{route('logout')}}">Logout</a>]</span></div>
    <br /><br />
	<?php
    }
}
else
{
    ?>
    <div>
    <?php
}


#### Display Notifications
//r::var_dumpx($errors->all(), $_SESS[$S_PREFIX."ADMIN_MSG_GLOBAL"]);
//$_SESS[$S_PREFIX."ADMIN_MSG_GLOBAL"] = array(true, 'Unable to proceed with your search request at this moment!<br />Please try again later.');
if (@array_key_exists($S_PREFIX."ADMIN_MSG_GLOBAL", $_SESS))
{
    if ($_SESS[$S_PREFIX."ADMIN_MSG_GLOBAL"][0]==false){ echo '<div class="error" id="err_gd2" style=""><strong class="red-txt">ERROR:&nbsp;&nbsp;</strong> '.$_SESS[$S_PREFIX.'ADMIN_MSG_GLOBAL'][1].'</div>'; }
    if ($_SESS[$S_PREFIX."ADMIN_MSG_GLOBAL"][0]==true) { echo '<div class="infor" id="err_gd2" style="">'.$_SESS[$S_PREFIX.'ADMIN_MSG_GLOBAL'][1].'</div>'; }
    //echo '<script type="text/javascript">time_id("err_gd2", "div", 60000);</script>';
    r::flush_sess($S_PREFIX."ADMIN_MSG_GLOBAL");
    echo '<br />';
}
#-
////////////////////// HEADER END ////////////////////////////
?>

@yield('innerBody')

<?php /////////////// FOOTER //////////////////////////////// ?>
<br />
</td>
</tr>

</table>
</div>

<?php
$copy_rights = date('Y')." {$_ENV['PROJECT_NAME']} | Administration Section";
?>

<?php if(!isset($no_header)){ ?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="92%" id="FOOTER" class="no_print">
<tr>
<td>
    <a href="{{route('home')}}" style="font-size:12px;">&copy; <?php echo $copy_rights; ?></a>
    <br />
</td>
</tr>
</table>
<?php } ?>
<br /><br />

</div>
<!--</div>-->
</div>
</body>