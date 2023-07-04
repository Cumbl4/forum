<meta charset="utf-8">
<?php
	$info = '';
	$content = '';

		if (!empty($_POST['button'])) {
			if (!empty($_POST['password']) and !empty($_POST['login'])) {
				$login = $_POST['login'];
				$password = $_POST['password'];

				$query = "SELECT *, statuses.name as status FROM users
					LEFT JOIN statuses
				ON users.status_id=statuses.id WHERE login='$login'";
				$result = mysqli_query($link, $query);
				$user = mysqli_fetch_assoc($result);


				if (!empty($user)) {
					$hash = $user['password'];

					if (password_verify($_POST['password'], $hash)) {
						$_SESSION['mes']  = 'Добро пожаловать ' . $_POST['login'] . '!';
						$_SESSION['auth'] = true;
						$_SESSION['id'] = $user['id'];
						$_SESSION['status'] = $user['status'];
						$_SESSION['login'] = $user['login'];
						header('Location: /forum');
					} else {
						$info = 'Неверный пароль!';
					}
				} else {
					$info = 'Неверный логин!';
				}
			}  else {
				$info = 'Незаполнено одно из полей!';
			}
		}

		if (empty($_SESSION['auth'])) {

		$content = '
			<div>
				<form action="" method="POST">
					Логин:<br><input name="login"><br><br>
					Пароль:<br><input name="password" type="password"><br><br>
					<input type="submit" name="button">
				</form>
			</div>
			';
		} else {
			$info = 'Вы уже авторизованы на форуме!';
		}

		$page = [
			'title' => 'аутентификация ',
			'content' => $content,
		];

		$page['info'] = $info;
		return $page;
?>