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

$(document).ready(function() {
    $('.review-text-content').each(function(i, element) {
        let height = $(element).css('height').replace('px', '');
        let readBtn = $(element).siblings('.read-more-btn');
        
        if (height > '100') {
            readBtn.css('display', 'none');
        }
    });
    $('.profile-bio').each(function(i, element) {
        let height = $(element).css('height').replace('px', '');
        let readBtn = $(element).siblings('.read-more-profile-btn');

        if (height > '100') {
            readBtn.css('display', 'none');
        }
    });
});

$('.read-more-btn').click(function() {
    let text = $(this).siblings('.review-text-content');
    let maxHeight = $(text).css('max-height');

    if (maxHeight === '100px') {
        $(this).text('Read Less ...');
        $(text).css('max-height', '100%');
    } else {
        $(this).text('Read More ...');
        $(text).css('max-height', '100px');
    }
});

$('.read-more-profile-btn').click(function() {
    let text = $(this).siblings('.profile-bio');
    let maxHeight = $(text).css('max-height');

    if (maxHeight === '100px') {
        $(this).text('Read Less ...');
        $(text).css('max-height', '100%');
    } else {
        $(this).text('Read More ...');
        $(text).css('max-height', '100px');
    }
});