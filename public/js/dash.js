$(document).ready(function(){

	setup();
	hideSubLinks();
	handleMenuClick();
});

function setup()
{
	var windowHeight = $(window).height();

	$("#main-nav").height(windowHeight);
	$("#content-wrapper").height(windowHeight);

	$(".hidden_question").hide();

	//handle what happens when delete button is clicked
	$('.delete_btn').click(function(){
		$(this).hide();
		$(this).parent().next(".hidden_question").fadeIn(1000);
	});

	$('.cancel_delete').click(function(){
		$(this).parent().hide();
		$(this).parent().prevAll('a').children().fadeIn(1000);
	});
}

function handleMenuClick()
{
	$(".main-link").click(function(){
		$(this + " .sub-link").slideToggle("fast");
	});
}

function hideSubLinks()
{
	$(".sub-link").hide();
}
