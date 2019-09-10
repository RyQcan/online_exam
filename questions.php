<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <title>考题管理</title>
</head>
<body>
<!-- 导航栏 -->
<?php include 'back_nav.php'; ?>

<?php
//包含配置文件
include 'settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//添加或查询考题
if (@$_GET['action'] == 'add' || @$_GET['action'] == 'search') {
    echo '
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">
            <div class="row">
                <form method="GET" action="questions.php">
                <div class="form-row">';
    if (@$_GET['action'] == 'search') {
        echo '<div class="col">
                        <input type="text" class="form-control" name="quest_no" placeholder="题号">
                    </div>';
    }


    echo '<div class="col">
                        <input type="text" class="form-control" name="quest_type" placeholder="题型">
                    </div>
                   
                    
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="quest_diff" id="inlineRadio1" value="难">
                            <label class="form-check-label" for="inlineRadio1">难</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="quest_diff" id="inlineRadio2" value="中">
                            <label class="form-check-label" for="inlineRadio2">中</label>
                        </div>
                         <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="quest_diff" id="inlineRadio3" value="易">
                            <label class="form-check-label" for="inlineRadio3">易</label>
                        </div>
                    </div>
                          
                      <div class="col">
                        <input type="text" class="form-control" name="stem" placeholder="题干">
                    </div>             
                     <div class="col">
                        <input type="text" class="form-control" name="choice_a" placeholder="A选项">
                    </div> 
                    <div class="col">
                        <input type="text" class="form-control" name="choice_b" placeholder="B选项">
                    </div>
                     <div class="col">
                        <input type="text" class="form-control" name="choice_c" placeholder="C选项">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="choice_d" placeholder="D选项">
                    </div>
                    <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="right_choice" id="Radio1" value="A">
                            <label class="form-check-label" for="Radio1">A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="right_choice" id="Radio2" value="B">
                            <label class="form-check-label" for="Radio2">B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="right_choice" id="Radio3" value="C">
                            <label class="form-check-label" for="Radio3">C</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="right_choice" id="Radio4" value="D">
                            <label class="form-check-label" for="Radio4">D</label>
                        </div>
                    </div>
                    ';
    if (@$_GET['action'] == 'add') {
        echo '      
                    <input type="hidden" name="action" value="add">
                    <input type="submit" value="添加" class="btn btn-primary">
                </div>
                </form>
            </div>
            </li>
        </ul>
    </div>';
        if ($_COOKIE["user"] == md5('admin#$%^adf')) {
            if (@$_GET['quest_type']) {
                $sql = "INSERT INTO question VALUES(?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->stmt_init();

                if ($stmt->prepare($sql)) {
                    $id = '';
                    $flag = '';
                    $stmt->bind_param("issssssssi", $id, $_GET['quest_type'], $_GET['quest_diff'], $_GET['stem'], $_GET['choice_a'], $_GET['choice_b'], $_GET['choice_c'], $_GET['choice_d'], $_GET['right_choice'], $flag);
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

        //查询/修改/删除考题
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
        $sql = "SELECT * FROM question WHERE 1=1 ";
        if (@$_GET['quest_no']) {
            $sql = $sql . "AND quest_no='" . $_GET['quest_no'] . "'";
        }
        if (@$_GET['quest_type']) {
            $sql = $sql . "AND quest_type ='" . $_GET['quest_type'] . "'";
        }
        if (@$_GET['quest_diff']) {
            $sql = $sql . "AND quest_diff ='" . $_GET['quest_diff'] . "'";
        }
        if (@$_GET['stem']) {
            $sql = $sql . "AND stem like'" . $_GET['stem'] . "%'";
        }
        if (@$_GET['choice_a']) {
            $sql = $sql . "AND choice_a like'" . $_GET['choice_a'] . "%'";
        }
        if (@$_GET['choice_b']) {
            $sql = $sql . "AND choice_b like'" . $_GET['choice_b'] . "%'";
        }
        if (@$_GET['choice_c']) {
            $sql = $sql . "AND choice_c like'" . $_GET['choice_c'] . "%'";
        }
        if (@$_GET['choice_d']) {
            $sql = $sql . "AND choice_d like'" . $_GET['choice_d'] . "%'";
        }
        if (@$_GET['right_choice']) {
            $sql = $sql . "AND right_choice='" . $_GET['right_choice'] . "'";
        }

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '
            <li class="list-group-item">
            <div class="row">
                <div class="col">' . $row["quest_no"] . '</div>
                <div class="col">' . $row["quest_type"] . '</div>
                <div class="col">' . $row["quest_diff"] . '</div>
                <div class="col">' . $row["stem"] . '</div>
                <div class="col">' . $row["choice_a"] . '</div>
                <div class="col">' . $row["choice_b"] . '</div>
                <div class="col">' . $row["choice_c"] . '</div>
                <div class="col">' . $row["choice_d"] . '</div>
                <div class="col">' . $row["right_choice"] . '</div>
                
                <form method="GET" action="questions.php">
                <input type="hidden" name="action" value="alter">
                <input type="hidden" name="quest_no" value=' . $row["quest_no"] . '>
                <input type="submit" value="修改" class="btn btn-primary">
                </form>
                
                <form method="GET" action="questions.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="quest_no" value=' . $row["quest_no"] . '>
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
//删除考题
} else if (@$_GET['action'] == 'delete') {
    if ($_COOKIE["user"] == md5('admin#$%^adf')) {
        if (@$_GET['quest_no']) {

            $sql = "delete from question where quest_no='" . $_GET['quest_no'] . "'";
            if ($conn->query($sql)) {
                header("refresh:0;url=questions.php?action=search");
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
            }
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">你的权限不够!请联系管理员</div>';
    }
} else if (@$_GET['action'] == 'alter') {
    $sql = "SELECT * FROM question WHERE quest_no='" . $_GET['quest_no'] . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            echo '
            
                <form method="GET" action="questions.php">
                <div class="form-row">
                    <div class="col">
                            <input type="text" class="form-control" name="quest_type" value=' . $row["quest_type"] . '>
                    </div>
                <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["quest_diff"] == '难') {
                echo ' checked ';
            }
            echo 'type="radio" name="quest_diff" id="inlineRadio1" value="难">
                            <label class="form-check-label" for="inlineRadio1">难</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["quest_diff"] == '中') {
                echo ' checked ';
            }
            echo 'type="radio" name="quest_diff" id="inlineRadio2" value="中">
                            <label class="form-check-label" for="inlineRadio2">中</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["quest_diff"] == '易') {
                echo ' checked ';
            }
            echo 'type="radio" name="quest_diff" id="inlineRadio3" value="易">
                            <label class="form-check-label" for="inlineRadio3">易</label>
                        </div>
                  </div>    
                  <div class="col">
                
                        <input type="text" class="form-control" name="stem" value=' . $row["stem"] . '>
                        </div>  
                    <div class="col">
                        <input type="text" class="form-control" name="choice_a" value=' . $row["choice_a"] . '>
                  </div>  
                   <div class="col">
                        <input type="text" class="form-control" name="choice_b" value=' . $row["choice_b"] . '>
                  </div>  
                   <div class="col">
                        <input type="text" class="form-control" name="choice_c" value=' . $row["choice_c"] . '>
                  </div>  
                   <div class="col">
                        <input type="text" class="form-control" name="choice_d" value=' . $row["choice_d"] . '>
                  </div>  
                  <div class="col">
           <div class="col">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["right_choice"] == 'A') {
                echo ' checked ';
            }
            echo 'type="radio" name="right_choice" id="inlineRadio1" value="A">
                            <label class="form-check-label" for="inlineRadio1">A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["right_choice"] == 'B') {
                echo ' checked ';
            }
            echo 'type="radio" name="right_choice" id="inlineRadio2" value="B">
                            <label class="form-check-label" for="inlineRadio2">B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["right_choice"] == 'C') {
                echo ' checked ';
            }
            echo 'type="radio" name="right_choice" id="inlineRadio3" value="C">
                            <label class="form-check-label" for="inlineRadio3">C</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" ';
            if ($row["right_choice"] == 'D') {
                echo ' checked ';
            }
            echo 'type="radio" name="right_choice" id="inlineRadio4" value="D">
                            <label class="form-check-label" for="inlineRadio4">D</label>
                        </div>
                  </div>   
           

</div>
                <input type="hidden" name="action" value="alteraction">
                <input type="hidden" name="quest_no" value=' . $row["quest_no"] . '>
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
        $sql = "UPDATE question SET quest_type='" . $_GET['quest_type'] . "', quest_diff='" . $_GET['quest_diff'] . "',stem='" . $_GET['stem'] . "',choice_a='" . $_GET['choice_a'] ."',choice_b='" . $_GET['choice_b'] ."',choice_c='" . $_GET['choice_c'] ."',choice_d='" . $_GET['choice_d'] . "',right_choice='" . $_GET['right_choice'] ."' WHERE quest_no='" . $_GET['quest_no'] . "'";
        if ($conn->query($sql)) {
            header("refresh:0;url=questions.php?action=search");
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