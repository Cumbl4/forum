<meta charset="utf-8">
<?php
	$info = '';

	if (!empty($_SESSION['auth']) and $_SESSION['status'] === 'admin') {

		if (!empty($_GET['id_moder'])) {
			$id = $_GET['id_moder'];
			$query = "UPDATE users SET status_id='2' WHERE id=$id";
			mysqli_query($link, $query) or die(mysqli_error($link));
		}

		if (!empty($_GET['id_user'])) {
			$id = $_GET['id_user'];
			$query = "UPDATE users SET status_id='3' WHERE id=$id";
			mysqli_query($link, $query) or die(mysqli_error($link));
		}

		if (!empty($_GET['del'])) {
			$del = $_GET['del'];
			$query = "DELETE FROM users WHERE id=$del";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$info = 'Пользователь удален!';
		}

	$query = "SELECT users.*, statuses.name as status FROM users
			LEFT JOIN statuses
		ON users.status_id=statuses.id
			WHERE status_id!='1'";
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

$content = '
	<table border="1">
		<tr>
			<th>login</th>
			<th>status</th>
			<th>delete</th>
			<th>change_status</th>
		</tr>';

	foreach ($data as $elem) {
	$content .=
		"<tr>
			<td>{$elem['login']}</td>
			<td>{$elem['status']}</td>
			<td><a href=\"?del={$elem['id']}\">удалить</a></td>
			<td><a href=\"?id_moder={$elem['id']}\">сделать модератором</a><br><a href=\"?id_user={$elem['id']}\">сделать юзером</a>
			</td>
		</tr>";
		}
	$content .= '</table>';
		} else {
			$info = 'Информация доступна пользователям со статусом: admin!';
			$content = '';
		}

	$page = [
		'title' => 'админка ',
		'content' => $content,
		'info' => $info
	];

	return $page;
?>