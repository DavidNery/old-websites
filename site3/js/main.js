$(document).ready(function() {
	"use strict";

	$(".nav .toggle").click(function() {
		$(this).toggleClass("open");
		var navbar = $(this).parent().find(".navbar").first();
		navbar.toggleClass("responsive");
	});

	$("#formlogin").submit(function(e) {
		var form = $(this), submit = form.find("[type=\"submit\"]").first();
		submit.attr("disabled", "");
		$.post("/site4/system/validarLogin.php", form.serialize(), function(response) {
			var alert = $("<div class='alert alert-"+response.status+"'>"+response.message+"</div>");
			$("body").append(alert);
			alert.addClass("fade-in-up");
			setTimeout(function() {
				if(response.status == "success"){
					location.reload();
				}else{
					setTimeout(function() {
						alert.remove();
					}, 900);
					alert.addClass("fade-out-up");
					submit.removeAttr("disabled");
				}
			}, 3000);
		}, "json");
		e.preventDefault();
	});

});