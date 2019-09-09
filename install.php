<?php
// 包含配置文件
include 'settings.php';
// 创建连接
$conn = new mysqli($servername, $username, $password);
// 检测连接
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// 创建数据库
$sql = "CREATE DATABASE " . $dbname;
if ($conn->query($sql) === true) {
    echo "Database created successfully";
    $conn2 = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn2->connect_error) {
        die("Connection failed: " . $conn2->connect_error);
    }

    // 创建管理员表
    $sql2 = "CREATE TABLE users(
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        username varchar(30) NOT NULL,
        passwd varchar(66) NOT NULL
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    // 创建学生表
    $sql3 = "CREATE TABLE student(
        sno varchar(15) PRIMARY KEY  NOT NULL,
        sname varchar(30) NOT NULL,
        ssex varchar(5) NOT NULL,
        sclass varchar(30) not null,
        sdept varchar(30) not null,
        sstatus varchar(10)
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    //选课表
    $sql4="CREATE TABLE sc(
        sno varchar(15) NOT NULL,
        cno varchar(15) NOT NULL,
        cname varchar(20) not null,
        year int not null,
        score int not null,
        PRIMARY KEY(sno,cno),
        FOREIGN KEY(sno) REFERENCES student(sno)
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";

    // 初始化,插入测试数据
    $sql5 = "insert into student values
    ('160700221', '张三','男','1607202','海洋','优秀'),
    ('160400222', '李四','女','1604202','计算机','合格'),
    ('160400223', '王五','男','1604202','计算机','合格'),
    ('160800101', '赵一','男','1608202','信息','合格'),
    ('160800102', '钱二','男','1608202','信息','试读'),
    ('160800103', '孙三','男','1608202','信息','合格'),
    ('160210212', '刘二','女','1602102','经管','退学')
    ";
    //默认管理员
    $pass=md5('123456');
    $sql6 = "insert into users values(1,'admin','".$pass."'),(2,'user','".$pass."')";
    //选课数据
    $sql7="INSERT INTO SC VALUES
    ('160700221','101','数据结构',1,99),
    ('160400222','102','C++',1,60),
    ('160400223','102','C++',1,64),
    ('160800101','103','C',1,73),
    ('160800102','101','数据结构',1,55),
    ('160800103','101','数据结构',1,84),
    ('160210212','101','数据结构',1,68),
    ('160210212','103','C',1,8)
    ";
    if ($conn2->query($sql2) && $conn2->query($sql3) && $conn2->query($sql4)&& $conn2->query($sql5)&& $conn2->query($sql6)&& $conn2->query($sql7)) {
        echo "Table  created successfully";
    } else {
        echo "Error creating table: " . $conn2->error;
    }

    $conn2->close();
    //安装完成,跳转到主页
    echo "正在跳转到<a href='index.php'>主页</a>";
    header("refresh:1;url=index.php");
} else {
    // 安装失败/重复安装
    echo "Error creating database: " . $conn->error;
}
$conn->close();
?>