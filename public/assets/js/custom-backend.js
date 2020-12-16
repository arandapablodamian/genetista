$(document).ready(function () {
    var $markdownInputs = $('#subsection_isAutomatic')
    $markdownInputs.click(function() {
        console.log("prueba")
        $('#subsection_answers').prop("disabled", $(this).is(':checked'))
    })
});