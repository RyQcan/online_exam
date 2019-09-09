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

    // 教师表
    $sql10 = "CREATE TABLE users(
        id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        username varchar(30) NOT NULL,
        passwd varchar(66) NOT NULL
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    // 考生表
    $sql11 = "CREATE TABLE student(
        sno varchar(15) PRIMARY KEY  NOT NULL,
        sname varchar(30) NOT NULL,
        ssex varchar(5) NOT NULL,
        sclass varchar(30) not null,
        sdept varchar(30) not null
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    // 试题表
    $sql12 = "CREATE TABLE question(
        quest_no int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        quest_type varchar(64) NOT NULL,
        stem varchar(512) NOT NULL,
        choice_a varchar(64) not null,
        choice_b varchar(64) not null,
        choice_c varchar(64) not null,
        choice_d varchar(64) not null,
        right_choice varchar(8) not null
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    // 考试表
    $sql13 = "CREATE TABLE quiz(
        quiz_no int PRIMARY KEY AUTO_INCREMENT NOT NULL,
        per_score int NOT NULL,
        questions varchar(512) NOT NULL
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";
    //考试记录表
    $sql14 = "CREATE TABLE quiz_record(
        sno varchar(15) NOT NULL,
        quiz_no int NOT NULL,
        score int not null,
        PRIMARY KEY(sno,quiz_no),
        FOREIGN KEY(sno) REFERENCES student(sno),
        FOREIGN KEY(quiz_no) REFERENCES quiz(quiz_no)
        )ENGINE=INNODB  DEFAULT CHARSET=utf8";


    // 初始化,插入测试数据
    $sql20 = "insert into student values
    ('160700221', '张三','男','1607202','海洋'),
    ('160400222', '李四','女','1604202','计算机'),
    ('160400223', '王五','男','1604202','计算机'),
    ('160800101', '赵一','男','1608202','信息'),
    ('160800102', '钱二','男','1608202','信息'),
    ('160800103', '孙三','男','1608202','信息'),
    ('160210212', '刘二','女','1602102','经管')
    ";
    $sql21 = "insert into question values
    (1, '数学','1+1=?','2','4','6','8','A'),
    (2, '物理','电压4v,纯电阻电路,电阻2欧姆,电流多少?','1A','2A','3A','6A','B'),
    (3, '化学','氧气的化学式?','Cu','O2','O3','H2O','B'),
    (4, '计算机','TCP/IP协议中,HTTP请求报文返回状态码404代表?','请求成功','目标被重定位','服务器繁忙','URL错误','D')
    ";
    $sql22 = "insert into quiz values
    (1, 5,'1,2,3,4'),
    (2, 10,'2,4,1'),
    (3, 10,'3,1')
    ";
    $sql23 = "insert into quiz_record values
    ('160700221', 1,55),
    ('160400222', 2,90)
    ";
    //默认管理员
    $pass = md5('123456');
    $sql24 = "insert into users values(1,'admin','" . $pass . "'),(2,'user','" . $pass . "')";

    if ($conn2->multi_query($sql10) && $conn2->multi_query($sql11) && $conn2->multi_query($sql12) &&
        $conn2->multi_query($sql13) && $conn2->multi_query($sql14)
        && $conn2->query($sql20) && $conn2->query($sql21) && $conn2->query($sql22) && $conn2->query($sql23)
        && $conn2->query($sql24)) {
        echo "insert successfully";
    } else {
        echo "Error insert: " . $conn2->error;
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