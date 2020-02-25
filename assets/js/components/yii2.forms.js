// @ts-check

import $ from 'jquery';

/**
 * Converts bootstrap 3 form feedback to bootstrap 4 classes
 */
$('form').on('afterValidateAttribute', event => {
    let $form = $(event.currentTarget);

    $form.find('.is-valid').removeClass('is-valid');
    $form.find('.valid-feedback').removeClass('valid-feedback');

    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback').removeClass('invalid-feedback');

    $form.find('.form-group.has-error .form-control').addClass('is-invalid');
    $form
        .find('.form-group.has-error .help-block')
        .addClass('invalid-feedback');

    $form.find('.form-group.has-success .form-control').addClass('is-valid');
    $form
        .find('.form-group.has-success .help-block')
        .addClass('valid-feedback');
});

/**
 * Stops the spinner buttons if there are form errors
 */
$('form').on('afterValidateAttribute', event => {
    let $form = $(event.currentTarget);

    if ($form.find('.has-error').length > 0) {
        $form.find('.btn-spinner.spinning').btnSpinner('stop');
    }
});
