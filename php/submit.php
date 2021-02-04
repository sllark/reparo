<?php
require('config.php');
require('zoho/handleLeads.php');


try {
    // Use Stripe's library to make requests...

    $amountToCharge = 33;

    $email_address = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $country = $_POST['country'];


    // Get the payment token ID submitted by the form:
    $token = $_POST['stripeToken'];


    // Token is created using Stripe Checkout or Elements!
    $charge = \Stripe\Charge::create([
        'amount' => ($amountToCharge * 100),
        'currency' => 'usd',
        'description' => 'Example charge',
        'source' => $token,
    ]);

    echo "Charged User";
    echo '<br>';


    //Get Serial Key
    //--for now adding a fake serial key
    $serial_key = "dsjldk343nrieh3r94enjfnewuwj";

    echo "get serial key";
    echo '<br>';


    //integrate Zoho


    //Charged
    //Lead_ID_Stripe
    //Serial_Key
    //Last_Name
    //Email


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

    echo "Inserted User";
    echo '<br>';


    //Send mail
    $email = "contact@reparo.com";
    $subject = "Serial Key";
    $header = 'From: contact@reparo.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();


    $msg =
        "First Name: " . $firstName . "\r\n" .
        "Last Name: " . $lastName . "\r\n" .
        "Email: " . $email_address . "\r\n" .
        "Country: " . $country . "\r\n" .
        "Serial Key: " . $serial_key . "\r\n";

    echo "Mail sent";
    echo '<br>';

    //$sendMail = mail($email, $subject, $msg,$header);


    header("Location: /06-reparo/result.html?message=Please check your inbox, you will recive the Serial keys shortly.&isCharged=true");
    exit;


//        echo "Redirect to result page";
//        echo '<br>';


//        echo '<pre>';
//        print_r($charge->id);
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


<h1>hello Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur blanditiis deserunt enim explicabo
	maiores nulla quasi ratione sed voluptatem! Culpa cum esse et excepturi iste laborum modi obcaecati omnis
	perferendis!</h1>
