$(document).on('pjax:start', function() {
     $('.pjax-refresh-item').fadeOut(3000);
}).on('pjax:end', function() {
    $('.pjax-refresh-item').fadeIn(3000);
});