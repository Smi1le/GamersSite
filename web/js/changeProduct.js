$(document).ready(function() {
    $("#delete-product").click(function (key) {
        var productId = $("#product-id").val();
        $.post("/product/delete/" + productId, function (answer) {
            if (answer === "OK") {
                location.href = "/personal";
            }
        });
    });
});