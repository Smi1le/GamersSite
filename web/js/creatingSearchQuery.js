$(document).ready(function() {
    jQuery("#search-button").click(function(e) {
        var searchValue = $("#search-input").val();
        location.href = "/catalog?s=" + searchValue;
    });

    $('#search-input').keyup(function(e){
        if(e.keyCode === 13) {
            var searchValue = jQuery("#search-input").val();
            location.href = "/catalog?s=" + searchValue;
        }
    })
});