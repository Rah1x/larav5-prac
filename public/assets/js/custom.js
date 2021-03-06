// JS equivalent of PHP's in_array
function in_array(needle, haystack, argStrict)
{
    var key = '', strict = !!argStrict;

    if (strict)
    {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else
    {
        for (key in haystack) {
            if (haystack[key] == needle) {
            return true;
            }
        }
    }
    return false;
}//end func...