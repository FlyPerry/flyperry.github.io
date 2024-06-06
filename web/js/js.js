$(function () {

    function updateItemTotal($input) {
        var count = parseInt($input.val(), 10);
        var price = parseFloat($input.closest('.item_in_basket').find('.price .amount').text());
        var itemTotal = count * price;
        $input.closest('.item_in_basket').find('.total .amountSum').text(itemTotal.toFixed(2) + ' тг.');
    }

    function updateBasketTotal() {
        var basketTotal = 0;
        $('.item_in_basket').each(function () {
            var itemTotal = parseFloat($(this).find('.total .amountSum').text());
            if (!isNaN(itemTotal)) {
                basketTotal += itemTotal;
            }
        });
        $('#basket_total .amountCost').text(basketTotal.toFixed(2) + ' тг.');
        $('.pop_up_price').text(basketTotal.toFixed()+' тг.')
    }



    $('.count_plus').on('click', function () {
        var $input = $(this).siblings('input[name=quantity]');
        var currentValue = parseInt($input.val(), 10);
        var step = parseInt($input.attr('step'), 10);
        var max = parseInt($input.attr('max'), 10);

        var newValue = currentValue + step;

        if (newValue <= max) {
            $input.val(newValue);
            updateItemTotal($input);
            updateBasketTotal();

            var itemId = $input.closest('.item_in_basket').find('.v_code').text().replace('Код товара: ', '');
            updateBasketCookie(itemId, newValue); // basket_view
        } else {
            $input.val(max);
        }

        console.log($input.val());
    });

    $('.count_minus').on('click', function () {
        var $input = $(this).siblings('input[name=quantity]');
        var currentValue = parseInt($input.val(), 10);
        var step = parseInt($input.attr('step'), 10);
        var min = parseInt($input.attr('min'), 10);

        var newValue = currentValue - step;

        if (newValue >= min) {
            $input.val(newValue);
            updateItemTotal($input);
            updateBasketTotal();

            var itemId = $input.closest('.item_in_basket').find('.v_code').text().replace('Код товара: ', '');
            updateBasketCookie(itemId, newValue);
        } else {
            $input.val(min);
        }

    });

    $('.basket_list').on('change','input.number_input',function (){
        updateItemTotal($input);
        updateBasketTotal();
    })

    // Initial calculation of totals on page load
    $('input[name=quantity]').each(function () {
        updateItemTotal($(this));
    });
    updateBasketTotal();
});
