// JavaScript Document
// VOID LINK <a href="javascript:void(0)" rel="help,next,prev,author,external,search,noopener,tag">
// SCREEN SIZE alert(screen.availWidth+' x '+screen.availHeight);
// WINDOW
function echo (args) {alert(args);}
function print_r (args) {console.log(args);}
function var_dump (args) {console.dir(args);}
function redirect (url) {location.assign(url);}
function newRequest (args) {location.href = args;}
function addRequest (args) {location.href += args;}
function myReload() {location.reload();}
function myPrint() {window.print();}
function isOnline() {return navigator.onLine;}
function isJavaEnabled() {return navigator.javaEnabled();}
// DOM
function set (key, value) {document.getElementById(key).innerHTML = value;}
function get (key) {return document.getElementById(key).innerHTML;}
function show (args) {document.getElementById(args).style.display = 'block';}
function hide (args) {document.getElementById(args).style.display = 'none';}
function toggle (args)
{
	var target = document.getElementById(args);
	var bool = !target.style.display || target.style.display == 'none';
	var value = bool? 'block': 'none';
	target.style.display = value;
}
// ON-LOAD
function activeWeb () 
{
	var bulb = document.getElementById('bulb');
	if (bulb !== null)
		bulb.style.backgroundColor = navigator.onLine? 'lime': 'red';
}
function activeNav()
{
	var p = document.querySelector('input[name="nav"]').value;
	var i = Number(p) - 1;
	document.querySelectorAll('nav ul li')[i].setAttribute('class','focus');
}
function activeMenu()
{
	var p = location.href; // this page url
	p = p.split('#'); // remove hash
	p = p[0].split('?'); // remove request
	var arr = p[0].split('/'); // remove slash
	var file;
	for (var e, i = 0; i < arr.length; i++) {
		e = arr[i];
		if (e.search('.') >= 0) // any element with file extension
			file = e;
	}
	// console.log(file);
	var a = document.getElementsByTagName('a'); // all anchor tags
	for (var e, i = 0; i < a.length; i++) {
		e = a[i].getAttribute('href'); // href attribute
		if (e == file)
			a[i].setAttribute('class','focus');
	}
}
// APPSTATE
function pageLock (next_page) 
{
	if (sessionStorage.getItem('user') === 'undefined') {
		next_page = typeof next_page !== 'undefined'? next_page: 'login.php';
		window.location.assign(next_page);
	}
}
function login (next_page) 
{
	alert('Login Successful!')
	next_page = typeof next_page !== 'undefined'? next_page: 'home.php';
	window.location.assign(next_page);
}
function logout (next_page)
{
	if (confirm('Exit Application?') == true) {
		window.sessionStorage.clear();
		next_page = typeof next_page !== 'undefined'? next_page: 'login.php';
		location.assign(next_page);
	}
}
// FORMS
function getForm (name) {return document.forms[name];}
function isEmpty (input) {return input.trim().length <= 0;}
function charCount (self, id)
{
	var target =	document.getElementById(id);
	var maxlen = self.getAttribute('maxlength');
	var curlen = self.value.length;
	curlen == maxlen?	target.style.color = 'red': target.style.color = 'blue';
	target.innerHTML = curlen + '/' + maxlen;		
}
function togglePassword()
{
	var target = document.getElementById('password');
	var value = (target.type == 'password')? 'text': 'password';
	target.setAttribute('type',value);
}
function onEnter (e, callback) 
{
	var key = e.which || e.keyCode;
	if (key == 13) callback();
	else return false;
}
function onReset (attr) 
{
	attr = typeof attr !== 'undefined'? attr: '[data-ajax]';	
	var target = document.querySelectorAll(attr);
	for (var i = 0; i < target.length; i++)
		target[i].value = '';
}
function onBrowse (id)
{
	document.getElementById(id).click();
}
function onView (id)
{
	var request = '?v=true&q='+id;
	location.assign(request);
}
function onEdit (id)
{
	var request = '?e=true&q='+id;
	location.assign(request);
}
function onDelete (id)
{
	if (confirm('Delete Record?') == true)
	{
		var request = '?d=true&q='+id;
		location.assign(request);
	}
}
function onFilter (value)
{
	var request = '?f=true&q='+value;
	location.assign(request);
}
function onSort (value)
{
	var request = '?s=true&q='+value;
	location.assign(request);
}
function onPager (q)
{
	var id = document.getElementById('pager_id').value;				
	var request = '?p=true&q='+ q +'&id='+ id;
	location.assign(request);
}
function onChecksum (self, attr)
{

	var bool = self.checked == true;
	var target = document.querySelectorAll(attr);
	for (var i = 0; i < target.length; i++)
		target[i].checked = bool;
}
function onLogout ()
{
	if (confirm('Exit Application?') == true) {	
		var request = '?logout=true';
		location.assign(request);
	}
}
function tabindex (n)
{
	var input = document.querySelectorAll('form input');
	input[n].focus();
}
function autofill (bool)
{
	this.TYPES = {
		"text": 		"John Doe",
		"email": 		"example@domain.com",
		"tel": 			"01234567891",				
		"search": 	"foo bar",		
		"password": "_Strongp@ssw0rd",
		"number": 	1234,
		"url": 			"http://www.hwplabs.com/",
		"color":		"#0093DD",
		"date": 		"1992-09-15",
		"time": 		"12:00:00",
		"datetime-local": "1992-09-15 12:00 PM",
		"week": 		52,
		"month": 		12,
		"hidden": 	1,
	};
	
	if (bool == true)
	{
		var selectors = [];
		// INPUT TYPES
		var myTypes = this.TYPES;
		for (var i in myTypes)
		{
			selectors = document.querySelectorAll('input[type="'+i+'"]');
			for (var j in selectors)
				selectors[j].value = myTypes[i];
		}
		// INPUT TYPE PASSWORD (SHOW/HIDE)
		var myPassword = document.querySelectorAll('input[type="password"]');
		for (var i = 0; i < myPassword.length; i++)
		{
			myPassword[i].addEventListener (
				"dblclick",
				function(){this.type = 'text';}
			);
		}
		// INPUT TYPE FILE (NOT REQUIRED)
		var myFile = document.querySelectorAll('input[type="file"]');
		for (var i = 0; i < myFile.length; i++)
			myFile[i].required = false;
		// SELECT TAG
		var mySelect = document.getElementsByTagName('select');
		for (var i = 0; i < mySelect.length; i++)
		{
			selectors = mySelect[i].getElementsByTagName('option');
			selectors[1].selected = true;
		}
		// RADIO BUTTON
		var key = '', group = {};
		var myRadio = document.querySelectorAll('input[type="radio"]');
		for (var i = 0; i < myRadio.length; i++)
		{
			var j = myRadio[i].name;
			selectors = document.querySelectorAll('input[name="'+j+'"]');
			selectors[0].checked = true;
		}
		// CHECKBOX
		var myCheckbox = document.querySelectorAll('input[type="checkbox"]');
		for (var i in myCheckbox)
			myCheckbox[i].checked = true;	
		// RANGE
		var myRange = document.querySelectorAll('input[type="range"]');
		for (var i in myRange)
			myRange[i].value = 5;	
		// TEXTAREA
		var myTextarea = document.querySelectorAll('textarea');
		for (var i in myTextarea)
			myTextarea[i].value = "1 Liberty way, Uwasota, BC 300283, ED.";
	}
}
// SESSION
function allSession() {return window.sessionStorage;}
function setSession (key, value) {window.sessionStorage.setItem(key,value);}
function getSession (key) {return window.sessionStorage.getItem(key);}
function delSession (key) {return window.sessionStorage.removeItem(key);}
function endSession() {window.sessionStorage.clear();}
// BUFFER
function abbr_f (str) {return str.substr(0,3);}
function ante_f (hr) {return hr >= 0 && hr < 12? 'AM': 'PM';}
function digit_f (n) {return n < 10? '0'+n: n;}
function score_f (n) 
{
	var buf = '';
	if (n < 10) buf = '00'+n;
	else if (n >= 10 && n < 100) buf = '0'+n;	
	else buf = n;
	return buf;
}
function nth_f (num)
{
	var last = num.toString().slice(-1);
	if (num != 11 && last == 1) buf = 'st';
	else if (num != 12 && last == 2) buf = 'nd';
	else if (num != 13 && last == 3) buf = 'rd';
	else buf = 'th';
	return num + buf;
}
function xii_f (hr) 
{
	var buf = 0;
	if (hr == 0) buf = 12;
	else if (hr >= 1 && hr <= 12) buf = hr;
	else buf = hr - 12; 	
	return buf < 10? '0'+buf: buf;
}
function greet_f (hr)
{
	var buf = '';
	if (hr >= 0 && hr <= 11) buf = 'Good morning';
	else if (hr >= 12 && hr <= 16) buf = 'Good afternoon';
	else if (hr >= 17 && hr <= 20) buf = 'Good evening';
	else if (hr >= 21 && hr <= 23) buf = 'Hello';
	return buf;
}
function money_f (args)
{
  var num = Number(args);
  var buf = num.toLocaleString();
  return buf;
}
function toMoney (args)
{
	var str = args.toString()	
	var regex = /\B(?=(\d{3})+(?!\d))/g;
	return str.replace(regex,",");
}
function getRandom (start, end)
{
	var range = (end-start) + 1;
	return Math.floor(Math.random()*range) + start;
}
function ucwords (str) 
{
	var lower = str.toLowerCase();
	return toTitleCase(lower);
}
function toTitleCase (str)
{
	var arr = str.split(' '), e = '', len = 0, buf = [];
	for (var i in arr) {
		e = arr[i];
		len = e.length;
		buf[i] = e.charAt(0).toUpperCase() + e.substr(1,len);
	}
	return buf.join(' ');
}
function repeatUntil (args, iter, n)
{
	var buf = '';
	for (var i = 0; i < iter; i++)
	{
		if (isNaN(n))
			buf += args;
		else
		{
			// repeat table
			buf += '<tr><td>'+ n +'</td>' + args;
			n += 1;
		}
	}
	return buf;
}
// CALENDAR
function Calendar()
{
	// var cal = new Calendar();
	this.DAYS = DAYS = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
	this.MONTHS = MONTHS = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
	
	this.date 				= date = new Date(); // Fri Nov 06 2020 21:04:22 GMT+0100 (West Africa Standard Time)
	this.year 				= year = date.getFullYear(); // 1992
	this.year_short 	= year_short = year.toString().slice(-2); // *92
	this.month 				= month = date.getMonth() + 1; //  1 - 12
	this.month_digit	= month_digit = digit_f(month); // 01 - 12
	this.month_long 	= month_long = MONTHS[month]; // January - December	
	this.month_short 	= month_short = short_f(month_long); // Jan - Dec	
	this.day 					= day = date.getDate(); // 1 - 31
	this.day_digit 		= day_digit = digit_f(day); // 01 - 31
	this.day_nth 			= day_nth = nth_f(day); // *st, *nd, *rd, *th
	this.dow 					= dow = date.getDay(); // 0 - 6
	this.dow_long 		= dow_long = DAYS[dow]; // Sunday - Saturday
	this.dow_short 		= dow_short = short_f(dow_long); // Sun - Sat
	this.hrs 					= hrs = date.getHours(); // 0 - 23
	this.hrs_digit		= hrs_digit = digit_f(hrs); // 00 - 23	
	this.hrs_xii			= hrs_xii = xii_f(hrs); // 12 HOURS
	this.mins 				= mins = date.getMinutes(); // 0 - 59
	this.mins_digit		= mins_digit = digit_f(mins); // 00 - 59	
	this.secs 				= secs = date.getSeconds();	// 0 - 59
	this.secs_digit		= secs_digit = digit_f(secs); // 00 - 59	
	this.msecs 				= msecs = date.getMilliseconds(); // 0 - 999
	this.msecs_digit	= msecs_digit = score_f(msecs); // 000 - 999
	this.epoch				= epoch = date.getTime(); // Jan 1, 1970
	this.ante 				= ante = hrs >= 0 && hrs < 12? "AM": "PM"; // AM or PM
	this.salute 			= salute = greet_f(hrs);

	this.date_long = dow_long +', '+ month_long +' '+ day +', '+ year;
	this.date_short = dow_short +', '+ month_short +' '+ day +', '+ year;
	this.date_w = day_digit +'/'+ month_digit +'/'+ year;
	this.time_w = hrs_xii +':'+ mins_digit +' '+ ante;
	this.date_f = year +'-'+ month_digit +'-'+ day_digit;	
	this.time_f = hrs_digit +':'+ mins_digit +':'+ secs_digit;
	this.datetime = this.date_f +' '+ this.time_f;
	this.timestamp = this.date_f +'T'+ this.time_f;	
}
// ANIMATION
function slider() {}
function carousel(){}
function timer()
{
	// setInterval(timer,1000);
	var date = new Date(); // Fri Nov 06 2020 21:04:22 GMT+0100 (West Africa Standard Time)
	var hrs = digit_f(date.getHours()); // 00 - 23
	var mins = digit_f(date.getMinutes()); // 00 - 59
	var secs = digit_f(date.getSeconds());	// 00 - 59
	var buf = hrs +':'+ mins +':'+ secs;
	document.getElementById('timer').innerHTML = buf;
}
function counter (meter, stats, start, end, delay)
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
				document.getElementById(meter).style.width = width + '%';
				document.getElementById(stats).innerHTML = width;
			}
		}
	}
}
function Countdown (ts) 
{
	// var countdown = new Countdown('2020-11-07T16:56:00')
	// countdown.start(callback, callback);
	this.now 	= now = new Date().getTime();		
	this.end 	= end = new Date(ts).getTime(); 
	this.dif 	= dif = end - now;
	this.days = Math.floor(dif / (1000 * 60 * 60 * 24));
	this.hrs 	= Math.floor((dif % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	this.mins = Math.floor((dif % (1000 * 60 * 60)) / (1000 * 60));
	this.secs = Math.floor((dif % (1000 * 60)) / 1000);
	this.start = function (onCount, onFinish) {
		var loop = setInterval(function() {
			onCount(new Countdown(ts));
			if (dif <= 0) {
				clearInterval(loop);
				onFinish();
			}
		},1000);
	};
}
