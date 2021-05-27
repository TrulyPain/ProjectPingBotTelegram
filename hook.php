<?php
/*

__________                   __               __    __________.__                 __________        __   
\______   \_______  ____    |__| ____   _____/  |_  \______   \__| ____    ____   \______   \ _____/  |_ 
 |     ___/\_  __ \/  _ \   |  |/ __ \_/ ___\   __\  |     ___/  |/    \  / ___\   |    |  _//  _ \   __\
 |    |     |  | \(  <_> )  |  \  ___/\  \___|  |    |    |   |  |   |  \/ /_/  >  |    |   (  <_> )  |  
 |____|     |__|   \____/\__|  |\___  >\___  >__|    |____|   |__|___|  /\___  /   |______  /\____/|__|  
                        \______|    \/     \/                         \//_____/           \/             

- Telegram edition - Coded by @TrulyPain at GitHub -

With the help of:
    @Kaninis(Telegram) - Beta Tester
    @CuteRP(Telegram) - Beta Tester

This full project is licensed under Apache License 2.0. And comes without any warranty.
Redistrubution shall be done with credits to me, the creator of this project.

Read the full license at: http://www.apache.org/licenses/LICENSE-2.0

*/////////////////////////////////////DEV VARIABLES////////////////////////////////////
$botname = "<ENTER_A_GOOD_NAME_FOR_YOUR_BOT>";
$developername = "<ENTER_YOUR_DEVELOPER_NAME>";
$apitoken = "<ENTER_YOUR_API_TOKEN_FROM_BOTFATHER>";
///////////////////////////////////////////////////////////////////////////////////////

$path = "https://api.telegram.org/bot$apitoken";

$update = json_decode(file_get_contents("php://input"), TRUE);
$chatId = $update["message"]["chat"]["id"];
$username = $update["message"]["chat"]["username"];
$firstname = $update["message"]["chat"]["first_name"];
$message = $update["message"]["text"];

//If important data is missing
if ($message == null) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Unexpected error occured. Maybe my stupid developer $developername have pushed to Production instead of Test.");
} else

//First time
if ($message == "/start") {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Hello $firstname! Welcome to the $botname. To ping someone simple write '/ping' followed by it's ID. To get your ID, simply write '/id' to me. Good luck pinging.");
} else

//Referred user
if (strpos($message, "/start ") === 0) {
    $location = substr($message, 7);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Hello $firstname! Welcome to $botname. To ping someone simple write '/ping' followed by it's ID. To get your ID, simply write '/id' to me. Good luck pinging.");
    if($location == $chatId) {
        file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=You can't refer yourself, lol.");
        return;
    }
    sleep(0.2);
    file_get_contents($path."/sendmessage?chat_id=".$location."&text=You have now referred user @$username. You can ping them using '/ping $chatId'.");
    sleep(0.1);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=We have notified the user that invited you. Btw, their ping id is $location");
} else

//Get ID
if (strpos($message, "/id") === 0) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Your ping id is: " . $chatId);
} else

//Make sure ping id is entered
if (strpos($message, "/ping") === 0 && strlen(substr($message, 6)) < 5) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Make sure have entered the right Ping ID.");
} else

//Send ping
if (strpos($message, "/ping") === 0 && substr($message, 6) != $chatId) {
    $location = substr($message, 6);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Sending your ping.");
    sleep(0.2);
    file_get_contents($path."/sendmessage?chat_id=".$location."&text=You got a ping from @$username. You can respond to it by pinging them back using '/ping $chatId'.");
    sleep(0.1);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=The ping is sent.");
} else

//Invite user
if (strpos($message, "/invite") === 0) {
    $me = json_decode(file_get_contents($path."/getMe"), TRUE);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Your invite link are: https://telegram.me/".$me["result"]["username"]."?start=$chatId");
} else

//Is sender same as receiver?
if (strpos($message, "/ping") === 0 && substr($message, 6) == $chatId) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Sorry, you can not ping yourself. But if you're lonely you can write with our dev $developername.");
} else

//Copyright
if (strpos($message, "/copyright") === 0) {
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Copyright info at the official GitHub project: https://github.com/trulypain/ProjectPingBotTelegram");
} else

//Catch other commands
{
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Oh, that command is new for me. Sorry.");
    sleep(1);
    file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Would you want to add that command? Then you can always use the source code on GitHub to make your own version of this bot. https://github.com/trulypain/ProjectPingBotTelegram");
}
