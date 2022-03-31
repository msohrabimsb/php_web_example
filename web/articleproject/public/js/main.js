function clear_form() {
    $('.app-main form .form-control').val('');
    $('.app-main form input').removeClass('is-invalid');
    $('.app-main form textarea').removeClass('is-invalid');
    $('.app-main form div.invalid-feedback').html('');
}