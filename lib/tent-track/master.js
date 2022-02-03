// JavaScript Document
function tent_track_main (arr) 
{
	var map = {}, href = '', thumb = '', done = 0, tsp = '', sn = 0, buf = '';
	for (var i in arr)
	{
		map = arr[i];
		href = map.c == true? 'href="../../'+map.f+'" target="_new"': '#';
		thumb = map.c == true? 'active': 'inactive';
		done += map.c == true? 1: 0;
		tsp = map.d != null? 'Updated '+map.d: 'Not updated yet';		
		sn += 1;
		
		buf += '<li> \
			<a '+href+'> \
				<table border="0"> \
					<tr> \
						<td><var class="'+thumb+'">'+sn+'</var></td> \
						<td> \
							<label>'+map.f+'</label> \
							<time>'+tsp+'</time> \
						</td> \
						<td><i>&rsaquo;</i></td> \
					</tr> \
				</table> \
			</a> \
		</li>';
	}
	var rate = Math.round((done * 100)/sn);
	if (rate >= 66) ink = '#00A65A'; else if (rate >= 33) ink = '#F39C12'; else ink = '#DD4B39';
	tent_track_anime('meter','stats',0,rate);
	document.querySelector('nav ul li').style.backgroundColor = ink;	
	document.querySelector('nav var').innerHTML = done+' of '+sn+' (~<a id="stats">'+rate+'</a>%)';
	document.querySelector('main ul').innerHTML = buf;
}

function tent_track_anime (meter, stats, start, end, delay)
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

