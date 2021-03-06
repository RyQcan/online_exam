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
<!--判断是否已安装,若已经安装则进行数据库连接-->
<?php include '../include/installed_judge.php';?>
<!-- 导航栏 -->
<?php include '../include/back_nav.php'; ?>

<?php
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
                $sql = "INSERT INTO student VALUES(?,?,?,?,?)";
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

            $sql = "delete from student where sno='" . $_GET['sno'] . "'";
            if ($conn->query($sql)) {
                header("refresh:0;url=stu.php?action=search");
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
    }
    //修改

} else if (@$_GET['action'] == 'alter') {
    $sql = "SELECT * FROM student WHERE sno='" . $_GET['sno'] . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            echo '
            
                <form method="GET" action="stu.php">
                <div class="form-row">
                    <div class="col">
                            <input type="text" class="form-control" name="sname" value=' . $row["sname"] . '>
                    </div>
                <div class="col">';
            if ($row["ssex"] == '男') {
                echo '<div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="ssex" id="inlineRadio1" value="男">
                            <label class="form-check-label" for="inlineRadio1">男</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssex" id="inlineRadio2" value="女">
                            <label class="form-check-label" for="inlineRadio2">女</label>
                        </div>';
            } else {
                echo '<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="ssex" id="inlineRadio1" value="男">
                            <label class="form-check-label" for="inlineRadio1">男</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" checked type="radio" name="ssex" id="inlineRadio2" value="女">
                            <label class="form-check-label" for="inlineRadio2">女</label>
                        </div>';
            }


            echo '</div>    
                  <div class="col">
                
                        <input type="text" class="form-control" name="sclass" value=' . $row["sclass"] . '>
                        </div>  
                    <div class="col">
                        <input type="text" class="form-control" name="sdept" value=' . $row["sdept"] . '>
                  </div>  
                
                
                <input type="hidden" name="action" value="alteraction">
                <input type="hidden" name="sno" value=' . $row["sno"] . '>
                <input type="submit" value="修改" class="btn btn-primary">
                </div>  
                </form>
                
           ';
        }
        echo '
        </ul>
    </div>';
    }

} else if (@$_GET['action'] == 'alteraction') {
    if ($_COOKIE["user"] == md5('admin#$%^adf')) {
        $sql = "UPDATE student SET sname='" . $_GET['sname'] . "', ssex='" . $_GET['ssex'] . "',sclass='" . $_GET['sclass'] . "',sdept='" . $_GET['sdept'] . "' WHERE sno='" . $_GET['sno'] . "'";
        if ($conn->query($sql)) {
            header("refresh:0;url=stu.php?action=search");
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
    }

} else {
    header("refresh:0;url=admin.php");
    exit();
}
?>
<?php include "../include/footer.php"; ?>
