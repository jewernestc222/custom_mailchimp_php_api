<?php
   // let's start with some variables
$api_key = 'xxxxxxxx'; //contact me jewernestc@gmail.com or info@dotnetsolutionscebu.com
$email = 'jewernestc@gmail.com'; // the user we are going to subscribe
$status = 'subscribed'; // we are going to talk about it in just a little bit
$merge_fields = array( 'FNAME' => 'Jewernest', 'LNAME' => 'Casquejo', 'ADDRESS' => '','COMPANY' => 'Dotnetsolutions Cebu', 'MOBILE' => 'xxxxxxxxxxxx'); // FNAME, LNAME or something else
$list_id = 'xxxxx'; // //contact me jewernestc@gmail.com or info@dotnetsolutionscebu.com

// start our Mailchimp connection
$connection = curl_init();
curl_setopt( 
    $connection, 
    CURLOPT_URL, 
    'https://' . substr( $api_key, strpos( $api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5( strtolower( $email ) )
);
curl_setopt( $connection, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Basic '. base64_encode( 'user:'.$api_key ) ) );
curl_setopt( $connection, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $connection, CURLOPT_CUSTOMREQUEST, 'PUT' );
curl_setopt( $connection, CURLOPT_POST, true );
curl_setopt( $connection, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( 
    $connection, 
    CURLOPT_POSTFIELDS, 
    json_encode( array(
        'apikey'        => $api_key,
        'email_address' => $email,
        'status'        => $status,
        'merge_fields'  => $merge_fields,
        'tags' => array( '2025' ) // you can specify some tags here as well
    ) )
);
 
$result = curl_exec( $connection );
$result = json_decode( $result );

if( 400 === $result->status ){
    foreach( $result->errors as $error ) {
        echo '<p>Error: ' . $error->message . '</p>';
    }
} elseif( 'subscribed' === $result->status ){
    echo "<p>Thank you, {$result->full_name}!</p>";
}

?>