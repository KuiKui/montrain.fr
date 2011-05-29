$(document).ready(function() {
  $("#contenu").val("").focus();
  displayStartMessages();
  $("#messageForm").bind("submit", function(e) {
    $("#ecrire").hide();
    addMessage();
    $("#ecrire").show();
    return false;
  });
});

function displayStartMessages() {
  displayMessages($("#discussionId").val());
}

function displayUnreadMessages() {
  var lastMessageId = null;
  if($("#messagesList") != undefined && $("#messagesList").attr("data-last-message-id") != undefined){
    lastMessageId = parseInt($("#messagesList").attr("data-last-message-id")) + 1;
  }
  displayMessages($("#discussionId").val(), lastMessageId);
}

function addMessage() {
  var contenu = $("#contenu").val();
  var maxLength = $("#contenu").attr("maxlength");

  if(contenu.length > maxLength){
    $("#informations").text("Votre message est trop long").removeClass("valid").addClass("error").show();
  } else if(contenu.length == 0){
    $("#informations").text("Votre message est vide").removeClass("valid").addClass("error").show();
  } else{
    $.ajax({
      type: "POST",
      url: "/index.php/home/addMessage",
      data: ({discussionId: $("#discussionId").val(), contenu: contenu}),
      dataType: "json",
      success: function(msg) {
        var infos = "";
        if(msg != undefined && msg.length > 0 && (infos = eval(msg)) != undefined && infos.returnCode == 0){
          $("#contenu").val("").focus();
        } else{
          $("#informations").text("Impossible de publier votre message").removeClass("valid").addClass("error").show().fadeOut(2000);
          $("#ecrire").show();
        }
        displayUnreadMessages();
      },
      error: function() {
        $("#informations").text("Impossible de publier votre message").removeClass("valid").addClass("error").show().fadeOut(2000);
        $("#ecrire").show();
      }
    });
  }
}

function displayMessages(discussionId, startMessagesId) {
  startMessagesId = startMessagesId || null;

  $.ajax({
    type: "POST",
    url: "/frontend_dev.php/home/getLastMessages",
    data: ({discussionId: discussionId, startMessagesId: startMessagesId}),
    dataType: "json",
    success: function(msg) {
      var infos = "";
      if(msg != undefined && msg.length > 0 && (infos = eval(msg)) != undefined){
        var lastMessageId = 0;
        var count = 0;
        // TODO: passer "amount" (3) dans le retour json (c'est le controleur qui decide seul du nombre d'élément à afficher
        $.each(infos, function(index, item) {
          if(count < 3){
            $("#messagesList").prepend('<li><span class="couleurCustom" style="background-color:#' + item.couleur + ';"></span><span class="contenu">' + item.contenu + '</span><span class="timing">' + item.heure + '</span></li>');
            lastMessageId = item.id;
            count++;
          }
        });
        $("#messagesList").attr("data-last-message-id", lastMessageId);
        $('#messagesList').children().filter(
          function(index) {
            return (index >= 3);
          }).remove();
      }
      return true;
    },
    error: function() {
      return false;
    }
  });
}
