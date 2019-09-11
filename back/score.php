<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <title>订单</title>
</head>

<body>
<!--判断是否已安装,若已经安装则进行数据库连接-->
<?php include '../include/installed_judge.php'; ?>
<!-- 导航栏 -->
<?php include '../include/back_nav.php'; ?>

<?php
//添加或查询成绩
if (@$_GET['action'] == 'search') {
    echo '
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
                        <input type="text" class="form-control" name="sname" placeholder="姓名">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sclass" placeholder="班号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sdept" placeholder="院系">
                    </div>
                    <input type="hidden" name="action" value="search">
                    <input type="submit" value="查询" class="btn btn-primary">
                </div>
                </form>
            </div>
            </li>';
    $sql = "SELECT sno FROM student WHERE 1=1 ";
    if (@$_GET['sno']) {
        $sql = $sql . "AND sno='" . $_GET['sno'] . "'";
    }
    if (@$_GET['sname']) {
        $sql = $sql . "AND sno in (SELECT sno FROM student WHERE sname='" . $_GET['sname'] . "')";
    }
    if (@$_GET['sclass']) {
        $sql = $sql . "AND sno in (SELECT sno FROM student WHERE sclass='" . $_GET['sclass'] . "')";
    }
    if (@$_GET['sdept']) {
        $sql = $sql . "AND sno in (SELECT sno FROM student WHERE sdept='" . $_GET['sdept'] . "')";
    }


    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '
            <li class="list-group-item">
            <div class="row">
                <div class="col">学号</div>
                <div class="col">考试号</div>
                <div class="col">分数</div>
                <div class="col">考试时间</div>
            </div>
            </li>';
        while ($row = $result->fetch_assoc()) {
            $sno=$row["sno"];
            $md5_sno = md5($row["sno"] . '#$%^adf');
            $sql2 = "SELECT * FROM quiz_record WHERE md5_sno='" . $md5_sno . "'";

            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    echo '
            <li class="list-group-item">
            <div class="row">
                <div class="col">' . $sno . '</div>
                <div class="col">' . $row2["quiz_no"] . '</div>
                <div class="col">' . $row2["score"] . '</div>
                <div class="col">' . $row2["datetime"] . '</div>
            </div>
            </li>';
                }

            }


        }
        echo '
            </ul>';
    } else {
        echo '<div class="alert alert-danger" role="alert">没有哦</div>';
    }
}

?>
<?php include "../include/footer.php"; ?>