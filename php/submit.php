<?php
require('config.php');
require('zoho/handleLeads.php');
require('db_connection.php');

try {

    if (!isset($_POST['stripeToken']) || !isset($_POST['email']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['country']) || !isset($_POST['deviceNum'])) {

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

    $deviceNum += 0;

    if ($deviceNum < 1 || $deviceNum > 3) {
        header("Location: /06-reparo/result.html?message=Please Submit the form properly.&isCharged=false");
        exit;
    }

    // Get the payment token ID submitted by the form:

    //Get Serial Key
    //--for now adding a fake serial key
    $serial_key = getSerialKey();

    if (empty($serial_key)) {
        header("Location: /06-reparo/result.html?message=No Serial Key found. Please try again latter, Thanks.&isCharged=false");
        exit;
    }


    if ($deviceNum === 1) {
        $amountToCharge = 19.99;
        $descriptio = $amountToCharge." Euro for ".$deviceNum." device; Email:" . $email_address . "; Serial Key:" . $serial_key;
    } elseif ($deviceNum === 2) {
        $amountToCharge = 29.99;
        $descriptio = $amountToCharge." Euro for ".$deviceNum." devices; Email:" . $email_address . " and Serial Key:" . $serial_key;
    } elseif ($deviceNum === 3) {
        $amountToCharge = 39.99;
        $descriptio = $amountToCharge." Euro for ".$deviceNum." devices; Email:" . $email_address . "; Serial Key:" . $serial_key;

    }


    // Token is created using Stripe Checkout or Elements!
    $charge = \Stripe\Charge::create([
        'amount' => ($amountToCharge * 100),
        'currency' => 'eur',
        'description' => $descriptio,
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
        "Montant: " . $amountToCharge. " EURO" . "\r\n" .
        "License: " . $serial_key . "\r\n";


//    $sendMail = mail($email, $subject, $msg,$header);


    header("Location: /06-reparo/thankyou.html?firstName=".$firstName."&lastName=".$lastName."&email=".$email_address."&country=".$country."&key=".$serial_key."&price=".$amountToCharge."&num=".$deviceNum."&orderNum=".$charge->id."&redirect=".$charge->receipt_url);
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