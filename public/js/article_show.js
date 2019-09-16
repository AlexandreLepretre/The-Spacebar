$(function () {
    $('.js-like-article').on('click', function (event) {
        event.preventDefault();

        const link = $(event.currentTarget);
        link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        $('.js-like-article-count').html('TEST');
    });
});