$(document).ready(function() {
	$("#gare").bind("change", function() {
		$("#discuter").hide();
		if($(this).val() > 0) {
			fillLignes($(this).val());
			$("#ligne").show();
                        $("#newGare").hide();
                        $("#newLigne").show();
		} else {
			$("#ligne").hide();
            $("#newLigne").hide();
            $("#newGare").show();
		}
	});
}); 

function fillLignes(gareId) {
	$("#ligne").get(0).options.length = 0;

        $.ajax({
            type: "POST",
            url: "/index.php/home/getLignesFromGare",
            data: ({gareId: gareId}),
            dataType: "json",
            success: function(msg) {
                $.each(msg, function(index, item) {
                    $("#ligne").get(0).options[$("#ligne").get(0).options.length] = new Option(item, index);
                });
			if($("#ligne").get(0).options.length > 0 ) {
			$("#discuter").show();
		}
            },
            error: function() {
                alert("Impossible de charger les lignes de cette gare");
            }
        });
}
