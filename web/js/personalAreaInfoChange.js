$(document).ready(function() {
    $("#login_field").blur(function() {
        var value = $("#login_field").val();
        $.post("/personal/update/login/" + value);
    });

    $("#email_field").blur(function() {
        var value = $("#email_field").val();
        $.post("/personal/update/email/" + value);
    });

    $("#delete-product").blur(function() {
        var value = $("#product-id").val();
        $.post("/personal/update/deleteProduct/" + value);
    });

    $("#nickname_field").blur(function() {
        var value = $("#nickname_field").val();
        $.post("/personal/update/nickname/" + value);
    });

    $("#avatar-button").click(function() {
        $("#upload-form").show();
        $("#avatar-accept").show();
        $(".main-section").css('z-index',0);
        $('#layer').fadeIn('fast');
    });

    $("#layer").click(function(){
        $(this).fadeOut('fast');
        $("#upload-form").hide();
        $("#avatar-accept").hide();
    });

    $("#upload-form").hide();
    $("#avatar-accept").hide();
});