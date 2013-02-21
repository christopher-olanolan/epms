// JavaScript Document
var UTCdayarray = new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
var UTCmontharray = new Array("January","February","March","April","May","June","July","August","September","October","November","December");
	
$.dateManager = {
	dateDisplay : function() {
		UTCdate = new Date();
		UTCyear = UTCdate.getUTCFullYear();

		if (UTCyear < 1000){UTCyear+=1900;}

		UTCday = UTCdate.getUTCDay();
		UTCmonth = UTCdate.getUTCMonth();
		
		
		UTCdaym = UTCdate.getUTCDate();

		if (UTCdaym<10){UTCdaym = "0"+UTCdaym;}

		UTChours = UTCdate.getUTCHours();
		UTCminutes = UTCdate.getUTCMinutes();
		UTCseconds = UTCdate.getUTCSeconds();

		UTCdn = "AM";

		if (UTChours>=12){UTCdn = "PM";}
		if (UTChours>12){UTChours = UTChours-12;}
		if (UTChours==0){UTChours = 12;}
		if (UTCminutes<=9){UTCminutes = "0"+UTCminutes;}
		if (UTCseconds<=9){UTCseconds = "0"+UTCseconds;}

		UTCcdate=UTCdayarray[UTCday]+", "+UTCmontharray[UTCmonth]+" "+UTCdaym+", "+UTCyear+" - "+UTChours+":"+UTCminutes+":"+UTCseconds+" "+UTCdn;
		$("#UTCDate").html(UTCcdate);
	},

	dateInterval : function(){
		setInterval(function() {
			$.dateManager.dateDisplay();
		}, 1000);
	}
};

$(document).ready(function() {
	$.dateManager.dateInterval();
});