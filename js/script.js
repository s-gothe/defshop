$(document).ready(function() {
    $('.addToCart').on('click', function() {
        alert('Article add to basket.');
    });

    $('.deleteFromCart').on('click', function() {
        alert('Article removed from basket.');
    });

    $('#colorFilter').on('change', function() {
        $(this).closest('form').submit();
    });
});