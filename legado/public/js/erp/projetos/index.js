$(function() {
    $('.btFile').unbind('click').die('click').click(function() {
        var link = $(this).attr('source');
        window.open('file:\\' + link, 'explorer');
        exit();
    });
});