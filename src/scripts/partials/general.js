jQuery(document).ready(function($) {

    // Default all RSVP forms to the ID
    var event_id = $('span.event-id').text();

    $('.rsvp-form').find('.event-id').find('select option').filter(function() {
        return $(this).text() == event_id;
    }).prop('selected', true);

    // Mobile Nav Menu
    $('.nav-toggle').on('click', function() {
        $('header nav').toggleClass('open');
        $(this).toggleClass('active');
    });

});
