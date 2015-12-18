$(document).ready(function(){

	setup();
	hideSubLinks();
	handleMenuClick();
	handleMainMenu(window.location.pathname.split("/")[1]);
	handleSessionBox();
	handlePermissions();
	handleCheckAll();
	handleMenuButtonClick();

});

function setup()
{
	var windowHeight = $(window).height();
	var headerHeight = $("#main-header").height();

	$("#main-nav").height(windowHeight - headerHeight);
	$("#content-wrapper").height(windowHeight - headerHeight);

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

	$('.grid').masonry({
	  // options
	  itemSelector: '.grid-item',
	  columnWidth: 20
	});
}

function handleMenuClick()
{
	$(".main-link").click(function(){
		$(this).nextUntil(".main-link").slideToggle("fast");
		$(this).find("i").toggleClass("fa-plus").toggleClass("fa-minus");
	});
}

function handleMenuButtonClick()
{
	$("#menu-btn").click(function(){
		$("#main-nav").toggle();
		$("#content-wrapper").toggleClass("width-full").toggleClass("width-normal");
	});
}

function hideSubLinks()
{
	$(".sub-link").hide();
}

function handleMainMenu(id)
{
	setTimeout(function(){
		$("#"+id).nextUntil(".main-link").fadeIn();
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

function handleSearch(route,parentModel,model)
{
		$.ajax({
		method: "GET",
	  	url: "/api/v1/"+ route +"/"+ $(".search-input").val(),
		success: function(data){
			console.log(data);
			if(data.length > 0)
			{
				$(".result-wrapper").html(

					"<table class = 'view-table'>" +
						"<tr id = 'table-header-tr'></tr>" +
					"</table>"

					);

					for(property in data[0])
					{
						if(property == "id")
						{
							continue;
						}

						$("#table-header-tr").append("<th>"+property.split('_').join(' ')+"</th>");

						for(i=0;i<data.length;i++)
						{
							$(".view-table").append("<tr class='clickable-row' data-href='/"+parentModel+"/"+model+"/"+data[i]['id']+"' id = 'data-tr-"+i+"'></tr>");

							$("#data-tr-"+i).append("<td>"+data[i][property]+"</td>");
						}
					}


			}
			else
			{
				$(".view-table").hide();
			}

			$(".clickable-row").click(function() {
		        window.document.location = $(this).data("href");
		    });
		},
		error: function(data){
			$(".view-table").hide();
		}
	});
}
