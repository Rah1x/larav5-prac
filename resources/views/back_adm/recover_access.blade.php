@extends('back_adm.layout.shell')
@section('innerBody')

<script type="text/javascript">
function validate_f1()
{
    var err = '';

    if(document.getElementById('email_add').value=='')
    {
        err += "Your Login / Email Address cannot be empty!\n";
    }

    if(document.getElementById('vercode').value=='')
    {
        err += "The Security Code cannot be empty!\n";
    }

    if(err!='')
    {
        alert("Please clear the following ERROR(s):\n\n"+err);
        return false;
    }
    else
    {
       document.getElementById('f1').submit();
       return true;
	}

    return false;
}//end func....
</script>

<br />

<div style="text-align:center;">
<div style="text-align:left; display:inline-block; max-width:364px;">
    <strong>Please enter your Login details below.</strong><br /><br />
    A new password will be emailed to your registered email address (the one in this field below).
    Please ensure you have access to that email address!<br /><br />

    <form action="{{route('recover')}}" method="post" name="f1" id="f1" autocomplete="off" nsubmit="return validate_f1();">
        {{csrf_field()}}

        <table align="center" border="0" cellpadding="0" cellspacing="0" class="datagrid">
        <tr>
        <th colspan="2">Login Info</th>
        </tr>

        <tr>
        <td>Login / Email</td>
        <td><input type="text" name="email_add" id="email_add" autocomplete="off" maxlength="100" style="width:230px;" />
        <span style="color:#53A9E9;">&nbsp;&nbsp;*</span>
        </td>
        </tr>

        <tr>
        <td>Security Code&nbsp;&nbsp;</td>
        <td>
            <div style="">
            <?php $title = 'Please enter this Verification Code you see in the box into the security code field. If you have trouble reading the code, click on REFRESH to re-generate it.'; ?>
            <div style="float:left; padding-right:10px;"><input name="vercode" id="vercode" type="text" maxlength="10" placeholder="security code" style="width:90px;" /><span style="color:#53A9E9;">&nbsp;&nbsp;*</span></div>

            <div style="float:left; padding:0 5px;"><img src="{{route('secure-captcha')}}" id='secure_image' border='0' height='20' width='67' style="height:20px; width:67px;" /></div>
            <div style="float:left; padding:2px 7px 0 3px;"><a href="javascript:void(0)" style="margin-top:4px;" onclick="document.getElementById('secure_image').src=document.getElementById('secure_image').src+'?<?php echo time(); ?>';">Refresh</a></div>
            <div style="float:left;"><img src="{{asset('assets/images/tip2.gif')}}" border='0' class="toolIT" title='<?php echo $title; ?>' style="cursor:help;" /></div>
            </div>
        </td>
        </tr>

        <tr>
        <td colspan="2" align="right"><input type="submit" class="button" value="Submit" /></td>
        </tr>
    	</table>
    </form>
    <br />

    <a href="{{route('login')}}">Back to login ..</a>

</div>
</div>

@endSection