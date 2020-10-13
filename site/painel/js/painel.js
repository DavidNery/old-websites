$(document).ready(function() {
	"use strict";
	
	var content = $("#content"), itemModal = $("#itemModal"), editItemModal = $("#editItemModal"), editItemModal = $("#editItemModal"), editContent = $("#editContent");
	
	var editarNoticia = $("#editarNoticia"), editarItem = $("#editarItem"), editarButton = $("#editarButton");
	
	content.jqte();
	itemModal.jqte();
	editItemModal.jqte();
	editContent.jqte();

	$("#formNovaNoticia").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		data += "&content="+content.parent().parent().find(".jqte_editor").first().html();
		$.post("novaNoticia.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formEditarNoticia").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("editarNoticia.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formNovoUsuario").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("novoUsuario.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formNovoItem").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("novoItem.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formEditarItem").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("editarItem.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formNovoButton").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("novoButton.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$("#formEditarButton").submit(function(e) {
		e.preventDefault();
		var form = $(this);
		var data = form.serialize();
		$.post("editarButton.php", data, function(result) {
			var alert = form.parent().find(".alert").first();
			if(!alert.is(":visible")) alert.slideToggle(200);
			alert.html(result.message);
			if(result.status == "success"){
				alert.addClass("alert-success");
				setTimeout(function() { location.reload(); }, 1000);
			}else{
				alert.addClass("alert-danger");
			}
		}, "json");
	});
	
	$(".editNoticia").click(function(e) {
		e.preventDefault();
		openModal("editarNoticia");
		var inputsNoticia = $(this).parent().parent().parent().find("input");
		var inputs = editarNoticia.find("input");
		inputs.eq(0).val(inputsNoticia.eq(0).val());
		inputs.eq(1).val($(this).parent().parent().parent().find(".title").first().html());
		editContent.parent().parent().find(".jqte_editor").first().html(inputsNoticia.eq(1).val());
	});
	
	$(".editItem").click(function(e) {
		e.preventDefault();
		openModal("editarItem");
		var inputsItem = $(this).parent().parent().find("input");
		var inputs = editarItem.find("input");
		inputs.eq(0).val(inputsItem.eq(0).val());
		inputs.eq(1).val(inputsItem.eq(1).val());
		inputs.eq(2).val(inputsItem.eq(2).val());
		inputs.eq(3).val(inputsItem.eq(3).val());
		editItemModal.parent().parent().find(".jqte_editor").first().html(inputsItem.eq(4).val());
	});
	
	$(".editButton").click(function(e) {
		e.preventDefault();
		openModal("editarButton");
		var inputsButton = $(this).parent().parent().find("input");
		var inputs = editarButton.find("input");
		inputs.eq(0).val(inputsButton.eq(0).val());
		inputs.eq(1).val(inputsButton.eq(1).val());
		editarButton.find("select").first().val(inputsButton.eq(2).val());
		inputs.eq(2).val(inputsButton.eq(3).val());
	});
	
});