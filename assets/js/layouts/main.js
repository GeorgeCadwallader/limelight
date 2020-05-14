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
    $('.pjax-refresh-item').fadeIn(3000);
});