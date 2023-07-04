<?php
	$query = "SELECT * FROM category";

	$result = mysqli_query($link, $query) or die(mysqli_error($link));

	for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

	$content = '';
	foreach ($data as $page) {
		$content .= '
			<div>
				<a href="/forum/page/' . $page['slug'] . '">' . $page['title'] . '</a>
			</div>
		';
	}

	$page = [
		'title' => 'список всех категорий ',
		'content' => $content,
		'info' => ''
	];

		if (isset($_SESSION['mes'])) {
			$page['info'] .= $_SESSION['mes'];
			unset($_SESSION['mes']);
	}

	return $page;
?>