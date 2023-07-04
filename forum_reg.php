<meta charset="utf-8">
<?php
	$info = '';
	$content = '';

	if (!empty($_POST['button'])) {
		if (!empty($_POST['login']) and !empty($_POST['password'])) {
			if (preg_match('#^[0-9a-zA-Z]{4,10}$#', $_POST['login'])) {
				if (preg_match('#^[0-9a-zA-Z!-/]{6,12}$#', $_POST['password'])) {
					if ($_POST['password'] == $_POST['confirm']) {
						$login = $_POST['login'];
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
						$date = date('Y-m-d', time());
						$query = "SELECT * FROM users WHERE login='$login'";
						$user = mysqli_fetch_assoc(mysqli_query($link, $query));
							if (empty($user)) {
								$query = "INSERT INTO users SET login='$login', password='$password', date_of_registration='$date', status_id='3'";
								mysqli_query($link, $query);

								$_SESSION['auth'] = true;
								$id = mysqli_insert_id($link);
								$_SESSION['id'] = $id;
								$_SESSION['mes'] = 'Вы успешно зарегестрированы!';

								header('Location: /forum');
							} else {
								$info = 'Логин занят!';
							}
						} else {
							$info = 'Пароли не совпадают!';
						}
				} else {
					$info = 'Пароль должен быть от 6 до 12 символов!';
				}
			} else {
				$info = 'Логин должен быть от 4 до 10 символов и содержать только латинские буквы и цифры!';
			}
		} else {
			$info = 'Не заполнено одно из полей!';
		}
	}

	if (empty($_SESSION['auth'])) {

		$content = '
		<ul>
		<form action="" method="POST">
			<li>Логин:<br><input name="login" value=""></li><br><br>
			<li>Пароль:<br><input name="password" type="password" value=""></li><br><br>
			<li>Повторите пароль:<br><input type="password" name="confirm" value=""></li><br><br>
			<input type="submit" name="button">
		</form>
		</ul>
		';
	} else {
		$info = 'Вы уже зарегистрированы на форуме!';
	}

	$page = [
			'title' => 'регистрация ',
			'content' => $content,
		];

	$page['info'] = $info;

	return $page;
?>