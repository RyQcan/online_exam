<?php
//include './include/settings.php';
//$conn = new mysqli($servername, $username, $password, $dbname);
//// 检测连接
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//$sql = "INSERT INTO a VALUES(?,?)";
//$stmt = $conn->stmt_init();
//
//if ($stmt->prepare($sql)) {
//    $id='';
//    $aa='';
//    $stmt->bind_param("ii", $id,$aa);
//    if ($stmt->execute()) {
//        echo '</br><div class="alert alert-success" role="alert">
//                    添加成功!
//                    </div>';
//    } else {
//        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
//    }
//    $stmt->close();
//}

//php的时间是以秒算。js的时间以毫秒算
date_default_timezone_set("Asia/Hong_Kong");//地区
//配置每天的活动时间段

//$endtimestr = "13:50:00";
//$endtime = strtotime($endtimestr);
$endtime=strtotime("+6 Minutes");
//$sql="INSERT INTO "

$nowtime = time();

$lefttime = $endtime-$nowtime; //实际剩下的时间（秒）

//UNIX秒数
//$d=strtotime("+5 Minutes");

//echo date("Y-m-d h:i:s", $d) . "<br>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHP实时倒计时!</title>
<script language="JavaScript">
<!-- //
var runtimes = 0;
function GetRTime(){
var nMS = <?=$lefttime?>*1000-runtimes*1000;
var nH=Math.floor(nMS/(1000*60*60))%24;
var nM=Math.floor(nMS/(1000*60)) % 60;
var nS=Math.floor(nMS/1000) % 60;
document.getElementById("RemainH").innerHTML=nH;
document.getElementById("RemainM").innerHTML=nM;
document.getElementById("RemainS").innerHTML=nS;
if(nMS==(6*60-2)*1000){
    document.getElementById("msg").innerHTML="还有最后五分钟,请及时作答！";
}
    if(nMS==(6*60-5)*1000){
        document.getElementById("msg").innerHTML="";
    }
// {
// alert("还有最后五分钟,请及时作答！");
// }
runtimes++;
setTimeout("GetRTime()",1000);
}
window.onload=GetRTime;
// -->
</script>
</head>
<body>
<h1><strong id="RemainH">XX</strong>:<strong id="RemainM">XX</strong>:<strong id="RemainS">XX</strong></h1>
<div id="msg"></div>
</body>
</html>