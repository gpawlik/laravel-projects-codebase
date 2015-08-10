$(document).ready(function(){

	setup();
	hideSubLinks();
	handleMenuClick();
	handleMainMenu(window.location.pathname.split("/")[1]);
	handleSessionBox();
	handlePermissions();
	handleToUserField();
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
		$(this).nextUntil(".main-link").slideToggle("fast");
	});
}

function hideSubLinks()
{
	$(".sub-link").hide();
}

function handleMainMenu(id)
{
	setTimeout(function(){
		$("#"+id).nextUntil(".main-link").slideDown();
	},100);
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

function handleToUserField()
{
	$("#to-user-field").keyup(function(){
			queryData($("#to-user-field").val());
	});
}

function queryData(data)
{
	$.ajax({
		method: "GET",
	  url: "/api/v1/users/"+data,
		success: function(data){
			$("#users-list").html(
				"<ul>"

				"</ul>"
			);
		}
	})
}
