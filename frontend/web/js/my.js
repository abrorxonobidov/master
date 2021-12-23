function calculateIncomeTotalPrice(el) {
    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    // console.log(i);
    let amount = $('#incomeproductlink-' + i + '-amount').val().replace(/[^0-9]/g, '');
    let price = $('#incomeproductlink-' + i + '-price').val().replace(/[^0-9]/g, '');
    if ($.isNumeric(amount) && $.isNumeric(price))
        $('#incomeproductlink-' + i + '-total_price').val(amount * price);
    else
        $('#incomeproductlink-' + i + '-total_price').val(0);

    let total = 0;
    $('.price-amount-multiply').map((i, el) => {
        let val = $(el).val().replace(/[^0-9]/g, '');
        if (val < 0) val = 0;
        total += parseFloat(val)
    });
    $('#income-total-sum').val(total);
}

function calculateSaleTotalPrice(el) {
    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    // console.log(i);
    let amount = $('#saleproductlink-' + i + '-amount').val().replace(/[^0-9]/g, '');
    let price = $('#saleproductlink-' + i + '-price').val().replace(/[^0-9]/g, '');
    if ($.isNumeric(amount) && $.isNumeric(price))
        $('#saleproductlink-' + i + '-total_price').val(amount * price);
    else
        $('#saleproductlink-' + i + '-total_price').val(0);

    let total = 0;
    $('.price-amount-multiply').map((i, el) => {
        let val = $(el).val().replace(/[^0-9]/g, '');
        if (val < 0) val = 0;
        total += parseFloat(val)
    });
    $('#sale-total-sum').val(total);
}

let toggleMenuBarClass = () => {
    if (localStorage.getItem("menuBarClass") === '1')
        $('body').removeClass('menubar-pin');
    else
        $('body').addClass('menubar-pin');

}

let toggleMenuBarStorage = () => {
    let a = localStorage;
    if (a.getItem("menuBarClass") === '1')
        a.setItem("menuBarClass", 0);
    else
        a.setItem("menuBarClass", 1);
    toggleMenuBarClass();
};

toggleMenuBarClass();

function changeIncomePrice(el) {

    let price = el.select2('data')[0].text.replace(/[^0-9]/g, '');

    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    let pricePoly = $('#incomeproductlink-' + i + '-price');
    //let pricePoly = el.parents('td').find('.income-price-poly');

    pricePoly.val(price).trigger('change');

}

function changeIncomePriceNext(el) {

    let price = null;
    let price_ar = el.select2('data')[0].text.match(/\(\d*?\//gmi);
    if (price_ar !== null)
        price = price_ar[0].replace(/[^0-9]/g, '');
    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    let pricePoly = $('#incomeproductlink-' + i + '-price');

    let unit = null;
    let unit_ar = el.select2('data')[0].text.match(/\/\S*?\)/gmi);
    if (unit_ar !== null)
        unit = unit_ar[0].replace(/[\/)]/g, '');
    $("#incomeproductlink-" + i + "-unit").text(unit);

    console.log(unit_ar, unit);

    pricePoly.val(price).trigger('change');

}

function changeSalePrice(el) {

    let price = el.select2('data')[0].text.replace(/[^0-9]/g, '');

    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    let pricePoly = $('#saleproductlink-' + i + '-price');
    //let pricePoly = el.parents('td').find('.income-price-poly');

    pricePoly.val(price).trigger('change');

}

function changeSalePriceNext(el) {

    let price = null;
    let price_ar = el.select2('data')[0].text.match(/\(\d*?\//gmi);
    if (price_ar !== null)
        price = price_ar[0].replace(/[^0-9]/g, '');
    let regexID = /^(.+?)([-\d-]{1,})(.+)$/i;
    let matches = el.attr('id').match(regexID);
    let i = matches[2].split('-')[1];
    let pricePoly = $('#saleproductlink-' + i + '-price');

    let unit = null;
    let unit_ar = el.select2('data')[0].text.match(/\/\S*?\)/gmi);
    if (unit_ar !== null)
        unit = unit_ar[0].replace(/[\/)]/g, '');
    $("#saleproductlink-" + i + "-unit").text(unit);

    console.log(unit_ar, unit);

    pricePoly.val(price).trigger('change');

}

let doNothing = () => {
    calculateIncomeTotalPrice(el)
    calculateSaleTotalPrice(el)
    changeIncomePrice(el)
    changeIncomePriceNext(el)
    changeSalePrice(el)
    changeSalePriceNext(el)
}