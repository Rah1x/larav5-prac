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

    if(document.getElementById('pass_w').value=='')
    {
        err += "Your Password cannot be empty!\n";
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
<div style="text-align:left; display:inline-block;">
    <strong>Please enter your Login details below</strong><br /><br />

    <form action="{{route('login')}}" method="post" name="f1" id="f1" autocomplete="off" onsubmit="return validate_f1();">
        {{csrf_field()}}

        <table align="center" border="0" cellpadding="0" cellspacing="0" class="datagrid">
        <tr>
        <th colspan="2">Login</th>
        </tr>

        <tr>
        <td>Login / Email</td>
        <td><input type="text" name="email_add" id="email_add" autocomplete="off" maxlength="100" style="width:230px;" />
        <span style="color:#53A9E9;">&nbsp;&nbsp;*</span>
        </td>
        </tr>

        <tr>
        <td>Password&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td><input type="password" name="pass_w" id="pass_w" autocomplete="off" maxlength="20" style="width:230px;" />
        <span style="color:#53A9E9;">&nbsp;&nbsp;*</span>
        </td>
        </tr>

        <tr>
        <td colspan="2" align="right"><input type="submit" class="button" value="Login" /></td>
        </tr>
    	</table>
    </form>
    <br />

    <a href="{{route('recover')}}">Forgot your Password? Click here to recover..</a>

</div>
</div>

@endSection