<?php
//注销登录
if (@$_GET['action'] == "logout" && isset($_COOKIE["user"])) {
    // 设置cookies立即过期
    setcookie("user", "", time() - 3600);
    header("Location:index.php");
    exit();
}
?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous">
        <title>学生登录</title>
    </head>
    <style>
        #main {
            position: absolute;
            width: 400px;
            height: 200px;
            left: 50%;
            top: 50%;
            margin-left: -200px;
            margin-top: -100px;
            border: 1px solid #00F
        }

    </style>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">

            </div>
            <div class="col">
                <form name="login" action="student_login.php" method="get" autocomplete='off'>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" name="sno" placeholder="学号">

                        <input type="text" name="sname" class="form-control" id="exampleInputEmail1" placeholder="姓名">
                        <?php
                        if (@$_GET['action'] == "login") {
                            echo "<input type='hidden' name='action' value='login'></table>";
                            echo '<div class="btn-group" role="group" aria-label="Basic example">
        <button type="submit" class="btn btn-secondary">登录</button>  
       </div>';
                        }
                        ?>
                    </div>
                </form>
            </div>
            <div class="col">
            </div>
        </div>
    </div>
    <br/>
    <!--判断是否已安装,若已经安装则进行数据库连接-->
<?php include '../include/installed_judge.php';?>
<?php
//登录
if (@$_GET['action'] == "login" && @$_GET['sno']) {

    $sql = "SELECT sno,sname FROM student WHERE sno='" . $_GET['sno'] . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["sname"] == $_GET['sname']) {
                //创建用户的cookies
                setcookie("user", md5($row['sno'] . '#$%^adf'), time() + 3600);
                header("Location:index.php");
                exit();
            } else {
                exit('登录失败！点击此处 <a href="javascript:history.bac
                k(-1);">返回</a> 重试');
            }
        }
        $conn->close();
    } else {
        exit('登录失败！点击此处 <a href="javascript:history.back(-1);">返回</a> 重试');
    }
}
?>
<?php include "../include/footer.php"; ?>