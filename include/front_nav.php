<?php
//判断用户登录状态

echo '
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="../front/index.php">OJ考试系统</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
if (!isset($_COOKIE["user"])) {
    echo '<li class="nav-item">
          <a class="nav-link" href="../front/student_login.php?action=login">考生登录</a>
      </li> ';
} else {
    echo '<li class="nav-item">
          <a class="nav-link" href="../front/student_login.php?action=logout">注销</a>
      </li> ';
}


echo '<li class="nav-item">
        <a class="nav-link" href="../front/online_exam.php?action=start">开始答题</a>
      </li>
      
     
      <li class="nav-item">
          <a class="nav-link" href="../back/teacher_login.php?action=login">教师登录</a>
      </li> 
      </ul>
</div>
</nav> 
      ';

?>
