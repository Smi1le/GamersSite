// var emailCount = '{{ form.characteristics|length }}';

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
            var block = jQuery('<div></div>');
            for (var i = 0; i < count; i++) {
                e.preventDefault();

                var emailList = jQuery(fieldListId);

                // grab the prototype template
                var newWidget = emailList.attr('data-prototype');
                // replace the "__name__" used in the id and name of the prototype
                // with a number that's unique to your emails
                // end name attribute looks like name="contact[emails][2]"
                newWidget = newWidget.replace(/__name__/g, counter++);

                // create a new list element and add it to the list
                var newLi;
                if (buttonId === "#add-another-characteristic") {
                    // newLi.classList.add("field-characteristic");
                    newLi = jQuery('<div class="field-characteristic"></div>').html(newWidget);
                } else {
                    newLi = jQuery('<div></div>').html(newWidget);
                }
                newLi.appendTo(block);
            }
            // newLi.html += newWidget2;
            block.appendTo(emailList);
        });
    });
}