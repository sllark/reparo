window.addEventListener('load', () => {
    'use strict';


    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/account/apikeys
    var stripe = Stripe('pk_test_51IDBfKC2dKcPzSl9Rem3ESZ39QZLel2ws3ChW5queTKeFxL0ObXXlGfwP4EdzscoGW58WaK6kfvVfhJvPyJV7lJE0076A9WBbC');
    var elements = stripe.elements();

    configInputs('#payment-form');
    configCountryArrow();

    var elementStyles = {
        base: {
            color: '#767e88',
            fontWeight: 500,
            fontFamily: 'Source Code Pro, Consolas, Menlo, monospace',
            fontSize: '16px',
            fontSmoothing: 'antialiased',

            '::placeholder': {
                color: '#ced4da',
            },
            ':-webkit-autofill': {
                color: '#e39f48',
            },
        },
        invalid: {
            color: '#E25950',

            '::placeholder': {
                color: '#FFCCA5',
            },
        },
    };

    var elementClasses = {
        focus: 'focused',
        empty: 'empty',
        invalid: 'invalid',
    };

    var cardNumber = elements.create('cardNumber', {
        style: elementStyles,
        classes: elementClasses,
    });

    var cardExpiry = elements.create('cardExpiry', {
        style: elementStyles,
        classes: elementClasses,
    });

    var cardCvc = elements.create('cardCvc', {
        style: elementStyles,
        classes: elementClasses,
    });

    cardNumber.mount('#card-number');
    cardExpiry.mount('#card-expiry');
    cardCvc.mount('#card-cvc');


    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        if (!validateForm('#payment-form .input')) {
            return
        }

        form.classList.add('hide');
        document.querySelector('.sectionCheckout__spinner').classList.remove('hide');


        stripe.createToken(cardNumber).then(function (result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // console.log(result);
                stripeTokenHandler(result.token);
            }
        });
    });



    let deviceSelect=document.querySelector('#devicesSelect');

    if (deviceSelect)
        deviceSelect.addEventListener('change',handleDevices);

})


function validateForm(selector) {

    let elements = document.querySelectorAll(selector);
    let isValid = true;

    elements.forEach(element => {

        if (element.classList.contains('invalid') || element.classList.contains('empty')) {
            isValid = false;
            element.classList.add('invalid')
        }
    })

    return isValid;


}


function configInputs(elementID) {

    const emailRegex = RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

    var inputs = document.querySelectorAll(elementID + ' .input');
    Array.prototype.forEach.call(inputs, function (input) {
        input.addEventListener('focus', function () {
            input.classList.add('focused');
        });
        input.addEventListener('blur', function () {
            input.classList.remove('focused');
            if (input.value.length === 0) {
                input.classList.add('empty');
                input.classList.remove('valid');
                // input.classList.add('invalid');

            } else {
                input.classList.remove('empty');
                input.classList.add('valid');
                input.classList.remove('invalid');


                if (input.type === 'email') {
                    emailRegex.test(input.value) ? validMail(input) : invalidMail(input);
                }

            }
        });
        input.addEventListener('keyup', function () {
            if (input.value.length === 0) {
                input.classList.add('empty');
                input.classList.remove('valid');
                // input.classList.add('invalid');

            } else {
                input.classList.remove('empty');
                input.classList.add('valid');
                input.classList.remove('invalid');


                if (input.type === 'email') {
                    emailRegex.test(input.value) ? validMail(input) : invalidMail(input);
                }

            }
        });
    });


}


function validMail(input) {
    input.classList.remove('empty');
    input.classList.remove('invalid')
    input.classList.add('valid');
}

function invalidMail(input) {
    input.classList.remove('empty');
    input.classList.remove('valid');
    input.classList.add('invalid');
}

function configCountryArrow(){

    let countryRow = document.querySelector('.countryRow'),
        countryInput = document.querySelector('.country.input'),
        clickedlebel = false;

    countryRow.addEventListener('click', (e) => {

        if (clickedlebel===true) {
            clickedlebel = false;
            return;
        }

        if (e.target === countryRow.children[0]) {
            clickedlebel = true;
            return;
        }
        countryRow.classList.toggle('clicked');
    })

    countryInput.addEventListener('blur', (e) => {
        countryRow.classList.remove('clicked');
    })

}


function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}


function handleDevices(e){


    let deviceSelect=document.querySelector('#devicesSelect');
    let deviceNumInput=document.querySelector('#deviceNumInput');
    let deviceNum=document.querySelector('.deviceNum');
    let priceOld=document.querySelector('.priceOld');
    let priceDiscounted=document.querySelector('.priceDiscounted');
    let totalPrice=document.querySelector('.totalPrice');
    let selectVal=deviceSelect.value;

    if (Number(selectVal) === 1){
        deviceNum.innerHTML=selectVal+' Appareil';
        priceOld.innerHTML="&euro; 39.99";
        priceDiscounted.innerHTML="&euro; 19.99";
        totalPrice.innerHTML="&euro; 19.99";
    }else if (Number(selectVal) === 2){

        deviceNum.innerHTML=selectVal+' Appareils';
        priceOld.innerHTML="&euro; 59.99";
        priceDiscounted.innerHTML="&euro; 29.99";
        totalPrice.innerHTML="&euro; 29.99";

    }else if (Number(selectVal) === 3){

        deviceNum.innerHTML=selectVal+' Appareils';
        priceOld.innerHTML="&euro; 79.99";
        priceDiscounted.innerHTML="&euro; 39.99";
        totalPrice.innerHTML="&euro; 39.99";

    }



    deviceNumInput.value=selectVal;

}

