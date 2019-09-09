<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
  <!-- 引入 echarts.js -->
  <script src="./static/echarts.js"></script>
  <title>主页</title>

</head>

<body>
<!-- 导航栏 -->
<?php
include 'settings.php';
$conn = new mysqli($servername, $username, $password, $dbname);
  // 检测连接
if ($conn->connect_error) {
  header("refresh:0;url=install.php");
  die("Connection failed: " . $conn->connect_error);
}
?>
<?php include 'nav.php'; ?>   
<div class="container">
  <div class="row">
    <div class="col"><div id="bb" style="width: 600px;height:400px;"></div></div>
    <div class="col"><div id="cc" style="width: 600px;height:400px;"></div></div>
    <div class="col"><div id="dd" style="width: 600px;height:400px;"></div></div>
    <div class="col"><div id="ee" style="width: 600px;height:400px;"></div></div>
  </div>
</div>

  <script type="text/javascript">
    echarts.init(document.getElementById('bb')).setOption({
      title : {
        text: '男女比',
        x:'center'
    },
      tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b}: {c} ({d}%)"
      },
      legend: {
          orient: 'vertical',
          x: 'left',
          data: ['男生', '女生']
      },
      series: [
          {
              name: '男女比',
              type: 'pie',
              radius: ['50%', '70%'],
              avoidLabelOverlap: false,
              label: {
                  normal: {
                      show: false,
                      position: 'center'
                  },
                  emphasis: {
                      show: true,
                      textStyle: {
                          fontSize: '30',
                          fontWeight: 'bold'
                      }
                  }
              },
              labelLine: {
                  normal: {
                      show: false
                  }
              },
              data: [
                  { value: <?php 
                  $sql="SELECT COUNT(*) FROM student WHERE ssex='男'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                    ?>, name: '男生' },
                  { value: <?php 
                  $sql="SELECT COUNT(*) FROM student WHERE ssex='女'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                    ?>, name: '女生' }
                 
              ]
          }
      ]
    });

    echarts.init(document.getElementById('cc')).setOption({
    title : {
        text: '学籍状态',
        x:'center'
    },
    tooltip : {
        trigger: 'item',
        formatter: "{a} <br/>{b} : {c} ({d}%)"
    },
    legend: {
        orient: 'vertical',
        left: 'left',
        data: ['优秀','合格','试读','退学']
    },
    series : [
        {
            name: '学籍状态',
            type: 'pie',
            radius : '55%',
            center: ['50%', '60%'],
            data:[
                {value:<?php 
                  $sql="SELECT COUNT(*) FROM student WHERE sstatus='优秀'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                  ?>, name:'优秀'},
                {value:<?php 
                  $sql="SELECT COUNT(*) FROM student WHERE sstatus='合格'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                  ?>, name:'合格'},
                {value:<?php 
                  $sql="SELECT COUNT(*) FROM student WHERE sstatus='试读'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                  ?>, name:'试读'},
                {value:<?php 
                  $sql="SELECT COUNT(*) FROM student WHERE sstatus='退学'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'];
                    }
                  }
                  ?>, name:'退学'}
            ],
            itemStyle: {
                emphasis: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }
    ]
  });

  echarts.init(document.getElementById('dd')).setOption({
    title: {
                text: '院系情况'
            },
            tooltip: {},
            legend: {
                data: ['人数']
            },
            xAxis: {
                data: [ "信息","海洋", "经管","计算机"]
            },
            yAxis: {},
            series: [{
                name: '人数',
                type: 'bar',
                data: [<?php 
                  $sql="SELECT COUNT(*) FROM student group by sdept";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo $row['COUNT(*)'].',';
                    }
                  }
                  ?>]
            }]
});


  
  </script>


  <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.bootcss.com/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.bootcss.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</body>
</html>