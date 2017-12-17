$(document).ready(function() {
    $('#reg_r').click(function (key) {
        changeToRegistration();
    });

    $('#auth_r').click(function (key) {
        changeToAuth();
    });

    $('#reg_a').click(function (key) {
        changeToRegistration();
    });

    $('#auth_a').click(function (key) {
        changeToAuth();
    });

    function changeToRegistration() {
        jQuery("#auth_block").hide();
        jQuery("#reg_block").show();
    }

    function changeToAuth() {
        jQuery("#auth_block").show();
        jQuery("#reg_block").hide();
    }
});