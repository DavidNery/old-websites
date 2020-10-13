function copyIp(element, ip) {
	element.html("IP Copiado!");
	var copy = $("<input type='text' value='" + ip + "'>");
	$("body").append(copy);
	copy.val(ip).select();
	document.execCommand("copy");
	copy.remove();
	setTimeout(function() {
		element.html("Copiar IP");
	}, 1000);
}

function openModal(id) {
	var modal = $("#" + id);
	if(modal.length > 0){
		$("body").addClass("notoverflow");
		modal.show();
		var modalcontent = modal.find(".modal-content").first();
		modalcontent.show();
		modalcontent.css({"visibility": "visible", "opacity": "1"});
		modalcontent.addClass("bounce-in");

		modalcontent.mousedown(function(e) {e.stopPropagation()});

		modal.mousedown(function() {
			modalcontent.removeClass("bounce-in");
			modalcontent.addClass("bounce-out");
			setTimeout(function() {
				$("body").removeClass("notoverflow");
				modalcontent.removeClass("bounce-out");
				modalcontent.hide();
				modal.hide();
			}, 490);
		});
	}
}

$(document).ready(function() {
	"use strict";

	$(".nav .toggle").click(function() {
		$(this).toggleClass("open");
		var navbar = $(this).parent().find(".navbar").first();
		navbar.toggleClass("responsive");
	});

	$("[data-modal]").click(function(e) {
		e.preventDefault();
		openModal($(this).data("modal"));
	});

});