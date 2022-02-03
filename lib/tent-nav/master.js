// JavaScript Document
function tent_nav_init (url, query, callback) 
{
	var xhttp = window.XMLHttpRequest? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200)
			callback(this.responseText);
	};
	var request = url+'?'+query;
	xhttp.open('GET',request,true);
	xhttp.send();
}
function tent_nav_main (json)
{
	var dict = JSON.parse(json);
	console.log(dict);
	document.getElementById('data').innerHTML = dict['data'];
}