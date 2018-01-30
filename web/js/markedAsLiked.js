$(document).ready(function() {
    $('#marker').click(function (key) {
        var productId = jQuery("#product-id").val();
        var className = $('#marker').attr('class');
        if (className === "marker-container not-marked") {
            $.post("/liked/true/" + productId, function(data) {});
            marked('not-marked', 'marked');
        } else {
            $.post("/liked/false/" + productId, function(data) {});
            marked('marked', 'not-marked')
        }

        function marked(removeClass, addClass) {
            var marker = $('#marker');
            marker.removeClass(removeClass);
            marker.addClass(addClass);
        }
    });
});