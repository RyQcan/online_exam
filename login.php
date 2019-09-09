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
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <title>管理登录</title>
</head>
<style>
    #main {position: absolute;width:400px;height:200px;left:50%;top:50%; 
margin-left:-200px;margin-top:-100px;border:1px solid #00F} 

</style>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">

            </div>
            <div class="col">
                <form name="login" action="login.php" method="get" autocomplete='off'>
                    <div class="form-group">
                        <input type="text" class="form-control" id="exampleInputEmail1" name="username" placeholder="用户名">

                        <input type="password" name="passwd" class="form-control" id="exampleInputEmail1" placeholder="密码">
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
    <br />
    <?php
    include 'settings.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
//登录
    if (@$_GET['action'] == "login" && @$_GET['username']) {

        $sql = "SELECT username,passwd FROM users WHERE username='" . $_GET['username'] . "'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["passwd"] == md5($_GET['passwd'])){
                //创建用户的cookies
                    setcookie("user", md5($row['username'].'#$%^adf'), time() + 3600);
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
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>