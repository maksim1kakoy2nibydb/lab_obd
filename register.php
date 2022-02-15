<?php include("includes/header.php"); ?>
<?php require_once("includes/connection.php"); ?>
<div class="container mregister">
	<div id="login">
		<h1>Регистрация</h1>
		<form action="register.php" id="registerform" method="post"name="registerform">
			<p><label for="user_login">Ваше имя<br>
				<input class="input" id="full_name" name="full_name"size="32"  type="text" value=""></label></p>
				<p><label for="user_pass">E-mail<br>
					<input class="input" id="email" name="email" size="32"type="email" value=""></label></p>
					<p><label for="user_pass">Логин<br>
						<input class="input" id="username" name="username"size="20" type="text" value=""></label></p>
						<p><label for="user_pass">Пароль<br>
							<input class="input" id="password" name="password"size="32"   type="password" value=""></label></p>
							<p class="submit"><input class="button" id="register" name= "register" type="submit" value="Готово"></p>
							<p class="regtext">Уже зарегистрированы? <a href= "login.php"><br>Войти</a>!</p>
						</form>
					</div>
				</div>
				<?php

				if(isset($_POST["register"])){

					if(!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])) {
						$full_name= filter_var(htmlspecialchars($_POST['full_name']),FILTER_SANITIZE_STRING);
						$email = filter_var(htmlspecialchars($_POST['email']),FILTER_SANITIZE_STRING);
						$username = filter_var(htmlspecialchars($_POST['username']),FILTER_SANITIZE_STRING);
						$password = filter_var(htmlspecialchars($_POST['password']),FILTER_SANITIZE_STRING);
						$query = mysqli_query($con, "SELECT * FROM usertbl WHERE username='".$username."'");
						$numrows = mysqli_num_rows($query);
						if($numrows==0)
						{
							$sql="INSERT INTO usertbl
							(full_name, email, username,password)
							VALUES('$full_name','$email', '$username', '$password')";
							$result=mysqli_query($con, $sql);
							if($result){
								$message = "Ваш аккаунт создан!";
							} else {
								$message = "Не удалось вставить информацию о данных";
							}
						} else {
							$message = "Это имя пользователя уже используется!";
						}
					} else {
						$message = "Заполните все поля!";
					}
				}
				?>

				<?php if (!empty($message)) {echo "<p class = 'error' >" ."ВНИМАНИЕ: ".$message ."</p>";} ?>


