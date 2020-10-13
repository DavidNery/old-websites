function copyIp(element, ip) {
	var text = element.html();

	element.html("IP Copiado!");
	var copy = $("<input type='text' value='" + ip + "'>");
	$("body").append(copy);
	copy.val(ip).select();
	document.execCommand("copy");
	copy.remove();
	setTimeout(function() {
		element.html(text);
	}, 1000);
}

$(document).ready(function() {

	const PLAYERSON = $("#playerson"), IP = "backmc.net";

	$(".nav .toggle").click(function(e) {
		e.preventDefault();

		$(this).parent().toggleClass("responsive");
	});

	$(".navbar li a").click(function(e) {
		e.stopPropagation();
	});

	$(".navbar").click(function(e) {
		e.preventDefault();

		$(this).parent().toggleClass("responsive");
	});

	$(".card.toggler .card-title .toggle").click(function(e) {
		e.preventDefault();

		var body = $(this).parent().parent().find(".card-body").eq(0);

		if(body.is(":visible"))
			$(this).html('<i class="fas fa-angle-down"></i>');
		else
			$(this).html('<i class="fas fa-angle-down fa-rotate-180"></i>');

		body.slideToggle(500);
	});

	$(".modal .modal-content").click(function(e) {
		e.stopPropagation();
	});

	$("[target-type=\"modal\"]").click(function(e) {
		e.preventDefault();

		var modal = $(this).attr("target");
		if(modal != undefined) {
			modal = $("#" + modal);
			$("body").attr("style", "overflow-y: hidden");
			modal.addClass("open");

			modal.click(function(event) {
				event.preventDefault();

				$(this).removeClass("open").addClass("closing");
				setTimeout(function() {
					modal.removeClass("closing");
					$("body").attr("style", "");
				}, 800);
			});
		}
	});

	PLAYERSON.click(function(e) {
		e.preventDefault();

		copyIp($(this), IP);
	});

	setInterval(function() {
		$.get("https://use.gameapis.net/mc/query/players/" + IP, function(response) {
			if(response.status == true){
				PLAYERSON.html("<span>" + response.players.online + "</span> players online!");
			}else{
				PLAYERSON.html("Servidor <span>OFF</span>!");
			}
		}, "json");
	}, 5000);

});