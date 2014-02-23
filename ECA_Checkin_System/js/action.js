//jQuery datepicker
$(function() {
    $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
});


//系統時間取得
var clockStart = setInterval(function(){getCurTime()},1000);

function getCurTime() {
	var systemTime = document.getElementById('system-time');
	var systemDate = document.getElementById('system-date');
	var currentTime = new Date();
	var currentHours = currentTime.getHours();
	var currentMins  = currentTime.getMinutes();
	var currentSec = currentTime.getSeconds();
	var monthName = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var year = currentTime.getFullYear();
	var month = monthName[currentTime.getMonth()];
	var date = currentTime.getDate();
	var m = 'AM';
	if(currentHours >= 12){
		m = 'PM';
		currentHours = currentHours - 12;
	}
	currentHours = (currentHours / 10) > 1 ? currentHours : '0' + currentHours.toString();
	currentMins = (currentMins / 10) > 1 ? currentMins : '0' + currentMins.toString();
	currentSec = (currentSec / 10) > 1 ? currentSec : '0' + currentSec.toString();
	date = (date / 10) > 1 ? date : '0' + date.toString();
	//var t = currentTime.toLocaleTimeString();
 	//systemTime.innerHTML = t;
 	systemTime.innerHTML = m + ' ' + currentHours + ':' + currentMins + ':' + currentSec;
 	systemDate.innerHTML = month + ' - ' + date + ', ' + year;
}