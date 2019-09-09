<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <title>学生管理</title>
</head>
<body>
<!-- 导航栏 -->
<?php include 'nav.php'; ?>

<?php
//包含配置文件
include 'settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//添加或查询学生记录
if (@$_GET['action'] == 'add' || @$_GET['action'] == 'search') {
    echo '
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
            <div class="row">
                <form method="GET" action="stu.php">
                <div class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" name="sno" placeholder="学号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sname" placeholder="姓名">
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssex" id="inlineRadio1" value="男">
                            <label class="form-check-label" for="inlineRadio1">男</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssex" id="inlineRadio2" value="女">
                            <label class="form-check-label" for="inlineRadio2">女</label>
                        </div>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sclass" placeholder="班号">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="sdept" placeholder="院系">
                    </div>';
    if (@$_GET['action'] == 'add') {
        echo '      
                    <input type="hidden" name="action" value="add">
                    <input type="submit" value="加入" class="btn btn-primary">
                </div>
                </form>
            </div>
            </li>
        </ul>
    </div>';
        if ($_COOKIE["user"] == md5('admin#$%^adf')) {
            if (@$_GET['sno']) {
                $sql = "INSERT INTO student VALUES(?,?,?,?,?,'合格')";
                $stmt = $conn->stmt_init();

                if ($stmt->prepare($sql)) {
                    $stmt->bind_param("sssss", $_GET['sno'], $_GET['sname'], $_GET['ssex'], $_GET['sclass'], $_GET['sdept']);
                    if ($stmt->execute()) {
                        echo '</br><div class="alert alert-success" role="alert">
                    添加成功!
                    </div>';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
                    }
                    $stmt->close();
                }

            }

        } else {
            echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
        }

        //查询学生
    } else if (@$_GET['action'] == 'search') {
        echo '
                    <input type="hidden" name="action" value="search">
                    <div class="col">
                        <input type="text" class="form-control" name="sstatus" placeholder="状态">
                    </div>
                        
                    <div class="col">
                        <input type="submit" value="查询" class="btn btn-primary">
                    </div>
                </div>
                </form>
            </div>
            </li>';
        $sql = "SELECT * FROM student WHERE 1=1 ";
        if (@$_GET['sno']) {
            $sql = $sql . "AND sno='" . $_GET['sno'] . "'";
        }
        if (@$_GET['sname']) {
            $sql = $sql . "AND sname like'" . $_GET['sname'] . "%'";
        }
        if (@$_GET['ssex']) {
            $sql = $sql . "AND ssex='" . $_GET['ssex'] . "'";
        }
        if (@$_GET['sclass']) {
            $sql = $sql . "AND sclass='" . $_GET['sclass'] . "'";
        }
        if (@$_GET['sdept']) {
            $sql = $sql . "AND sdept='" . $_GET['sdept'] . "'";
        }
        if (@$_GET['sstatus']) {
            $sql = $sql . "AND sstatus='" . $_GET['sstatus'] . "'";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '
            <li class="list-group-item">
            <div class="row">
                <div class="col">' . $row["sno"] . '</div>
                <div class="col">' . $row["sname"] . '</div>
                <div class="col">' . $row["ssex"] . '</div>
                <div class="col">' . $row["sclass"] . '</div>
                <div class="col">' . $row["sdept"] . '</div>
                <div class="col">' . $row["sstatus"] . '</div>
                
                <form method="GET" action="stu.php">
                <input type="hidden" name="action" value="alter">
                <input type="hidden" name="sno" value=' . $row["sno"] . '>
                <input type="submit" value="修改" class="btn btn-primary">
                </form>
                
                <form method="GET" action="stu.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="sno" value=' . $row["sno"] . '>
                <input type="submit" value="删除" class="btn btn-primary">
                </form>

            </div>
            </li>';
            }
            echo '
        </ul>
    </div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">没有哦~</div>';
        }
    }
//删除学生
} else if (@$_GET['action'] == 'delete') {
    if ($_COOKIE["user"] == md5('admin#$%^adf')) {
        if (@$_GET['sno']) {
            $sql = "delete from sc where sno='" . $_GET['sno'] . "'";
            $sql2 = "delete from student where sno='" . $_GET['sno'] . "'";
            if ($conn->query($sql) && $conn->query($sql2)) {
                echo '</br><div class="alert alert-success" role="alert">
                    已删除
                    </div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
    }
} else if (@$_GET['action'] == 'alter'){

} else {
    header("refresh:1;url=index.php");
    exit();
}
?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</body>
</html>