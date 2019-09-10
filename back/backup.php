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
$name = "backup/" . date("Y.m.d.h.i.s") . ".sql";
$exec = "D:/wamp64/bin/mysql/mysql5.7.19/bin/mysqldump -u" . $username . " -p" . $password . " " . $dbname . " > " . $name;
echo '<div class="alert alert-success" role="alert">备份成功!' . exec($exec) . $name . ' </br>恢复方法mysql -u username -p password  dbname < ' . $name . '</div>';

?>
<?php include "../include/footer.php"; ?>