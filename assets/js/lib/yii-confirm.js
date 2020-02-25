// @ts-check

/**
 * Override for the yii2 confirm
 *
 * This will make yii2 use a bootstrap modal for link confirmation instead of
 * the default js alert.
 */

import $ from 'jquery';

const template = `
<div class="modal fade yii-confirm" id="{{id}}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">{{body}}</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success modal-ok">{{ok_text}}</button>
                <button type="button" class="btn btn-danger modal-cancel">{{cancel_text}}</button>
            </div>
        </div>
    </div>
</div>
`;

window.yii.confirm = (message, ok, cancel) => {
    let id = Math.random()
            .toString(36)
            .slice(2),
        _template = template;

    let templateData = {
        id: id,
        cancel_text: 'No',
        ok_text: 'Yes',
        body: message
    };

    for (let place_holder in templateData) {
        _template = _template.replace(
            '{{' + place_holder + '}}',
            templateData[place_holder]
        );
    }

    $('body').append(_template);

    let $modal = $('#' + id);

    $modal.modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });

    $modal.find('.modal-cancel').on('click', () => {
        !cancel || cancel();
        $modal.modal('hide');
    });

    $modal.find('.modal-ok').on('click', () => {
        !ok || ok();
        $modal.modal('hide');
    });

    $modal.on('hidden.bs.modal', () => {
        setTimeout(() => {
            $modal.remove();
        }, 1000);
    });
};
