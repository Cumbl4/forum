<meta charset="utf-8">
<?php
	$userName = $params['userName'];
	$info = '';
	$content = '';

	if (!empty($_SESSION['auth']) and $_SESSION['status'] === 'moderator') {

		if (!empty($_GET['id_ban'])) {
			$id = $_GET['id_ban'];
			$query = "UPDATE users SET status_id='4' WHERE id=$id";
			mysqli_query($link, $query) or die(mysqli_error($link));
		}

		if (!empty($_GET['id_user'])) {
			$id = $_GET['id_user'];
			$query = "UPDATE users SET status_id='3' WHERE id=$id";
			mysqli_query($link, $query) or die(mysqli_error($link));
		}

	$query = "SELECT users.*, statuses.name as status FROM users
			LEFT JOIN statuses
		ON users.status_id=statuses.id
			WHERE users.login='$userName' AND status_id!='1'";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	foreach ($data as $elem) {
	$content =
		"<table border=\"1\">
			<tr>
				<td>{$elem['login']}</td>
				<td>{$elem['status']}</td>
				<td><a href=\"?id_ban={$elem['id']}\">забанить</a><br></td>
				<td><a href=\"?id_user={$elem['id']}\">разбанить</a></td>
			</tr>";
		}
	$content .= '</table>';
		} else {
			$info = 'Информация доступна пользователям со статусом: moderator!';
			$content = '';
		}

	$page = [
		'title' => $userName,
		'content' => $content,
		'info' => $info
	];

	return $page;