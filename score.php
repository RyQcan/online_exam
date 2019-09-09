<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <title>订单</title>
</head>

<body>
   <!-- 导航栏 -->
<?php include 'nav.php';?>

<?php
include 'settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//添加或查询成绩
if(@$_GET['action']=='add'||@$_GET['action']=='search'){
    echo'
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
            <div class="row">
                <form method="GET" action="score.php">
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" name="sno" placeholder="学号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="cno" placeholder="课号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="cname" placeholder="课名">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="year" placeholder="学年">
                    </div>';
    
    if(@$_GET['action']=='add'){
        //添加成绩
        echo'
                    <div class="col">
                        <input type="text" class="form-control" name="score" placeholder="成绩">
                    </div>
                    <input type="hidden" name="action" value="add">
                    <input type="submit" value="加入">
                </div>
                </form>
            </div>
            </li>
        </ul>
    </div>';
        if($_COOKIE["user"]==md5('admin#$%^adf')){
            if(@$_GET['sno']){
                $sql="INSERT INTO sc VALUES('".$_GET['sno']."','".$_GET['cno']."','".$_GET['cname']."','".$_GET['year']."','".$_GET['score']."')";
                if ($conn->query($sql)) {
                    //计算此人平均分
                    $sstatus='';
                    $avg=0;
                    $sql2="SELECT AVG(score) FROM sc WHERE sno='".$_GET['sno']."'";
                    $result = $conn->query($sql2);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $avg= $row["AVG(score)"];
                            if($avg>85){
                                $sstatus='优秀';
                            }else if($avg>60){
                                $sstatus='合格';
                            }else if($avg>50){
                                $sstatus='试读';
                            }else{
                                $sstatus='退学';
                            }
                        }
                    }
                    $sql3="UPDATE student SET sstatus= '".$sstatus."' WHERE sno='".$_GET['sno']."'";
                    if ($conn->query($sql3)) {
                        echo '</br><div class="alert alert-success" role="alert">
                    添加成功!
                    </div>';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error.'</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error.'</div>';
                }

            }
        }else{
            echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
        }
    } else if(@$_GET['action']=='search'){
        //查询成绩
        echo'
                    <div class="col">
                        <input type="text" class="form-control" name="sname" placeholder="姓名">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sclass" placeholder="班号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sdept" placeholder="院系">
                    </div>
                    <input type="hidden" name="action" value="search">
                    <input type="submit" value="查询">
                </div>
                </form>
            </div>
            </li>';
        $sql="SELECT * FROM sc WHERE 1=1 ";
        if(@$_GET['sno']){
            $sql=$sql."AND sno='".$_GET['sno']."'";
        }
        if(@$_GET['sname']){
            $sql=$sql."AND sno in (SELECT sno FROM student WHERE sname='".$_GET['sname']."')";
        }
        if(@$_GET['sclass']){
            $sql=$sql."AND sno in (SELECT sno FROM student WHERE sclass='".$_GET['sclass']."')";
        }
        if(@$_GET['sdept']){
            $sql=$sql."AND sno in (SELECT sno FROM student WHERE sdept='".$_GET['sdept']."')";
        }
        if(@$_GET['cno']){
            $sql=$sql."AND cno='".$_GET['cno']."'";
        }
        if(@$_GET['cname']){
            $sql=$sql."AND cname='".$_GET['cname']."'";
        }
        if(@$_GET['year']){
            $sql=$sql."AND year='".$_GET['year']."'";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo'
            <li class="list-group-item">
            <div class="row">
                <div class="col">学号</div>
                <div class="col">课号</div>
                <div class="col">课名</div>
                <div class="col">学年</div>
                <div class="col">分数</div>
            </div>
            </li>';   
            while ($row = $result->fetch_assoc()) {
                echo'
            <li class="list-group-item">
            <div class="row">
                <div class="col">'. $row["sno"] .'</div>
                <div class="col">'. $row["cno"] .'</div>
                <div class="col">'. $row["cname"].'</div>
                <div class="col">'. $row["year"].'</div>
                <div class="col">'. $row["score"].'</div>
            </div>
            </li>';    
            }
            echo'
            </ul>';
        }else{
            echo '<div class="alert alert-danger" role="alert">没有哦</div>';
        }
    }
}  
?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</body>
</html>