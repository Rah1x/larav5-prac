function IsChecked( f, n )
{
	if ( f.length )
    {
		for ( var i = 0; i < f.length; i++ )
        {
			if ( f[ i ].checked == true )
            {
				return true;
			}
		}
		alert( n ); f[ 0 ].focus( ); return false;
	}
	else if ( f.checked == false )
    {
		alert( n ); f.focus( ); return false;
	}
	return true;

}///end func.........


function TrimString(sInString)
{
	sInString = sInString.replace( /^\s+/g, "" );// strip leading
	return sInString.replace( /\s+$/g, "" );// strip trailing
}//end func...


function toggle_div(caller, div_id, close_div)
{
    if(caller.checked) {
    document.getElementById(div_id).style.display='';
    } else {
    document.getElementById(div_id).style.display='none';
    }

    if(typeof(close_div)!="undefined"){
    document.getElementById(close_div).style.display='none';
    }

}//end func...


function submit_f1()
{
    if(validate_f1()!=false)
    {
        document.getElementById('f1').submit();
    }
}//end func...

//////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){

$.update_rec = function(rec_id, pageindex)
{
    location.href=$.operation_page+$.param3+'&rec_id='+rec_id;
};//end func....

$.clear_all = function()
{
    location.href = $.cur_page+$.param;
};//end func....

$.set_this = function(f_id, title)
{
    if(title != ''){
    var fld = document.getElementById(f_id);
    fld.value='"'+title+'"';
    filter_x(fld);
    }
};//end func....

$.move_me = function(loc, rec_id, me)
{
    if(loc=='') return false;

    if(loc.search(/pmt_/i)>=0){
        $('#'+loc).click();
        $(me).val('');
        return false;
    }

    if(loc.search(/tab#_/i)>=0){
        post_url = loc.replace('tab#_', '');
        window.open(post_url, '_blank');
        $(me).val('');
        return false;
    }

    var full=false;
    if(loc.search(/\.php/i)>0)
    full = true;

    if(full==false)
    location.href=loc+'.php'+$.param3+'&rec_id='+rec_id;
    else
    location.href=loc;
};
});