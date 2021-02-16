window.addEventListener('load', function () {


    // <-- Protection Lite Decleration start-->

    let devicesSelectLite = document.getElementById('devicesSelectLite'),
        yearSelectLite = document.getElementById('yearSelectLite');

    const
        liteMonthly1D1Y = 17,
        liteMonthly1D3Y = 14,
        liteMonthly3D1Y = 8,
        liteMonthly3D3Y = 5,

        liteYearly1D1Y = 199,
        liteYearly1D3Y = 499,
        liteYearly3D1Y = 299,
        liteYearly3D3Y = 599;


    let litePriceMont = document.getElementById('litePriceMont'),
        litePriceTotal = document.getElementById('litePriceTotal');


    devicesSelectLite.onchange = liteHandler;
    yearSelectLite.onchange = liteHandler;

// <-- Protection Lite Decleration ends-->


// <-- Protection Plus Decleration start-->

    let devicesSelectPlus = document.getElementById('devicesSelectPlus'),
        yearSelectPlus = document.getElementById('yearSelectPlus');

    const plusMonthly3D3Y = 6,
        plusMonthly1D3Y = 17,
        plusMonthly3D1Y = 11,
        plusMonthly1D1Y = 25,

        plusYearly3D3Y = 699,
        plusYearly1D3Y = 599,
        plusYearly3D1Y = 399,
        plusYearly1D1Y = 299;


    let plusPriceMont = document.getElementById('plusPriceMont'),
        plusPriceTotal = document.getElementById('plusPriceTotal');


    devicesSelectPlus.onchange = plusHandler;
    yearSelectPlus.onchange = plusHandler;

// <-- Protection Plus Decleration end-->


// <-- Protection Premium Decleration start-->
    let devicesSelectPrem = document.getElementById('devicesSelectPrem'),
        yearSelectPrem = document.getElementById('yearSelectPrem');


    const premMonthly3D3Y = 7,
        premMonthly1D3Y = 19,
        premMonthly3D1Y = 14,
        premMonthly1D1Y = 33,

        premYearly3D3Y = 799,
        premYearly1D3Y = 699,
        premYearly3D1Y = 499,
        premYearly1D1Y = 399;


    let premPriceMont = document.getElementById('premPriceMont'),
        premPriceTotal = document.getElementById('premPriceTotal');


    devicesSelectPrem.onchange = premHandler;
    yearSelectPrem.onchange = premHandler;

// <-- Protection Premium Decleration end-->


    function liteHandler() {

        let devices = Number(devicesSelectLite.value);
        let years = Number(yearSelectLite.value);

        if (devices === 1 && years === 1) {
            litePriceMont.innerHTML = liteMonthly1D1Y;
            litePriceTotal.innerHTML = liteYearly1D1Y;
        } else if (devices === 1 && years === 3) {
            litePriceMont.innerHTML = liteMonthly1D3Y;
            litePriceTotal.innerHTML = liteYearly1D3Y;
        } else if (devices === 3 && years === 1) {
            litePriceMont.innerHTML = liteMonthly3D1Y;
            litePriceTotal.innerHTML = liteYearly3D1Y;
        } else if (devices === 3 && years === 3) {
            litePriceMont.innerHTML = liteMonthly3D3Y;
            litePriceTotal.innerHTML = liteYearly3D3Y;
        }

    }


    function plusHandler() {

        console.log('dsd')

        let devices = Number(devicesSelectPlus.value);
        let years = Number(yearSelectPlus.value);


        if (devices === 1 && years === 1) {
            plusPriceMont.innerHTML = plusMonthly1D1Y;
            plusPriceTotal.innerHTML = plusYearly1D1Y;
        } else if (devices === 1 && years === 3) {
            plusPriceMont.innerHTML = plusMonthly1D3Y;
            plusPriceTotal.innerHTML = plusYearly1D3Y;
        } else if (devices === 3 && years === 1) {
            plusPriceMont.innerHTML = plusMonthly3D1Y;
            plusPriceTotal.innerHTML = plusYearly3D1Y;
        } else if (devices === 3 && years === 3) {
            plusPriceMont.innerHTML = plusMonthly3D3Y;
            plusPriceTotal.innerHTML = plusYearly3D3Y;
        }

    }


    function premHandler() {

        let devices = Number(devicesSelectPrem.value);
        let years = Number(yearSelectPrem.value);

        if (devices === 1 && years === 1) {
            premPriceMont.innerHTML = premMonthly1D1Y;
            premPriceTotal.innerHTML = premYearly1D1Y;
        } else if (devices === 1 && years === 3) {
            premPriceMont.innerHTML = premMonthly1D3Y;
            premPriceTotal.innerHTML = premYearly1D3Y;
        } else if (devices === 3 && years === 1) {
            premPriceMont.innerHTML = premMonthly3D1Y;
            premPriceTotal.innerHTML = premYearly3D1Y;
        } else if (devices === 3 && years === 3) {
            premPriceMont.innerHTML = premMonthly3D3Y;
            premPriceTotal.innerHTML = premYearly3D3Y;
        }

    }


    litePriceMont.innerHTML = liteMonthly1D1Y;
    litePriceTotal.innerHTML = liteYearly1D1Y;

    plusPriceMont.innerHTML = plusMonthly1D1Y;
    plusPriceTotal.innerHTML = plusYearly1D1Y;

    premPriceMont.innerHTML = premMonthly1D1Y;
    premPriceTotal.innerHTML = premYearly1D1Y;


    devicesSelectLite.value=1;
    devicesSelectPrem.value=1;
    devicesSelectPlus.value=1;

    yearSelectLite.value=1;
    yearSelectPlus.value=1;
    yearSelectPrem.value=1;


})

