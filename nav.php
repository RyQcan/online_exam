<?php
//判断用户登录状态
if (!isset($_COOKIE["user"])) {
  echo '<div class="alert alert-warning" role="alert">请先登录哦~正在跳转</div>';
  header("refresh:1;url=login.php?action=login");
  exit();
} else {
  echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">OJ考试系统</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">主页 <span class="sr-only"></span></a>
      </li>  
      <li class="nav-item">
          <a class="nav-link" href="login.php?action=logout">注销</a>
      </li>  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          考生管理</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
          <a class="dropdown-item" href="stu.php?action=add">添加考生</a>
          <a class="dropdown-item" href="stu.php?action=search">查询考生</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          考题管理</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
          <a class="dropdown-item" href="questions.php?action=add">添加考题</a>
          <a class="dropdown-item" href="questions.php?action=search">查询考题</a>
        </div>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="quiz.php?action=index">考试管理</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="score.php?action=search">成绩查询</a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="back.php">系统维护</a>
      </li>';
      
}
?>
    </ul>     
  </div>
</nav>