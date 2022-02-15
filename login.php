<?php include("includes/header.php"); ?>
<div class="container mregister">
  <div id="login">
    <h1>Вход</h1>
    <form action="" id="loginform" method="post"name="loginform">
      <p><label for="user_login">Логин<br>
        <input class="input" id="username" name="username"size="20"
        type="text" value=""></label></p>
        <p><label for="user_pass">Пароль<br>
          <input class="input" id="password" name="password"size="20"
          type="password" value=""></label></p>
          <p class="submit"><input class="button" name="login"type= "submit" value="Войти"></p>
          <p class="regtext">Еще не зарегестрированы?<a href= "register.php"><br>Регистрация</a>!</p>
        </form>
      </div>
    </div>


    <?php
    session_start();
    ?>

    <?php require_once("includes/connection.php"); ?>
    <?php include("includes/header.php"); ?>
    <?php


    if(isset($_POST["login"]))
    {

      if(!empty($_POST['username']) && !empty($_POST['password']))
      {
        $username=htmlspecialchars($_POST['username']);
        $password=htmlspecialchars($_POST['password']);
        $query =mysqli_query($con,"SELECT * FROM usertbl WHERE username = '".$username."' AND password = '".$password."' AND roleID = '1'");//aдмин
        $query1 =mysqli_query($con,"SELECT * FROM usertbl WHERE username = '".$username."' AND password = '".$password."' AND roleID = '0'");//юзер
        $query2 =mysqli_query($con,"SELECT * FROM usertbl WHERE username = '".$username."' AND password = '".$password."' AND roleID = '0'");//u

		//от имени админа
        $numrows=mysqli_num_rows($query);
        if($numrows!=0){
          $_SESSION['session_username']=$username;
          header("location:edit_film.php");
        }
        else{
          //от имени юзера
          $numrows1=mysqli_num_rows($query1);
          if($numrows1!=0){
            $_SESSION['session_username']=$username;
            header("location:show_film.php");
          }
          else{
          	echo  $message = "<p class = 'error' >" ."Неправильный логин или пароль!"."</p>";
          }
        }
      }
      else {
        echo   $message = "<p class = 'error' >" ."Заполните все поля!"."</p>";
      }
    }
    else
    {
      $message = "!!!";
    }
    ?>

