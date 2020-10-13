$(document).ready(function() {

	"use strict";

	$(".item").click(function(e) {
		e.preventDefault();

		var item = $(this);

		item.find("i").first().toggleClass("fa-rotate-180");
		item.find(".item-content").first().slideToggle(200);
	});

	$(".item .item-content").click(function(e) {
		e.stopPropagation();
	});

	$(".foto-change .foto-click").click(function(e) {
		e.preventDefault();

		var fotochange = $($(this).parent());

		if(fotochange.attr("disabled") != undefined){
			var divalert = $("<div class='alert alert-danger'>Aguarde para poder alterar a foto!</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			setTimeout(function() {
				setTimeout(function() {
					divalert.remove();
				}, 900);
				divalert.addClass("fade-out-up");
				parent.removeAttr("disabled");
				fotoclick.html("Alterar");
			}, 1500);
			return;
		}
		fotochange.find("input").first().click();
	});

	$(".userphoto").change(function(change) {
		var file = $(this), parent = $(file.parent());
		var fotoclick = parent.find(".foto-click").first();
		parent.attr("disabled", "");
		if(this.files && this.files[0]){
			var reader = new FileReader();
			reader.readAsDataURL(this.files[0]);
			reader.onload = function(e) {
				parent.find("img").first().attr("src", e.target.result);
				if(parent.hasClass("disable")) return;
				var data = new FormData();
				data.append("photoContent", change.target.files[0]);
				if(parent.data("user") != null)
					data.append("user", parent.data("user"));
				$.ajax({
					type: "POST",
					url: "/site4/system/updateUserPhoto.php",
					data: data,
					async: true,
					cache: false,
					contentType: false,
					processData: false,
					success: function(data) {
						var response = JSON.parse(data);
						var divalert = $("<div class='alert alert-"+response.status+"'>"+response.message+"</div>");
						$("body").append(divalert);
						divalert.addClass("fade-in-up");
						if(response.status == "success"){
							fotoclick.html("Enviado!");
							setTimeout(function() {
								location.reload();
							}, 1500);
						}else{
							setTimeout(function() {
								setTimeout(function() {
									divalert.remove();
								}, 900);
								divalert.addClass("fade-out-up");
								parent.removeAttr("disabled");
								fotoclick.html("Alterar");
							}, 1500);
						}
					},
					xhr: function(){
						var xhr = $.ajaxSettings.xhr();
						xhr.upload.onprogress = function(e){
							fotoclick.html("Enviando ("+e.loaded/e.total*100+"%)...");
						};
						return xhr;
					}
				});
			}
		}else{
			parent.removeAttr("disabled");
		}
	});

	$("#formcp").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);
		$.post("/site4/system/changePassword.php", form.serialize(), function(result) {
			var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			submit.html("Alterar");
			if(result.status == "success"){
				setTimeout(function() {
					location.reload();
				}, 1500);
			}else{
				setTimeout(function() {
					setTimeout(function() {
						divalert.remove();
					}, 900);
					divalert.addClass("fade-out-up");
					submit.prop("disabled", false);
				}, 1500);
			}
		}, "json");
	});

	$("#novacategoria").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);
		$.post("/site4/system/addCategoria.php", form.serialize(), function(result) {
			var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			submit.html("Adicionar");
			if(result.status == "success"){
				setTimeout(function() {
					location.href = "/site4/painel/categorias";
				}, 1500);
			}else{
				setTimeout(function() {
					setTimeout(function() {
						divalert.remove();
					}, 900);
					divalert.addClass("fade-out-up");
					submit.prop("disabled", false);
				}, 1500);
			}
		}, "json");
	});

	$(".item-content").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);
		$.post("/site4/system/editCategoria.php", form.serialize(), function(result) {
			var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			submit.html("Adicionar");
			if(result.status == "success"){
				setTimeout(function() {
					location.href = "/site4/painel/categorias";
				}, 1500);
			}else{
				setTimeout(function() {
					setTimeout(function() {
						divalert.remove();
					}, 900);
					divalert.addClass("fade-out-up");
					submit.prop("disabled", false);
				}, 1500);
			}
		}, "json");
	});

	$("#novapostagem").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		var data = new FormData(form[0]), checks = 0;

		form.find("input[type='checkbox']").each(function() {
			var checkbox = $(this);
			if(checkbox.is(":checked")) checks++;
		});

		if(checks == 0){
			var divalert = $("<div class='alert alert-danger'>Selecione ao menos uma categoria!</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			setTimeout(function() {
				setTimeout(function() {
					divalert.remove();
				}, 900);
				divalert.addClass("fade-out-up");
				submit.prop("disabled", false);
			}, 1500);
			return;
		}

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);

		$.ajax({
			type: "POST",
			url: "/site4/system/addPostagem.php",
			data: data,
			async: true,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				var result = JSON.parse(data);
				var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
				$("body").append(divalert);
				divalert.addClass("fade-in-up");
				submit.html("Adicionar");
				if(result.status == "success"){
					setTimeout(function() {
						location.href = "postagens";
					}, 1500);
				}else{
					setTimeout(function() {
						setTimeout(function() {
							divalert.remove();
						}, 900);
						divalert.addClass("fade-out-up");
						submit.prop("disabled", false);
					}, 1500);
				}
			},
		});
	});
	
	$("#editarpostagem").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		var data = new FormData(form[0]), checks = 0;

		form.find("input[type='checkbox']").each(function() {
			var checkbox = $(this);
			if(checkbox.is(":checked")){
				checks++;
			}else{
				data.append("remover[]", checkbox.attr("value"));
			}
		});

		if(checks == 0){
			var divalert = $("<div class='alert alert-danger'>Selecione ao menos uma categoria!</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			setTimeout(function() {
				setTimeout(function() {
					divalert.remove();
				}, 900);
				divalert.addClass("fade-out-up");
				submit.prop("disabled", false);
			}, 1500);
			return;
		}

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);

		$.ajax({
			type: "POST",
			url: "/site4/system/editPostagem.php",
			data: data,
			async: true,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				var result = JSON.parse(data);
				var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
				$("body").append(divalert);
				divalert.addClass("fade-in-up");
				submit.html("Adicionar");
				if(result.status == "success"){
					setTimeout(function() {
						location.href = "/site4/painel/postagens";
					}, 1500);
				}else{
					setTimeout(function() {
						setTimeout(function() {
							divalert.remove();
						}, 900);
						divalert.addClass("fade-out-up");
						submit.prop("disabled", false);
					}, 1500);
				}
			},
		});
	});

	$("#formEditarUsuario").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);
		$.post("/site4/system/editUsuario.php", form.serialize(), function(result) {
			var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
			$("body").append(divalert);
			divalert.addClass("fade-in-up");
			submit.html("Salvar");
			if(result.status == "success"){
				setTimeout(function() {
					location.href = "/site4/painel/equipe";
				}, 1500);
			}else{
				setTimeout(function() {
					setTimeout(function() {
						divalert.remove();
					}, 900);
					divalert.addClass("fade-out-up");
					submit.prop("disabled", false);
				}, 1500);
			}
		}, "json");
	});
	
	$("#formAdicionarUsuario").submit(function(e) {
		e.preventDefault();
		var form = $(this), submit = form.find("[type=\"submit\"]").first();

		var data = new FormData(form[0]);

		submit.html("<i class='fa fa-spinner fa-pulse fa-fw'></i>");
		submit.prop("disabled", true);

		$.ajax({
			type: "POST",
			url: "/site4/system/addUsuario.php",
			data: data,
			async: true,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data) {
				var result = JSON.parse(data);
				var divalert = $("<div class='alert alert-"+result.status+"'>"+result.message+"</div>");
				$("body").append(divalert);
				divalert.addClass("fade-in-up");
				submit.html("Adicionar");
				if(result.status == "success"){
					setTimeout(function() {
						location.href = "/site4/painel/equipe";
					}, 1500);
				}else{
					setTimeout(function() {
						setTimeout(function() {
							divalert.remove();
						}, 900);
						divalert.addClass("fade-out-up");
						submit.prop("disabled", false);
					}, 1500);
				}
			},
		});
	});
	
});