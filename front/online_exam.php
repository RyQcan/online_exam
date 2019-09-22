<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
    <!-- 引入 echarts.js -->
    <script src="../static/echarts.js"></script>
    <title>主页</title>

</head>

<body>
<!--判断是否已安装,若已经安装则进行数据库连接-->
<?php include '../include/installed_judge.php'; ?>
<!-- 导航栏 -->
<?php include '../include/front_nav.php'; ?>

<?php
//判断用户登录状态
if (!isset($_COOKIE["user"])) {
    echo '<div class="alert alert-warning" role="alert">请先登录哦~正在跳转</div>';
    header("refresh:1;url=student_login.php?action=login");
    exit();
} else {
    //登陆状态下判断行为
    if (@$_GET['action'] == 'start') {
        //开始答题
        date_default_timezone_set("Asia/Hong_Kong");
        $sql = "SELECT * FROM quiz_record WHERE md5_sno='" . $_COOKIE["user"] . "' AND summit_flag=0";
        $result = $conn->query($sql);
        //如果有未答完的试卷

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                if ($row['dead_time'] < time()) {

                    //如果超过答题时间
                    echo "时间已过哦,真遗憾";
                    $sql2 = "UPDATE quiz_record SET summit_flag=1 WHERE md5_sno='" . $_COOKIE["user"] . "' AND summit_flag=0";
                    $conn->query($sql2);
                } else {
                    //未超时,继续作答
                    echo '<h1><strong id="RemainH">XX</strong>:<strong id="RemainM">XX</strong>:<strong id="RemainS">XX</strong></h1>
<div id="msg"></div>';
                    $quiz_no = $row['quiz_no'];
                    $lefttime = $row['dead_time'] - time();
                    $sql3 = "SELECT * FROM quiz WHERE quiz_no=" . $quiz_no;
                    $result = $conn->query($sql3);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $per_score = $row['per_score'];
                            $questions = $row['questions'];
                            $quests = explode("*", $questions);
                        }
                    }
                    $sql2 = "SELECT * FROM question WHERE 1=2";
                    for ($i = 0; $i < count($quests) - 1; $i++) {
                        $sql2 .= " OR quest_no=" . $quests[$i];
                    }

                    $result2 = $conn->query($sql2);
                    echo ' <form method="GET" action="online_exam.php" id="exam">
                <div class="form-row">';

                    if ($result2->num_rows > 0) {
                        while ($row = $result2->fetch_assoc()) {
                            echo '
        <div>
            <ul>
                <li class="list-group-item">
                <div class="row">
                    <div class="col">' . $row["quest_type"] . '</div>
                    <div class="col">' . $row["stem"] . '</div>
                    A.<div class="col">' . $row["choice_a"] . '</div>
                    B.<div class="col">' . $row["choice_b"] . '</div>
                    C.<div class="col">' . $row["choice_c"] . '</div>
                    D.<div class="col">' . $row["choice_d"] . '</div>
                    <div class="form-check form-check-inline">
                    
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_1' . ' value="A">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_1' . '>A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_2' . ' value="B">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_2' . '>B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_3' . ' value="C">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_3' . '>C</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_4' . ' value="D">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_4' . '>D</label>
                        </div>
                        <input  type="radio" style="display:none;" checked name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_5' . ' value="">
                </div>
   
                </li>
            </ul>
    </div>';

                        }
                        echo '   
   <input type="hidden" value=' . $quiz_no . ' name="quiz_no">
   <input type="hidden" value="judge" name="action">
   <input type="submit" value="交卷" class="btn btn-primary">
              </div>
                </form>';
                    }


                }
            }
        } else {


            //开始一份新的试卷
            $sql = "SELECT * FROM rule WHERE rule_no=1 ";
            //根据规则自动生成试卷
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $counts = $row["counts"];
                    $diff = $row["quiz_diff"];
                    if ($diff == '难') {
                        $hard_counts = 5 * $counts / 10;
                        $mid_counts = 3 * $counts / 10;
                        $easy_counts = 2 * $counts / 10;
                    } else if ($diff == '中') {
                        $hard_counts = 3 * $counts / 10;
                        $mid_counts = 2 * $counts / 10;
                        $easy_counts = 5 * $counts / 10;
                    } else if ($diff == '易') {
                        $hard_counts = 2 * $counts / 10;
                        $mid_counts = 3 * $counts / 10;
                        $easy_counts = 5 * $counts / 10;
                    }

                    $per_score = $row["per_score"];
                }
            }
            /***挑选试题
             * @param $conn 数据库连接
             * @param $result 题号查询结果
             * @param $quests   存放被选中的题号
             * @return string 所有被选中的题号
             */

            function selectquiz($conn, $result, $quests)
            {
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $quests .= $row["quest_no"] . '*';
                        //标记试题,使其不能被其他考生抽中
                        $sql = "UPDATE question SET choose_flag=1 WHERE quest_no=" . $row["quest_no"];
                        $conn->query($sql);

                    }
                }
                //返回所有被选中的题号
                return $quests;
            }


            /***展示试题
             * @param $conn 数据库连接
             * @param $quests 被选中的题号组成的字符串
             * @param $quiz_no 试卷编号
             */
            function showquiz($conn, $quests, $quiz_no)
            {
                echo ' <form method="GET" action="online_exam.php" id="exam">
                <div class="form-row">';
                $rally = explode("*", $quests);
                $sql2 = "SELECT * FROM question WHERE 1=2";
                for ($i = 0; $i < count($rally) - 1; $i++) {
                    $sql2 .= " OR quest_no=" . $rally[$i];
                }

                $result2 = $conn->query($sql2);


                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {

                        echo '
        <div>
            <ul>
                <li class="list-group-item"> 
                <div class="row">
                    <div class="col">' . $row["quest_type"] . '</div>
                    <div class="col">' . $row["stem"] . '</div>
                    A.<div class="col">' . $row["choice_a"] . '</div>
                    B.<div class="col">' . $row["choice_b"] . '</div>
                    C.<div class="col">' . $row["choice_c"] . '</div>
                    D.<div class="col">' . $row["choice_d"] . '</div>
                    <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_1' . ' value="A">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_1' . '>A</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_2' . ' value="B">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_2' . '>B</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_3' . ' value="C">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_3' . '>C</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_4' . ' value="D">
                            <label class="form-check-label" for=' . $row["quest_no"] . '_4' . '>D</label>
                        </div>
                        <input  type="radio" style="display:none;" checked name=' . $row["quest_no"] . ' id=' . $row["quest_no"] . '_5' . ' value="">
                </div>
   
                </li>
            </ul>
    </div>';
                    }
                }


                echo '   
   <input type="hidden" value=' . $quiz_no . ' name="quiz_no">
   <input type="hidden" value="judge" name="action">
   <input type="submit" value="交卷" class="btn btn-primary">
              </div>
                </form>';

            }

            //倒计时功能
            $endtime = strtotime("+5 Minutes 5 Seconds");
            $nowtime = time();
            $lefttime = $endtime - $nowtime; //实际剩下的时间（秒）

            echo '<h1><strong id="RemainH">XX</strong>:<strong id="RemainM">XX</strong>:<strong id="RemainS">XX</strong></h1>
<div id="msg"></div>';

            //挑选试题
            //记录试题编号的字符串
            $quests = '';
            $sql2 = "SELECT quest_no FROM question WHERE quest_diff='难' AND choose_flag=0 ORDER BY RAND() LIMIT " . $hard_counts;
            $result = $conn->query($sql2);
            $quests = selectquiz($conn, $result, $quests);
            $sql2 = "SELECT quest_no FROM question WHERE quest_diff='中' AND choose_flag=0 ORDER BY RAND() LIMIT " . $mid_counts;
            $result = $conn->query($sql2);
            $quests = selectquiz($conn, $result, $quests);
            $sql2 = "SELECT quest_no FROM question WHERE quest_diff='易' AND choose_flag=0 ORDER BY RAND() LIMIT " . $easy_counts;
            $result = $conn->query($sql2);
            $quests = selectquiz($conn, $result, $quests);
            //对题号排序
            $rally = explode("*", $quests);
            sort($rally);
            $length = count($rally);
            $quests = '';
            for ($x = 1; $x < $length; $x++) {
                $quests .= $rally[$x] . '*';
            }


            //将试卷详情入库
            $id = '';
            $sql = "INSERT INTO quiz VALUES(?,?,?,?,?)";
            $stmt = $conn->stmt_init();

            if ($stmt->prepare($sql)) {
                $stmt->bind_param("isiis", $id, $diff, $counts, $per_score, $quests);

                $stmt->execute();
                //获取试卷编号
                $quiz_no = $conn->insert_id;
                $stmt->close();
            }
            //生成试题
            showquiz($conn, $quests, $quiz_no);

            //释放试题标记,使其可被选中
            $rally = explode("*", $quests);

            $sql = "UPDATE question SET choose_flag=0 WHERE 1=2";
            for ($i = 0; $i < count($rally) - 1; $i++) {
                $sql .= " OR quest_no=" . $rally[$i];
            }
            $conn->query($sql);

            $sql = "INSERT INTO quiz_record VALUES(?,?,?,?,?,?)";
            $datetime = date("Y-m-d h:i:s");

            // 预先插入一条考试记录
            $stmt = $conn->stmt_init();
            if ($stmt->prepare($sql)) {
                $summit_flag = 0;
                $score = 0;
                $stmt->bind_param("siissi", $_COOKIE["user"], $quiz_no, $score, $datetime, $endtime, $summit_flag);
                $stmt->execute();
                $stmt->close();
            }


        }
    }
    if (@$_GET['action'] == 'judge') {
        $key = array_keys($_GET);
        $value = array_values($_GET);
        $choice_counts = count($key);
        $quiz_no = $_GET['quiz_no'];
        $sql = "SELECT * FROM quiz WHERE quiz_no=" . $quiz_no;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $per_score = $row['per_score'];
                $questions = $row['questions'];
                $quests = explode("*", $questions);
            }
        }
        $score = 0;
        for ($i = 0; $i < $choice_counts - 2; $i++) {
            //判断题号与试卷库中的是否一致
            if ($key[$i] == $quests[$i]) {
                $sql = "SELECT right_choice FROM question WHERE quest_no=" . $key[$i];
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        //一致的情况下判断对错
                        if ($value[$i] == $row['right_choice']) {
                            $score += $per_score;
                        }
                    }
                }
            } else {
                echo "试题出错!";
            }
        }
        //将考试记录存库 学号-试卷号-分数,先判断是否库中已有记录,有则提示重复提交
        $sql = "SELECT * FROM quiz_record WHERE md5_sno='" . $_COOKIE["user"] . "' AND quiz_no=" . $_GET['quiz_no'] . " AND summit_flag=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "请不要重复提交哦";

        } else {
            // 学生提交
            $sql = "UPDATE quiz_record SET score=" . $score . " , summit_flag=1 WHERE md5_sno='" . $_COOKIE["user"] . "' AND quiz_no=" . $_GET['quiz_no'];
            $conn->query($sql);
            echo "你的得分是" . $score;
        }
    }
}
?>
<script language="JavaScript">
    <!-- //
    var runtimes = 0;

    function GetRTime() {
        var nMS = <?=$lefttime?>*
        1000 - runtimes * 1000;
        var nH = Math.floor(nMS / (1000 * 60 * 60)) % 24;
        var nM = Math.floor(nMS / (1000 * 60)) % 60;
        var nS = Math.floor(nMS / 1000) % 60;
        document.getElementById("RemainH").innerHTML = nH;
        document.getElementById("RemainM").innerHTML = nM;
        document.getElementById("RemainS").innerHTML = nS;
        if (nMS == (5 * 60 ) * 1000) {
            document.getElementById("msg").innerHTML = '<div class="alert alert-warning" role="alert">还有最后五分钟,请及时作答！</div>';
        }
        if (nMS == (5 * 60 - 5) * 1000) {
            document.getElementById("msg").innerHTML = "";
        }
        if (nMS == (1) * 1000) {
            document.getElementById("exam").submit();
        }
// {
// alert("还有最后五分钟,请及时作答！");
// }
        runtimes++;
        setTimeout("GetRTime()", 1000);
    }

    window.onload = GetRTime;
    // -->
</script>
<?php include "../include/footer.php"; ?>