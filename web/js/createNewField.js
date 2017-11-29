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
            e.preventDefault();

            var emailList = jQuery(fieldListId);

            // grab the prototype template
            var newWidget = emailList.attr('data-prototype');
            // replace the "__name__" used in the id and name of the prototype
            // with a number that's unique to your emails
            // end name attribute looks like name="contact[emails][2]"
            newWidget = newWidget.replace(/__name__/g, counter);
            counter++;

            // create a new list element and add it to the list
            var newLi = jQuery('<li></li>').html(newWidget);
            newLi.appendTo(emailList);
        });
    });
}