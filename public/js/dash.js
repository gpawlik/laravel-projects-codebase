$(document).ready(function(){

	setup();
	hideSubLinks();
	handleMenuClick();
	handleMainMenu(window.location.pathname.split("/")[1]);
	handleSessionBox();
	handlePermissions();
	handleToUserField();
	handleEmployeeField();
	handleCheckAll();
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

function handleCheckAll()
{
	$("#check-all").click(function(){

			$('input:checkbox').prop('checked', this.checked);

	});
}

function handleSearch()
{
	$(".search-input").keyup(function(){
		
	});
}

function handleToUserField()
{
	$("#to-user-field").keyup(function(){
			queryUserData($("#to-user-field").val());
	});

}

function queryUserData(data)
{
	$.ajax({
		method: "GET",
	  url: "/api/v1/users/"+data,
		success: function(data){
			console.log(data);
			if(data.length > 0)
			{
					$("#users-list").show("fast");
					$("#users-list").html(
						"<ul id = 'users-list-ul'>" +

						"</ul>"
					);

					for(i = 0; i < data.length; i++)
					{
						$("#users-list-ul").append("<li>"+data[i]['first_name']+" "+data[i]['last_name']+" "+"("+data[i]['email']+")</li>");
					}
			}
			else
			{
				$("#users-list").hide("fast");
			}

			$("#users-list-ul li").click(function(){
				$("#to-user-field").val($(this).html());
				$("#users-list").hide("fast");
			});

		},
		error: function(data){
			$("#users-list").hide("fast");
		}
	});
}

function handleEmployeeField()
{
	$("#employee-field").keyup(function(){
			queryEmployeeData($("#employee-field").val());
	});

}

function queryEmployeeData(data)
{
	$.ajax({
		method: "GET",
	  url: "/api/v1/employees/"+data,
		success: function(data){
			console.log(data);
			if(data.length > 0)
			{
					$("#employee-list").show("fast");
					$("#employee-list").html(
						"<ul id = 'employee-list-ul'>" +

						"</ul>"
					);

					for(i = 0; i < data.length; i++)
					{
						$("#employee-list-ul").append("<li>"+data[i]['first_name']+" "+data[i]['last_name']+" "+"("+data[i]['email']+")</li>");
					}
			}
			else
			{
				$("#employee-list").hide("fast");
			}

			$("#employee-list-ul li").click(function(){
				$("#employee-field").val($(this).html());
				$("#employee-list").hide("fast");
			});

		},
		error: function(data){
			$("#employee-list").hide("fast");
		}
	});
}
