$(function () {
    $('.js-toc-h').hover(function () {
        $(this).find('.font-public-anchor').addClass('font-public-anchor-hover');
    }, function () {
        $(this).find('.font-public-anchor').removeClass('font-public-anchor-hover');
    })
});
