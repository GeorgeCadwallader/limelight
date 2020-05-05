var artistCriteria = [
    'energy',
    'vocals',
    'sound',
    'stage presence',
    'song aesthetic'
];

var venueCriteria = [
    'service',
    'location',
    'value',
    'cleanliness',
    'size'
];

var artistIndex = 0;
var venueIndex = 0;

setInterval(function(){
    $('.artistRating').fadeOut(function(){
        $(this).html(artistCriteria[artistIndex=(artistIndex+1)%artistCriteria.length]).fadeIn();
    });
    $('.venueRating').fadeOut(function(){
        $(this).html(venueCriteria[venueIndex=(venueIndex+1)%venueCriteria.length]).fadeIn();
    });
}, 3250);