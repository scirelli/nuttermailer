//---------------------------------------------------------
// Desc: Converts a string in the form of a URL's query portion (everything after the ?) to an obj
// Example: str = 'var1=hi&var2=bye' output would be {var1:'hi', var2:'bye'}
//---------------------------------------------------------
function queryStrToObj( str ){
    var str = str.split('&');
    var obj = new Object();
    for( var i=0; i<str.length; i++){
        var tmp = str[i].split('=');
        obj[tmp[0]] = unescape(tmp[1]);
    }
    return obj;
}

//---------------------------------------------------------
// Desc: Converts the query portion of the current URL to a obj
//---------------------------------------------------------
function searchtoObj(){
    var str = window.location.search;
    return queryStrToObj(str.substr(1,str.length));
}
/*
window.location.prototype.searchObj = function(){
    var str = this.search.substr(1, this.length).split('&');
    var obj = new Object();
    for( var i=0; i<str.length; i++){
        var tmp = str[i].split('=');
        obj[tmp[0]] = tmp[1];
    }
    return obj;
}
*/
