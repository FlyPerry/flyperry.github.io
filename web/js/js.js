$(function () {
    $('.count_plus').on('click', function () {
        var $input = $('[name=quantity]');
        var currentValue = parseInt($input.val(), 10);
        var step = parseInt($input.attr('step'), 10);
        var max = parseInt($input.attr('max'), 10);

        var newValue = currentValue + step;

        if (newValue <= max) {
            $input.val(newValue);
        } else {
            $input.val(max);
        }

        console.log($input.val());
    });

    $('.count_minus').on('click', function () {
        var $input = $('[name=quantity]');
        var currentValue = parseInt($input.val(), 10);
        var step = parseInt($input.attr('step'), 10);
        var min = parseInt($input.attr('min'), 10);

        var newValue = currentValue - step;

        if (newValue >= min) {
            $input.val(newValue);
        } else {
            $input.val(min);
        }

        console.log($input.val());
    });
})