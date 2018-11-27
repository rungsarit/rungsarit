<?php
function push_msg($group_id)
{  
    //$access_token = 'ZP+VUHsKMsZL45YWEXAeX7xIuij8//+W38Hqee/U2nyYzCF+v1fbJx78yNrsKAVFJJ7BcZfl1+0fkL66TzZV0FtBf/PpBbuqGmilCwK5+NE1TjEeHwV90c7SsIV6TfMlNlaGIcIzhIVkeRnBUrwygwdB04t89/1O/w1cDnyilFU=';
	$access_token = 'rTiapLTEa/S30KaerJzstyD1vxZIbyrNWPetjdw1vAjG9gQdZX8DjgzK+ZE3YUtFZcwnQTvNTt+tdmQ+Ek6/YGqjxRGz08p5giyGSZK31nPtkLVD75WgYB/vsgb+/cZZit2RjAI4iR3at9MqZj6HJAdB04t89/1O/w1cDnyilFU=';
    $messages = [ 'type' => 'text', 
    'text' => 'ทดสอบ PUSH จ้า'
    ];
    $url = 'https://api.line.me/v2/bot/message/push';
    $data = ['to' => $group_id,'messages' => [$messages]];
    $post = json_encode($data);
    $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);  
}
/*require('./db/connect-db.php');
$sql = "SELECT * FROM tbl_office";
$query = mysqli_query($conn,$sql);
while($obj = mysqli_fetch_array($query))
{
    echo $obj["office_name"]."<br>";

}*/
$group_id ="Ccd9652f5c7325dac8f78719ec74d6be0";
push_msg($group_id);

?>
