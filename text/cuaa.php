<?php
$userpass = 'UgoFoundation:Thanks1989';
$userpass = base64_encode($userpass);
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "http://kexyx.api.infobip.com/sms/2/text/advanced",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "{\r\n\t\"bulkId\":\"BULK-ID-123-xyz\",
    \r\n\t\"messages\":[
    \r\n\t\t{\r\n\t\t\t\"from\":\"InfoSMS\",
    \r\n\t\t\t\"destinations\":[
        \r\n\t\t\t\t
        {
        \r\n\t\t\t\t\t\"to\":\"2347034667861\", \r\n\t
        \t\t\t\t\"messageId\":\"MESSAGE-ID-123-xyz\"\r\n\t
        \t\t\t
        },
        \r\n\t\t\t\t
        {
        \r\n\t\t\t\t\t\"to\":\"2348060025948\"\r\n\t
        \t\t\t
        }\r\n\t\t\t
        ],\r\n\t\t\t\"text\":\"This is a goood sign of work in great progress.\",\r\n\t\t\t\"flash\":false,\r\n\t\t\t\"language\":{\r\n\t\t\t\t\"languageCode\":\"TR\"\r\n\t\t\t},\r\n\t\t\t\"transliteration\":\"TURKISH\",\r\n\t\t\t\"intermediateReport\":true,\r\n\t\t\t\"notifyUrl\":\"https://www.example.com/sms/advanced\",\r\n\t\t\t\"notifyContentType\":\"application/json\",\r\n\t\t\t\"callbackData\":\"DLR callback data\",\r\n\t\t\t\"validityPeriod\": 720\r\n\t\t},\r\n\t\t{\r\n\t\t\t\"from\":\"41793026700\",\r\n\t\t\t\"destinations\":[\r\n\t\t\t\t{\r\n\t\t\t\t\t\"to\":\"41793026785\"\r\n\t\t\t\t}\r\n\t\t\t],\r\n\t\t\t\"text\":\"A long time ago, in a galaxy far, far away... It is a period of civil war. Rebel spaceships, striking from a hidden base, have won their first victory against the evil Galactic Empire.\",\r\n\t\t\t\"sendAt\":\"2015-07-07T17:00:00.000+01:00\",\r\n\t\t\t\"deliveryTimeWindow\": {\r\n\t\t\t\t\"from\": {\r\n\t\t\t\t\t\"hour\": 6,\r\n\t\t\t\t\t\"minute\": 0\r\n\t\t\t\t},\r\n\t\t\t\t\"to\": {\r\n\t\t\t\t\t\"hour\": 15,\r\n\t\t\t\t\t\"minute\": 30\r\n\t\t\t\t},\r\n\t\t\t\t\"days\": [\r\n\t\t\t\t\t\"MONDAY\", \"TUESDAY\", \"WEDNESDAY\", \"THURSDAY\", \"FRIDAY\", \"SATURDAY\", \"SUNDAY\"\r\n\t\t\t\t]\r\n\t\t\t}\r\n\t\t}\r\n\t],\r\n\t\"tracking\":{\r\n\t\t\"track\":\"SMS\",\r\n\t\t\"type\":\"MY_CAMPAIGN\"\r\n\t}\r\n}",
    CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "authorization: Basic ".$userpass,
        "content-type: application/json"
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

?>
