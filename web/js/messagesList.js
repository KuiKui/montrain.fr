$(document).ready(function() {
	$("#contenu").val("").focus();
	$("#messageForm").bind("submit", function(e) {
		$("#ecrire").hide();
		addMessage();
		return false;
	});
}); 

function addMessage() {
	var contenu = $("#contenu").val();

	if(contenu.length > 140) {
		$("#informations").text("Votre message est trop long").removeClass("valid").addClass("error").show();
	} else if (contenu.length == 0) {
		$("#informations").text("Votre message est vide").removeClass("valid").addClass("error").show();
	} else {
		$.ajax({
			type: "POST",
		    	url: "home/addMessage",
			data: ({discussionId: $("#discussionId").val(), contenu: contenu}),
		    	dataType: "json",
		    	success: function(msg) {
				var infos = "";
				if(msg != undefined && msg.length > 0 && (infos=eval(msg)) != undefined && infos.returnCode == 0) {
					displayUnreadMessages();
					$("#contenu").val("").focus();
				} else {
					$("#informations").text("Impossible de publier votre message").removeClass("valid").addClass("error").show().fadeOut(2000);
					$("#ecrire").show();
				}
		    	},
		    	error: function() {
				$("#informations").text("Impossible de publier votre message").removeClass("valid").addClass("error").show().fadeOut(2000);
				$("#ecrire").show();
		    	}
		});
	}
}

function displayUnreadMessages() {
	if($("#messagesList") == undefined || $("#messagesList").attr("data-last-message-id") == undefined || $("#messagesList").attr("data-last-message-id") == 0)
		return;

	$.ajax({
		type: "POST",
	    	url: "home/getMessages",
		data: ({discussionId: $("#discussionId").val(), lastMessageId: $("#messagesList").attr("data-last-message-id")}),
	    	dataType: "json",
	    	success: function(msg) {
			var infos = "";
			if(msg != undefined && msg.length > 0 && (infos=eval(msg)) != undefined) {
				var lastMessageId = 0;
				$.each(infos, function(index, item) {
					$("#messagesList").prepend('<li><span class="contenu">' + item.contenu + '</span><span class="timing">' + item.heure + '</span></li>');
					lastMessageId = item.id;
		                });
				$("#messagesList").attr("data-last-message-id", lastMessageId);
			}
			$("#ecrire").show();
	    	},
	    	error: function() {
			$("#ecrire").show();
	    	}
	});
}
