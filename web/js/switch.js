$(document).ready(function() {
    $('#to-reg').click(function (key) {
        changeToRegistration();
    });

    $('#to-auth').click(function (key) {
        changeToAuth();
    });

    $('#to-reg2').click(function (key) {
        changeToRegistration();
    });

    $('#to-auth2').click(function (key) {
        changeToAuth();
    });

    function changeToRegistration() {
        jQuery("#auth-block").hide();
        jQuery("#reg-block").show();
    }

    function changeToAuth() {
        jQuery("#auth-block").show();
        jQuery("#reg-block").hide();
    }
});