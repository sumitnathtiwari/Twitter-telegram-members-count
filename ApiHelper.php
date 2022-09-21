<?php
include_once("Constant.php");

function callTelegramApi($action)
{
    $telegramApiUrl = TELEGRAM_API_URL . 'bot' . TELEGRAM_BOT_TOKEN . '/' . $action;
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => $telegramApiUrl,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_VERBOSE => DEBUG_MODE,
    ));
    $output = curl_exec($curl);
    curl_close($curl);
    if(curl_errno($curl)){
        throw new Exception(curl_error($curl));
    }
    return json_decode($output, true);
}


function getTwitterApiOauthToken() {
        // preparing credentials
        $credentials = TWITTER_API_KEY . ':' . TWITTER_API_SECRET;
        $encoded = base64_encode($credentials);
        $headers = array( 
            "POST /oauth2/token HTTP/1.1", 
            "Host: api.twitter.com", 
            "User-Agent: my Twitter App v.1",
            "Authorization: Basic ".$encoded."",
            "Content-Type: application/x-www-form-urlencoded;charset=UTF-8"
        ); 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,TWITTER_OAUTH_URL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, TWITTER_GRANT_TYPE);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_VERBOSE, DEBUG_MODE);
        $result = curl_exec($curl);
        curl_close($curl);
        if(curl_errno($curl)){
            throw new Exception(curl_error($curl));
        }
        $output = json_decode($result,true);
        if(isset($output["access_token"]) && !empty($output["access_token"])) {
            return $output['access_token'];
        } else {
            error_log('ERROR:please examine the curl error and check if valid creds are there');
            return '';
        }
}

/*
@$methodEndPoint => this will be the methods
for example for user details
users/by
$params => this will be the arg parameters required for the method in array format
usernames=AlphaTauriF1&user.fields=public_metrics
*/
function callTwitterApiMethod($methodEndpoint,$params) {
    //please use cache system here according to your web engine
    //for storing access token
    $getBearerToken = getTwitterApiOauthToken();

    if(empty($getBearerToken)) {
        error_log('ERROR: No Bearer Token please examine the curl request');
    }
    $curl = curl_init();
    $url = TWITTER_API_V2 . $methodEndpoint . '?' . http_build_query($params);
    curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_VERBOSE => DEBUG_MODE,
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $getBearerToken
    )
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    if(curl_errno($curl)){
        throw new Exception(curl_error($curl));
    }
    return json_decode($response,true);
}
?>
