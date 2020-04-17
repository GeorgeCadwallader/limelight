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

$('.read-more').click(function() {
    let moreText = $('.more-text[data-id=' + $(this).data('id') + ']');
    let dots = $('.more-text-dots[data-id=' + $(this).data('id') + ']');

    console.log();

    if ($(moreText).is(':visible')) {
        $(this).text('Read More ...');
        $(dots).show();
        $(moreText).hide();
    } else {
        $(this).text('Read Less ...');
        $(dots).hide();
        $(moreText).show();
    }
});