// JavaScript Document
function tent_otis_embed (key, value) 
{
	document.getElementById(key).innerHTML = value;
}
function tent_otis_set (url)
{
	tent_otis_init(url,'tent_otis_set=true',tent_otis_null);
}
function tent_otis_get (url)
{
	tent_otis_init(url,'tent_otis_get=true',tent_otis_main);
}
function tent_otis_init (url, query, callback) 
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

function tent_otis_anime (meter, stats, start, end, delay)
{
	var i = i == null? 0: i; 
	end = end == null? 100: end;
	delay = delay == null? 60: delay;
	if (i == 0) {
		i = 1;	
		var width = start;
		var id = setInterval(frame,delay);
		function frame() {
			if (width >= end) {
				clearInterval(id);
				i = 0;
			} else {
				width++;
				document.getElementById(meter).style.width = width + "%";
				document.getElementById(stats).innerHTML = width;
			}
		}
	}
}

function tent_otis_null (json)
{
	var dict = JSON.parse(json);
	console.log(dict);
}
function tent_otis_main (json)
{
	var dict = JSON.parse(json);
	console.log(dict);
	var rows = dict['data']['rows'];
	var meta = dict['data']['meta'];	

	var iter = date = buf = '';
	for (var ip in rows)
	{
		iter = rows[ip]['iter'];
		date = rows[ip]['date'];
		buf += '<tr> \
			<td colspan="3"> \
				<var title="Total Visits">'+iter+'</var> \
				'+date+' <b>'+ip+'</b> \
			</td> \
		</tr>';
	}
	
	tent_otis_anime('meter','stats',0,meta['rate']);
	tent_otis_embed('unique',meta['unique']);
	tent_otis_embed('total',meta['total']);
	tent_otis_embed('mean',meta['mean']);	
	tent_otis_embed('today',meta['today']);
	tent_otis_embed('this_week',meta['this_week']);
	tent_otis_embed('this_month',meta['this_month']);
	tent_otis_embed('last_7days',meta['last_7days']);	
	tent_otis_embed('last_30days',meta['last_30days']);	
	tent_otis_embed('last_90days',meta['last_90days']);	
	tent_otis_embed('data',buf);
}

