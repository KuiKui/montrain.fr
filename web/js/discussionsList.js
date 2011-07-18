$(document).ready(function() {
  $("#titre").val("").focus();
  displayStartDiscussions();
  $("#discussionForm").bind("submit", function(e) {
    $("#creer").hide();
    $("#informations").text("").removeClass("valid").removeClass("error").hide()
    addDiscussion();    
    $("#creer").show();
    return false;
  });
  $("#moreDiscussions").bind("click", function(e) {
    displayMoreDiscussions();
    return false;
  });
});

function displayStartDiscussions() {
  loadNewestDiscussions($("#ligneId").val());
}

function displayUnreadDiscussions() {
  loadNewestDiscussions($("#ligneId").val(), getNewestVisibleDiscussion());
}

function displayMoreDiscussions() {
  loadMoreDiscussions($("#ligneId").val(), getOldestVisibleDiscussion());
}

function addDiscussion() {
  var titre = $("#titre").val();
  var maxLength = $("#titre").attr("maxlength");

  if(titre.length > maxLength){
    $("#informations").text("Votre titre est trop long").removeClass("valid").addClass("error").show();
  } else if(titre.length == 0){
    $("#informations").text("Votre titre est vide").removeClass("valid").addClass("error").show();
  } else{
    $.ajax({
      type: "POST",
      url: "/index.php/home/addDiscussion",
      data: ({ligneId: $("#ligneId").val(), titre: titre}),
      dataType: "json",
      success: function(msg) {
        var infos = "";
        if(msg != undefined && msg.length > 0 && (infos = eval(msg)) != undefined && infos.returnCode == 0){
          $("#titre").val("").focus();
        } else{
          $("#informations").text("Impossible de créer votre discussion").removeClass("valid").addClass("error").show().fadeOut(2000);
          $("#creer").show();
        }
        displayUnreadDiscussions();
      },
      error: function() {
        $("#informations").text("Impossible de créer votre discussion").removeClass("valid").addClass("error").show().fadeOut(2000);
        $("#creer").show();
      }
    });
  }
}

function loadNewestDiscussions(ligneId, lowerBoundId) {
  lowerBoundId = lowerBoundId || null;
  $.ajax({
    type: "POST",
    url: "/frontend_dev.php/home/getDiscussions",
    data: ({ligneId: ligneId, lowerBoundId: lowerBoundId, reverseResults: 1}),
    dataType: "json",
    success: function(json) {
      var infos = "";
      if(json != undefined && (infos = eval(json)) != undefined) {
        $.each(infos.discussions, function(index, item) {
            $("#discussionsList").prepend(decorateDiscussion(item));
        });
        $("#moreDiscussions").toggle($("#discussionsList li").length < infos.total);
      }
      return true;
    },
    error: function() {
      return false;
    }
  });
}

function loadMoreDiscussions(ligneId, upperBoundId) {
  upperBoundId = upperBoundId || null;
  $("#moreDiscussions").hide();
  $.ajax({
    type: "POST",
    url: "/frontend_dev.php/home/getDiscussions",
    data: ({ligneId: ligneId, upperBoundId: upperBoundId, reverseResults: 0}),
    dataType: "json",
    success: function(json) {
      var infos = "";
      if(json != undefined && (infos = eval(json)) != undefined) {
        $.each(infos.discussions, function(index, item) {
            $("#discussionsList").append(decorateDiscussion(item));
        });
        $("#moreDiscussions").toggle($("#discussionsList li").length < infos.total);
      }
      return true;
    },
    error: function() {
      $("#moreDiscussions").show();
      return false;
    }
  });
}

function decorateDiscussion(discussion) {
  var htmlRender = ""
  if(discussion == undefined) {
    return htmlRender;
  }
  htmlRender = '<li data-discussion-id="' + discussion.id + '"><a href="' + discussion.lien + '">' + discussion.titre + '</a></li>';
  return htmlRender;
}

function getNewestVisibleDiscussion() {
  if($("#discussionsList") == undefined || $("#discussionsList").length == 0) {
    return null;
  }
  var discussionId = $("#discussionsList li").first().attr("data-discussion-id");
  if(discussionId == undefined) {
    return null;
  }
  return discussionId;
}

function getOldestVisibleDiscussion() {
  if($("#discussionsList") == undefined || $("#discussionsList").length == 0) {
    return null;
  }
  var discussionId = $("#discussionsList li").last().attr("data-discussion-id");
  if(discussionId == undefined) {
    return null;
  }
  return discussionId;
}
