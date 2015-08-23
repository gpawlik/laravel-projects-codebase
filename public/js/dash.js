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
	handleHideableSelect();
	handleTaxModel();

	if(window.location.pathname.split("/")[1] == "dashboard")
	{
		handleGenderChart();
	}

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
							$(".view-table").append("<tr class='clickable-row' data-href='/"+parentModel+"/"+model+"/view/"+data[i]['id']+"' id = 'data-tr-"+i+"'></tr>");

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

function handleHideableSelect()
{

	//discipline type
	if($("#discipline-select").val() != "SUSPENSION")
	{
		$("#suspension-row").hide();
	}

	$("#discipline-select").on('change',function(){
		if(this.value == "SUSPENSION")
		{
			$("#suspension-row").show("medium");
		}
		else
		{
			$("#suspension-row").hide("medium");
		}
	});

	//banks
	if($("#loan-type-select").val() != "BANK LOAN")
	{
		$("#loan-type-row").hide();
	}

	$("#loan-type-select").on('change',function(){
		if(this.value == "BANK LOAN")
		{
			$("#loan-type-row").show("medium");
		}
		else
		{
			$("#loan-type-row").hide("medium");
		}
	});
}

function handleTaxModel()
{
	var identityCount = 2;

	$("#add-new-row-btn").click(function(){

		$("#tax-model-table").append(
			"<tr class = 'tax-model-row'>" +
	      "<td><input type = 'text' placeholder='Step Name' class = 'text-input' name = 'step_"+identityCount+"'></td>" +
	      "<td><input type = 'text' placeholder='Amount Limit' class = 'text-input' name = 'limit_"+identityCount+"'></td>" +
	      "<td><input type = 'text' placeholder='Rate %' class = 'text-input' name = 'rate_"+identityCount+"'></td>" +
	      "<td><div class = 'remove-row'><i class = 'fa fa-close' ></i></div></td>" +
	    "</tr>"
		)

		identityCount++;

		//handle close button click
		$(".remove-row").click(function(){

			$(this).closest("tr").remove();
		});

	});

	//handle close button click
	$(".remove-row").click(function(){

		$(this).closest("tr").remove();
	});


}

function handleGenderChart()
{

	$.ajax({
		method: "GET",
	  url: "/api/v1/gender_distro",
		success: function(values){
			console.log(values);

			var data = [
				{
	        value: values['male_number'],
	        color:"#2980b9",
	        highlight: "#21a560",
	        label: "Male"
		    },
		    {
	        value: values['female_number'],
	        color: "#e74c3c",
	        highlight: "#21a560",
	        label: "Female"
		    },
			]

			var ctx = $("#gender-chart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var myDoughnutChart = new Chart(ctx).Doughnut(data);

		},
		error: function(data){

		}
	});




}
