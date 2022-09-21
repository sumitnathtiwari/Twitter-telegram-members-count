<?php

include_once("ApiHelper.php");

define('TWITTER_USER_METHOD','users/by');


function getTwitterFollowers($username)
{
    if(isset($username) && !empty($username)) {
        try {
            $result = callTwitterApiMethod(
                TWITTER_USER_METHOD,
            array(
                'usernames' => $username, 
                'user.fields' => 'public_metrics'
            ));
            if(isset($result) && !empty($result)) {
                return $result["data"][0]["public_metrics"]["followers_count"];
            }
        } catch (Throwable $th) {
            error_log("ERROR: Faced Unexpected error with Twitter API please enable debug mode" . $th);
        }
    } else {
        error_log('ERROR: EMPTY USERNAME');
    }
}

?>