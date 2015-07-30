$(document).ready(function(){

	setup();
	hideSubLinks();
	handleMenuClick();
	handleMainMenu(window.location.pathname.split("/")[1]);
	handleSessionBox();
	handlePermissions();
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
		$(this).nextAll(".sub-link").slideToggle("fast");
	});
}

function hideSubLinks()
{
	$(".sub-link").hide();
}

function handleMainMenu(id)
{
	setTimeout(function(){
		$("#"+id).nextAll(".sub-link").slideDown();
	},1000);
}

function handleSessionBox()
{
	setTimeout(function(){
		$("#session-box").slideToggle("slow");
	},4000);
}

function handlePermissions()
{
	$(".permission-table").hide();

	$(".permission-header").click(function(){
		$(this).next(".permission-table").slideToggle("slow");
	});
}
