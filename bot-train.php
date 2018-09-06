<?php
require('./db/connect-db.php');//เรียกใช้ file connect-db
function reply_msg($text,$replyToken)//สร้างข้อความและตอบกลับ
{
    $access_token = 'REGnVB/OI7mwsa9/5EQOtchj3pUn47bh7sknrm1X+pUs+mbYG/33SqFGogTb/FU6ii3A/3r2ERT+DQGQZ6B/92ofjUMJiQYWx65sVDO5PqG1h9dM3M0hrYgcBy1ZjJ6nIaUjjoSH9smAIhRYY5FU+wdB04t89/1O/w1cDnyilFU=';
    $messages = ['type' => 'text','text' => $text];//สร้างตัวแปร 
    $url = 'https://api.line.me/v2/bot/message/reply';
    $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],
            ];
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
    echo $result . "\r\n";
}

// รับข้อมูล
$content = file_get_contents('php://input');//รับข้อมูลจากไลน์
$events = json_decode($content, true);//แปลง json เป็น php
if (!is_null($events['events'])) //check ค่าในตัวแปร $events
{
    foreach ($events['events'] as $event) 
    {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text')
        {
            $replyToken = $event['replyToken']; //เก็บ reply token เอาไว้ตอบกลับ
            $source_type = $event['source']['type'];//เก็บที่มาของ event(user หรือ group)
            $txtin = $event['message']['text'];//เอาข้อความจากไลน์ใส่ตัวแปร $txtin
            $first_char = substr($txtin,0,1);//ตัดเอาเฉพาะตัวอักษรตัวแรก
			if($first_char == "@")
			{
				$office_id = substr($txtin,1,3);///ได้รหัสการไฟฟ้า 
				$sql_area = "SELECT * FROM tbl_tdd WHERE area = '".$office_id."'";
				$query_area = mysqli_query($conn,$sql_area);
				$num_row = mysqli_num_rows($query_area);// นับจำนวนที่หาเจอ
				$txtsend = "ค้นพบ ".$num_row." รายการ";
				$a=1;
				while($obj = mysqli_fetch_array($query_area))
				{
					$txtsend = $txtsend ."\n\n".$a.".".$obj["oper"]."\n".$obj["wbs"]."\n".$obj["name"];
					$a = $a+1;
				}
				reply_msg($txtsend,$replyToken);//เรียกใช้ function
				break;
			}
         /*ลงทะเบียนกลุ่ม*/   
            if($first_char == "/" AND $source_type == "group" )//ถ้าตัวอักษรตัวแรกคือ /
            {
                $semicol_pos = strpos($txtin,":");//เก็บค่าตำแหน่งของ : ในข้อความที่เข้ามา
                if($semicol_pos == "")
                {
                    $txtsend = "รูปแบบคำสั่งไม่ถูกต้อง";
                    reply_msg($txtsend,$replyToken);//เรียกใช้ function
                    break;
                }
                $command = substr($txtin,1,$semicol_pos-1);//เก็บค่า คำสั่ง 
                if($command == "regist")//ถ้าคำสั่งคือ regist
                {
                    $group_name = substr($txtin,8,strlen($txtin));//เก็บชื่อกลุ่ม
                    $group_id = $event['source']['groupId'];//เก็บ group id
                    $sql_group = "SELECT * FROM tbl_group WHERE group_id ='$group_id'";
                    $group_query = mysqli_query($conn,$sql_group);
                    if(mysqli_num_rows($group_query) > 0)
                    {
                        $txtsend = "กลุ่มนี้ได้มีการลงทะเบียนไว้แล้ว";
                        reply_msg($txtsend,$replyToken);//เรียกใช้ function
                        break;
                    }
                    $sql_insert_group = "INSERT INTO tbl_group(group_name,group_id,status) VALUES('$group_name','$group_id','A')";
                    mysqli_query($conn, $sql_insert_group);
                    $txtsend = "ลงทะเบียนกลุ่มและเปิดใช้งานเรียบร้อยแล้วเรียบร้อยแล้ว";
                    reply_msg($txtsend,$replyToken);
                }
            }
        /*จบลงทะเบียนกลุ่ม*/       
        }
    }
}
echo "OKJAA";