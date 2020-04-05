$('.review-edit-btn').click(function() {
    var reviewView = $('.review-view-container-' + $(this).data('review-id'));
    var reviewEdit = $('.review-edit-container-' + $(this).data('review-id'));

    if (reviewView.is(':visible')) {
        reviewView.hide('slow');
        reviewEdit.show('slow');
        return;
    }

    reviewEdit.hide('slow');
    reviewView.show('slow');
});