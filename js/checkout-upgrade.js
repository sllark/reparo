const
    liteMonthly1D1Y = 17,
    liteMonthly1D3Y = 14,
    liteMonthly3D1Y = 8,
    liteMonthly3D3Y = 5,

    liteYearly1D1Y = 199,
    liteYearly1D3Y = 499,
    liteYearly3D1Y = 299,
    liteYearly3D3Y = 599;


const plusMonthly3D3Y = 6,
    plusMonthly1D3Y = 17,
    plusMonthly3D1Y = 11,
    plusMonthly1D1Y = 25,

    plusYearly3D3Y = 699,
    plusYearly1D3Y = 599,
    plusYearly3D1Y = 399,
    plusYearly1D1Y = 299;


const premMonthly3D3Y = 7,
    premMonthly1D3Y = 19,
    premMonthly3D1Y = 14,
    premMonthly1D1Y = 33,

    premYearly3D3Y = 799,
    premYearly1D3Y = 699,
    premYearly3D1Y = 499,
    premYearly1D1Y = 399;


const urlParams = new URLSearchParams(window.location.search);


const years = Number(urlParams.get('years'));
const devices = Number(urlParams.get('devices'));
const plan = urlParams.get('plan');


let planName = document.getElementById('planName'),
    yearsNum = document.getElementById('yearsNum'),
    deviceNum = document.getElementById('deviceNum'),
    priceDiscounted = document.getElementById('priceDiscounted'),
    totalPrice = document.querySelector('.totalPrice');


document.getElementById('deviceNumInput').value=devices;
document.getElementById('yearsInput').value=years;
document.getElementById('planInput').value=plan;

if (plan === 'lite')
    liteHandler();
else if (plan === 'plus')
    plusHandler();
else if (plan === 'prem')
    premHandler();


function liteHandler() {

    planName.innerHTML = 'Protection Lite';

    if (years > 1)
        yearsNum.innerHTML = years + " ANNÉES";
    else
        yearsNum.innerHTML = years + ' AN';

    if (devices > 1)
        deviceNum.innerHTML = devices + " Appareils";
    else
        deviceNum.innerHTML = devices + ' Appareil';


    if (devices === 1 && years === 1) {
        priceDiscounted.innerHTML = liteMonthly1D1Y+"&euro; / mois";
        totalPrice.innerHTML = liteYearly1D1Y+"&euro;";
    } else if (devices === 1 && years === 3) {
        priceDiscounted.innerHTML = liteMonthly1D3Y+"&euro; / mois";
        totalPrice.innerHTML = liteYearly1D3Y+"&euro;";
    } else if (devices === 3 && years === 1) {
        priceDiscounted.innerHTML = liteMonthly3D1Y+"&euro; / mois";
        totalPrice.innerHTML = liteYearly3D1Y+"&euro;";
    } else if (devices === 3 && years === 3) {
        priceDiscounted.innerHTML = liteMonthly3D3Y+"&euro; / mois";
        totalPrice.innerHTML = liteYearly3D3Y+"&euro;";
    }

}


function plusHandler() {


    planName.innerHTML = 'Protection Plus\n';

    if (years > 1)
        yearsNum.innerHTML = years + " ANNÉES";
    else
        yearsNum.innerHTML = years + ' AN';

    if (devices > 1)
        deviceNum.innerHTML = devices + " Appareils";
    else
        deviceNum.innerHTML = devices + ' Appareil';


    if (devices === 1 && years === 1) {
        priceDiscounted.innerHTML = plusMonthly1D1Y+"&euro; / mois";
        totalPrice.innerHTML = plusYearly1D1Y+"&euro;";
    } else if (devices === 1 && years === 3) {
        priceDiscounted.innerHTML = plusMonthly1D3Y+"&euro; / mois";
        totalPrice.innerHTML = plusYearly1D3Y+"&euro;";
    } else if (devices === 3 && years === 1) {
        priceDiscounted.innerHTML = plusMonthly3D1Y+"&euro; / mois";
        totalPrice.innerHTML = plusYearly3D1Y+"&euro;";
    } else if (devices === 3 && years === 3) {
        priceDiscounted.innerHTML = plusMonthly3D3Y+"&euro; / mois";
        totalPrice.innerHTML = plusYearly3D3Y+"&euro;";
    }

}


function premHandler() {

    planName.innerHTML = 'Protection Premium';

    if (years > 1)
        yearsNum.innerHTML = years + " ANNÉES";
    else
        yearsNum.innerHTML = years + ' AN';

    if (devices > 1)
        deviceNum.innerHTML = devices + " Appareils";
    else
        deviceNum.innerHTML = devices + ' Appareil';


    if (devices === 1 && years === 1) {
        priceDiscounted.innerHTML = premMonthly1D1Y+"&euro; / mois";
        totalPrice.innerHTML = premYearly1D1Y+"&euro;";
    } else if (devices === 1 && years === 3) {
        priceDiscounted.innerHTML = premMonthly1D3Y+"&euro; / mois";
        totalPrice.innerHTML = premYearly1D3Y+"&euro;";
    } else if (devices === 3 && years === 1) {
        priceDiscounted.innerHTML = premMonthly3D1Y+"&euro; / mois";
        totalPrice.innerHTML = premYearly3D1Y+"&euro;";
    } else if (devices === 3 && years === 3) {
        priceDiscounted.innerHTML = premMonthly3D3Y+"&euro; / mois";
        totalPrice.innerHTML = premYearly3D3Y+"&euro;";
    }


}



