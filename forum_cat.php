<?php
	$catSlug = $params['catSlug'];
	$info = '';
	$content = '';

	if (!empty($_GET['del'])) {
			$del = $_GET['del'];
			$query = "DELETE FROM topic WHERE id=$del";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$info = 'Тема удалена!';
		}

	if (empty($category_id)) {
		$query = "SELECT category.* FROM category WHERE slug='$catSlug'";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));

		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

		foreach ($data as $category) {
			$category_id = $category['id'];
		}
	}

	$query = "SELECT topic.*, topic.id as page_id, category.* FROM topic
	LEFT JOIN
		category ON category.id=topic.category_id
	WHERE
		category.slug='$catSlug'";
	
	$result = mysqli_query($link, $query) or die(mysqli_error($link));

	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	$content = '';
	foreach ($data as $page) {
		$content .= '
		<div>
			<p>
				<h1> название темы: <a href="/forum/page/' . $catSlug . '/' . $page['name'] . '">' . $page['name'] . '</a></b></h1>
				<b> имя пользователя: <a href="/forum/users/' . $page['user_name'] . '">' . $page['user_name'] . '</a></b>
			</p>
		</div>
		';

		if (!empty($_SESSION['auth']) and $_SESSION['status'] === 'moderator') {
			$content .= '
			<div>
				<td><a href="/forum/page/' . $catSlug . '?del=' . $page['page_id'] . '">удалить</a></td>
			</div>
			';
		}
	}

	if (!empty($_SESSION['auth']) and $_SESSION['status'] !== 'ban') {
		$content .= '
			<div>
				<form action="" method="POST">
					<h1>Создать тему:</h1><br>
					название темы:<br> <input name="name"><br>
					<input type="submit">
				</form>
			</div>
			';
	}

	$page = [
		'title' => $catSlug,
		'content' => $content
	];

	$page['info'] = $info;

	if(!empty($_POST['name'])) {
		$user_name = $_SESSION['login'];
		$name = $_POST['name'];
		$query = "INSERT INTO topic SET user_name='$user_name', name='$name', category_id='$category_id'";
		mysqli_query($link, $query) or die(mysqli_error($link));
		header('Location: /forum/page/' . $catSlug);
	}

	return $page;
?>