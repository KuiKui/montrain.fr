$(document).ready(function() {
  $("#contenu").val("").focus();
  displayStartMessages();
  $("#messageForm").bind("submit", function(e) {
    $("#ecrire").hide();
    addMessage();    
    $("#ecrire").show();
    return false;
  });
  $("#moreMessages").bind("click", function(e) {
    displayMoreMessages();
    return false;
  });
});

function displayStartMessages() {
  loadNewestMessages($("#discussionId").val());
}

function displayUnreadMessages() {
  loadNewestMessages($("#discussionId").val(), getNewestVisibleMessage());
}

function displayMoreMessages() {
  loadMoreMessages($("#discussionId").val(), getOldestVisibleMessage());
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

function loadNewestMessages(discussionId, lowerBoundId) {
  lowerBoundId = lowerBoundId || null;
  $.ajax({
    type: "POST",
    url: "/frontend_dev.php/home/getMessages",
    data: ({discussionId: discussionId, lowerBoundId: lowerBoundId, reverseResults: 1}),
    dataType: "json",
    success: function(json) {
      var infos = "";
      if(json != undefined && (infos = eval(json)) != undefined) {
        $.each(infos.messages, function(index, item) {
            $("#messagesList").prepend(decorateMessage(item));
        });
        $("#moreMessages").toggle($("#messagesList li").length < infos.total);
      }
      return true;
    },
    error: function() {
      return false;
    }
  });
}

function loadMoreMessages(discussionId, upperBoundId) {
  upperBoundId = upperBoundId || null;
  $("#moreMessages").hide();
  $.ajax({
    type: "POST",
    url: "/frontend_dev.php/home/getMessages",
    data: ({discussionId: discussionId, upperBoundId: upperBoundId, reverseResults: 0}),
    dataType: "json",
    success: function(json) {
      var infos = "";
      if(json != undefined && (infos = eval(json)) != undefined) {
        $.each(infos.messages, function(index, item) {
            $("#messagesList").append(decorateMessage(item));
        });
        $("#moreMessages").toggle($("#messagesList li").length < infos.total);
      }
      return true;
    },
    error: function() {
      $("#moreMessages").show();
      return false;
    }
  });
}

function decorateMessage(message) {
  var htmlRender = ""
  if(message == undefined) {
    return htmlRender;
  }
  htmlRender = '<li data-message-id="' + message.id + '"><span class="couleurCustom" style="background-color:#' + message.couleur + ';"></span><span class="timing">' + message.heure + '</span><span class="contenu">' + message.contenu + '</span></li>';
  return htmlRender;
}

function getNewestVisibleMessage() {
  if($("#messagesList") == undefined || $("#messagesList").length == 0) {
    return null;
  }
  var messageId = $("#messagesList li").first().attr("data-message-id");
  if(messageId == undefined) {
    return null;
  }
  return messageId;
}

function getOldestVisibleMessage() {
  if($("#messagesList") == undefined || $("#messagesList").length == 0) {
    return null;
  }
  var messageId = $("#messagesList li").last().attr("data-message-id");
  if(messageId == undefined) {
    return null;
  }
  return messageId;
}
