/**
 *
 * @param counter integer
 * @param buttonId string
 * @param fieldListId string
 */
function listenForCreateField(counter, buttonId, fieldListId) {
    $(document).ready(function() {
        jQuery(buttonId).click(function(e) {
            var count = 1;
            if (buttonId === "#add-another-characteristic") {
                count = 2;
            }
            if (buttonId === "#add-photo" && counter === 1) {
                return;
            }
            var block = jQuery('<div></div>');
            for (var i = 0; i < count; i++) {
                e.preventDefault();
                var emailList = jQuery(fieldListId);
                var newWidget = emailList.attr('data-prototype');
                newWidget = newWidget.replace(/__name__/g, counter++);
                var newLi;
                if (buttonId === "#add-another-characteristic") {
                    newLi = jQuery('<div class="field-characteristic"></div>').html(newWidget);
                } else {
                    newLi = jQuery('<div></div>').html(newWidget);
                }
                newLi.appendTo(block);
            }
            block.appendTo(emailList);
        });
    });
}