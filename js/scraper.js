$(document).ready(function() {

	function loader() {
		var loader_html = "<img src=\"box.gif\" style=\"position: absolute; top: 50%; left: 50%; margin-right: -50%; transform: translate(-50%, -50%);height:250px;width:250px;\">";
		$("#table").html(loader_html);
	}

	// login form client side validation
	$("#search_btn").click(function(event) {
		$("#table").html("");
		var city = $("#city").val().trim();
		var error_free=true;

		// city field
		if (city.length === 0) {
			$("#city").css("border", "2px solid red");
			$("#city").attr("placeholder", "This field is required");
			error_free=false;
			event.preventDefault();
		}
		else {
			$("#city").css("border", "3px solid green");
		}

		// ajax request to server
		if (error_free) {
			$.ajax({
				method: "GET",
				url: "city.php",
				data: {city: city}
			})
			.done(function( table_html ) {
				$("#table").html(table_html);
			})
			.fail(function( jqXHR, textStatus, errorThrown) {
				console.log( "Request failed: " + textStatus + " " + errorThrown + " " + jqXHR.status);
			});
			loader();
		}
	});

	$("#city").keypress(function(event){
		if(event.keyCode == 13){
			event.preventDefault();
			$("#search_btn").trigger("click");
		}
	});

});
