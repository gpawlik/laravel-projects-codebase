$(document).ready(function(){

	setup();

});

function setup()
{
	var windowHeight = $(window).height();

	$("#main-nav").height(windowHeight);
	$("#content-wrapper").height(windowHeight);
}
