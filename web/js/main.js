$(function () {
    $('#create_lt_btn').click(function () {
        $('#lt_generator_modal').modal('show').find('#lt_modal_content').load($(this).attr('value'));
    })
});