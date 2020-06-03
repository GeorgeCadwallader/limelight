$(document).on('pjax:start', function() {
     $('.pjax-refresh-item').fadeOut(3000);
}).on('pjax:end', function() {
    $('.review-text-content').each(function(i, element) {
        let height = $(element).css('height').replace('px', '');
        let readBtn = $(element).siblings('.read-more-btn');
        
        if (height > '100') {
            readBtn.css('display', 'none');
        }
    });

    bindReadMore();

    $('.pjax-refresh-item').fadeIn(3000);
});

function bindReadMore() {
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
}