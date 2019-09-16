$(function () {
    $('.js-like-article').on('click', function (event) {
        event.preventDefault();

        const link = $(event.currentTarget);
        link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        $.ajax({method: 'POST', url: link.attr('href')})
            .done(function (response) {
                $('.js-like-article-count').html(response.hearts);
            });
    });
});