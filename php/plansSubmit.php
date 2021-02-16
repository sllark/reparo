<?php
require('config.php');
require('zoho/handleLeads.php');
require('db_connection.php');

try {

    if (!isset($_POST['stripeToken']) || !isset($_POST['email']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['country']) || !isset($_POST['deviceNum']) || !isset($_POST['yearsNum']) || !isset($_POST['plan'])) {


        header("Location: /06-reparo/result.html?message=Please Submit the form properly.&isCharged=false");
        exit;
    }

    // Use Stripe's library to make requests...
    $token = $_POST['stripeToken'];
    $email_address = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $country = $_POST['country'];
    $deviceNum = $_POST['deviceNum'];
    $yearsNum = $_POST['yearsNum'];
    $plan = $_POST['plan'];

    $deviceNum += 0;
    $yearsNum += 0;

    if ($deviceNum !== 1 && $deviceNum !== 3) {
        header("Location: /06-reparo/result.html?message=Please Submit the form properly.&isCharged=false");
        exit;
    }


    $liteMonthly1D1Y = 17;
    $liteMonthly1D3Y = 14;
    $liteMonthly3D1Y = 8;
    $liteMonthly3D3Y = 5;

    $liteYearly1D1Y = 199;
    $liteYearly1D3Y = 499;
    $liteYearly3D1Y = 299;
    $liteYearly3D3Y = 599;


    $plusMonthly3D3Y = 6;
    $plusMonthly1D3Y = 17;
    $plusMonthly3D1Y = 11;
    $plusMonthly1D1Y = 25;

    $plusYearly3D3Y = 699;
    $plusYearly1D3Y = 599;
    $plusYearly3D1Y = 399;
    $plusYearly1D1Y = 299;


    $premMonthly3D3Y = 7;
    $premMonthly1D3Y = 19;
    $premMonthly3D1Y = 14;
    $premMonthly1D1Y = 33;

    $premYearly3D3Y = 799;
    $premYearly1D3Y = 699;
    $premYearly3D1Y = 499;
    $premYearly1D1Y = 399;


    // Get the payment token ID submitted by the form:

    //Get Serial Key
    //--for now adding a fake serial key
    $serial_key = getSerialKey();

    if (empty($serial_key)) {
        header("Location: /06-reparo/result.html?message=No Serial Key found. Please try again latter, Thanks.&isCharged=false");
        exit;
    }


    if ($plan === 'lite') {

        $plan ='Lite';


        if ($deviceNum === 1 && $yearsNum === 1) {
            $amountToCharge = $liteYearly1D1Y;
        } else if ($deviceNum === 1 && $yearsNum === 3) {
            $amountToCharge = $liteYearly1D3Y;
        } else if ($deviceNum === 3 && $yearsNum === 1) {
            $amountToCharge = $liteYearly3D1Y;
        } else if ($deviceNum === 3 && $yearsNum === 3) {
            $amountToCharge = $liteYearly3D3Y;
        }


    } elseif ($plan === 'plus') {
        $plan ='Plus';
        if ($deviceNum === 1 && $yearsNum === 1) {
            $amountToCharge = $plusYearly1D1Y;
        } else if ($deviceNum === 1 && $yearsNum === 3) {
            $amountToCharge = $plusYearly1D3Y;
        } else if ($deviceNum === 3 && $yearsNum === 1) {
            $amountToCharge = $plusYearly3D1Y;
        } else if ($deviceNum === 3 && $yearsNum === 3) {
            $amountToCharge = $plusYearly3D3Y;
        }
    } elseif ($plan === 'prem') {
        $plan ='Premium';

        if ($deviceNum === 1 && $yearsNum === 1) {
            $amountToCharge = $premYearly1D1Y;
        } else if ($deviceNum === 1 && $yearsNum === 3) {
            $amountToCharge = $premYearly1D3Y;
        } else if ($deviceNum === 3 && $yearsNum === 1) {
            $amountToCharge = $premYearly3D1Y;
        } else if ($deviceNum === 3 && $yearsNum === 3) {
            $amountToCharge = $premYearly3D3Y;
        }
    }

    $description = $amountToCharge . " Euro for " . $plan . " Protection; For " . $yearsNum . " Years; For " . $deviceNum . " device; Email:" . $email_address . "; Serial Key:" . $serial_key;



    // Token is created using Stripe Checkout or Elements!
    $charge = \Stripe\Charge::create([
        'amount' => ($amountToCharge * 100),
        'currency' => 'eur',
        'description' => $description,
        'source' => $token,
    ]);


    //integrate Zoho

    $leadData = [
        "Charged" => (string)$amountToCharge,
        "Lead_ID_Stripe" => $charge->id,
        "First_Name" => $firstName,
        "Last_Name" => $lastName,
        "Email" => $email_address,
        "Country" => $country,
        "Serial_Key" => $serial_key
    ];

    insert_data($leadData);


    //Send mail
    $email = "contact@reparo.com";
    $subject = "Serial Key";
    $header = 'From: contact@reparo.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();


    $msg =
        "Email: " . $email_address . "\r\n" .
        "Prénom: " . $firstName . "\r\n" .
        "Nom: " . $lastName . "\r\n" .
        "Pays: " . $country . "\r\n" .
        "Numéro de Commande: " . $charge->id . "\r\n" .
        "Number of devices: " . $deviceNum . "\r\n" .
        "Number of Years: " . $yearsNum . "\r\n" .
        "Plan: " . $plan . "\r\n" .
        "Montant: " . $amountToCharge . " EURO" . "\r\n" .
        "License: " . $serial_key . "\r\n";


//    $sendMail = mail($email, $subject, $msg,$header);


    header("Location: /06-reparo/plans-thankyou.html?firstName=" . $firstName . "&lastName=" . $lastName . "&email=" . $email_address . "&country=" . $country . "&key=" . $serial_key . "&price=" . $amountToCharge . "&num=" . $deviceNum . "&orderNum=" . $charge->id . "&years=" . $yearsNum . "&plan=" . $plan . "&redirect=" . $charge->receipt_url);
    exit;


//        echo "Redirect to result page";
//        echo '<br>';
//
//
//        echo '<pre>';
//        print_r($charge->receipt_url);
//    echo '<br>';
//    echo '<br>';
//    echo '<br>';
//    echo '<br>';
//    echo '<br>';
//    echo '<br>';
//    echo '<br>';
//        print_r($charge);

//        echo '<br>';
//        print_r($charge->billing_details->address->postal_code);
//        echo '<br>';
//        print_r($charge);
//        print_r($_POST['stripeToken']);
//        print_r($_POST['email']);
//        print_r($_POST['name']);

} catch (\Stripe\Exception\CardException $e) {


    // Since it's a decline, \Stripe\Exception\CardException will be caught
//        echo 'Status is:' . $e->getHttpStatus() . '\n';
//        echo 'Type is:' . $e->getError()->type . '\n';
//        echo 'Code is:' . $e->getError()->code . '\n';
//        // param is '' in this case
//        echo 'Param is:' . $e->getError()->param . '\n';
//        echo 'Message is:' . $e->getError()->message . '\n';


    header("Location: /06-reparo/result.html?message=Sorry,the card is not valid&isCharged=false");
    exit;

} catch (\Stripe\Exception\RateLimitException $e) {
    // Too many requests made to the API too quickly
    header("Location: /06-reparo/result.html?message=Too many requests made to the API too quickly&isCharged=false");
    exit;


} catch (\Stripe\Exception\InvalidRequestException $e) {
    // Invalid parameters were supplied to Stripes API
    header("Location: /06-reparo/result.html?message=Invalid parameters were supplied&isCharged=false");
    exit;


} catch (\Stripe\Exception\AuthenticationException $e) {
    // Authentication with Stripes API failed
    // (maybe you changed API keys recently)
    header("Location: /06-reparo/result.html?message=Authentication with Stripes API failed&isCharged=false");
    exit;


} catch (\Stripe\Exception\ApiConnectionException $e) {
    // Network communication with Stripe failed
    header("Location: /06-reparo/result.html?message=Network communication with Stripe failed&isCharged=false");
    exit;


} catch (\Stripe\Exception\ApiErrorException $e) {
    // Display a very generic error to the user, and maybe send
    // yourself an email
    header("Location: /06-reparo/result.html?message=Sorry, The payment failed, please try again.&isCharged=false");
    exit;


} catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    header("Location: /06-reparo/result.html?message=Sorry,Something happened with the files.We will get back to you soon.&isCharged=false");
    exit;


}

?>