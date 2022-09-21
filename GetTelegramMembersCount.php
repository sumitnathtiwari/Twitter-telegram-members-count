<?php
include_once("ApiHelper.php");

function getTelegramMembersCount($chatId) {
    if (!extension_loaded('curl')) {
        error_log('PHP extension CURL is not loaded.');
        return ;
    }
    if(isset($chatId) && empty($chatId)) {
        error_log("ERROR: Empty Channel/group Id");
        return '';
    }
    if(!str_starts_with($chatId,'@')) {
        $chatId = '@' . $chatId;
    }
    try {
        //you can write a new function and just update this method to some other method
        //and you can call the generic TelegramApi 
        $method = 'getChatMembersCount?chat_id=' . $chatId;
        $result = callTelegramApi($method);
        if(empty($result)) {
            error_log("ERROR: Empty Response recevied from telegram API");
            return true;
        }
        if(isset($result["ok"]) && $result["ok"] == true) {
            return $result["result"];
        }
    } catch (Throwable $th) {
        error_log("ERROR: Faced Unexpected error with Telegram API please enable debug mode" . $th);
    }
    return $result;

}

?>