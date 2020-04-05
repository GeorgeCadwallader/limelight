
$('.compare-artist-select').on('change', function (event) {
    var previous = $(this).data('previous');
    $('.compare-artist-select').not(this).find('option[value="' + previous + '"]').show();
    var value = $(this).val();
    $(this).data('previous', value);
    $('.compare-artist-select').not(this).find('option[value="' + value + '"]').hide();

    var valueOne = $('.compare-artist-select-one').val();
    var valueTwo = $('.compare-artist-select-two').val();
    var baseUrl = '/compare/artist';

    if (valueOne !== '' && valueTwo !== '') {
        $('.compare-artist-link').attr('href', baseUrl + '?artist_id_one=' + valueOne + '&artist_id_two=' + valueTwo);
    } else if (valueOne === '' && valueTwo === '') {
        $('.compare-artist-link').attr('href', baseUrl);
    } else if (valueOne !== '' && valueTwo === '') {
        $('.compare-artist-link').attr('href', baseUrl + '?artist_id_one=' + valueOne);
    } else {
        $('.compare-artist-link').attr('href', baseUrl + '?artist_id_two=' + valueTwo);
    }
});

$('.compare-venue-select').on('change', function (event) {
    var previous = $(this).data('previous');
    $('.compare-venue-select').not(this).find('option[value="' + previous + '"]').show();
    var value = $(this).val();
    $(this).data('previous', value);
    $('.compare-venue-select').not(this).find('option[value="' + value + '"]').hide();

    var valueOne = $('.compare-venue-select-one').val();
    var valueTwo = $('.compare-venue-select-two').val();
    var baseUrl = '/compare/venue';

    if (valueOne !== '' && valueTwo !== '') {
        $('.compare-venue-link').attr('href', baseUrl + '?venue_id_one=' + valueOne + '&venue_id_two=' + valueTwo);
    } else if (valueOne !== '' && valueTwo === '') {
        $('.compare-venue-link').attr('href', baseUrl + '?venue_id_one=' + valueOne);
    } else {
        $('.compare-venue-link').attr('href', baseUrl + '?venue_id_two=' + valueTwo);
    }
});