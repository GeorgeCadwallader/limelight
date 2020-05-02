$('.admin-link').on('click', function () {
    let index = $('.admin-link').index(this);
    let img = $(this).children('img')[0];

    if ($(this).hasClass('active')) {
        return;
    }

    $('.admin-link').each(function (i, el) {
        $(el).children('img').attr('src', `./images/A${i + 1}.png`);
    });

    $(img).attr('src', `./images/H${index + 1}.png`);
});