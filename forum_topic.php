<?php
	$topicSlug = $params['topicSlug'];
	$info = '';
	$content = '';

	if (!empty($_GET['del'])) {
			$del = $_GET['del'];
			$query = "DELETE FROM answers WHERE id=$del";
			mysqli_query($link, $query) or die(mysqli_error($link));
			$info = 'Сообщение удалено!';
		}

	if (empty($topic_id)) {
		$query = "SELECT topic.* FROM topic WHERE name='$topicSlug'";
		$result = mysqli_query($link, $query) or die(mysqli_error($link));

		for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

		foreach ($data as $topic) {
			$topic_id = $topic['id'];
		}

	}

	$query = "SELECT answers.*, answers.id as answer_id, topic.* FROM answers
	LEFT JOIN
		topic ON topic.id=answers.topic_id
	WHERE
		topic.name='$topicSlug'";
	
	$result = mysqli_query($link, $query) or die(mysqli_error($link));

	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	$content = '';
	foreach ($data as $page) {
		$content .= '
		<div>
			<p>
				<b> имя пользователя: <a href="/forum/users/' . $page['ans_name'] . '">' . $page['ans_name'] . '</a></b>
			</p>
			<p>
				сообщение: ' . $page['answer'] . '
			</p>
		</div>
		';

		if (!empty($_SESSION['auth']) and $_SESSION['status'] === 'moderator') {
			$content .= '
			<div>
				<td><a href="/forum/page/' . $catSlug . '/' . $topicSlug . '?del=' . $page['answer_id'] . '">удалить</a></td>
			</div>
			';
		}
	}

	if (!empty($_SESSION['auth']) and $_SESSION['status'] !== 'ban') {
		$content .= '
			<div>
				<form action="" method="POST">
					<br>сообщение:<br> <textarea name="answer"></textarea><br>
					<input type="submit">
				</form>
			</div>
			';
	}

	$page = [
		'title' => $topicSlug,
		'content' => $content
	];

	$page['info'] = $info;

	if(!empty($_POST) and !empty($_POST['answer'])) {
		$ans_name = $_SESSION['login'];
		$answer = $_POST['answer'];
		$query = "INSERT INTO answers SET ans_name='$ans_name', answer='$answer', topic_id='$topic_id'";
		mysqli_query($link, $query) or die(mysqli_error($link));
		header('Location: ' . $topicSlug);
	}

	return $page;
?>