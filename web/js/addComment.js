$(document).ready(function() {
    $('#addComment').click(function (key) {
        var comment = $("#comment").val();

        if (comment.length === 0) {
            return;
        }
        var productId = $("#product-id").val();
        $.post("/product/addComment", {
            "comment": comment,
            "productId": productId
        }, function(returnedMessage) {
            if (returnedMessage === "OK") {
                location.reload();
            } else {
                alert(returnedMessage);
            }
        });
    });
});