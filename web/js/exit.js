$(document).ready(function() {
    $("#exit-button").click(function (key) {
        $.post("/exit", function(data) {
            if (data === "Exit") {
                window.location.replace("/personal");
            }
        });
    });
});