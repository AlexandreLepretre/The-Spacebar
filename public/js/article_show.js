$(() => {
    $('.js-like-article').on('click', event => {
        event.preventDefault();

        const link = $(event.currentTarget);
        link.toggleClass('fa-heart-o').toggleClass('fa-heart');

        $.ajax({
            method: 'POST',
            url: link.attr('href')
        }).done(data => {
            $('.js-like-article-count').html(data.hearts);
        }).then(() => {
        })
    });
});
