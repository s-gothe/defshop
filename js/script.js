$(document).ready(function() {
    // notification add article to cart
    $('.addToCart').on('click', function() {
        alert('Article add to basket.');
    });

    // notification delete article from cart
    $('.deleteFromCart').on('click', function() {
        alert('Article removed from basket.');
    });

    /* submit filter form */
    $('#colorFilter').on('change', function() {
        $(this).closest('form').submit();
    });
});