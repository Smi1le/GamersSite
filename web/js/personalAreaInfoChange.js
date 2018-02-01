$(document).ready(function() {
    $("#login_field").blur(function() {
        var value = $("#login_field").val();
        $.post("/personal/update/login/" + value);
    });

    $("#email_field").blur(function() {
        var value = $("#email_field").val();
        $.post("/personal/update/email/" + value);
    });

    $("#nickname_field").blur(function() {
        var value = $("#nickname_field").val();
        $.post("/personal/update/nickname/" + value);
    });

    $("#avatar-button").click(function() {
        $("#change-button").show();
        $("#avatar-accept").show();
        $(".main-section").css('z-index',0);
        $('#layer').fadeIn('fast');
    });

    $("#layer").click(function(){
        $(this).fadeOut('fast');
        $("#change-button").hide();
        $("#avatar-accept").hide();
    });

    $("#change-button").hide();
    $("#avatar-accept").hide();
});