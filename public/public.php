<?php
require("../includes/db_connect.php");

// SELECT
try {
	$stmt = $db->query("SELECT * FROM blog_tbl;");
	$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOexception $e) {
	echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="UTF-8">
	<title>Blogg-sida</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<nav>
			<a href="private.php">admin</a>
			<a href="public.php">public</a>
		</nav>
		<h1>Blogg</h1>
	</header>

	<main>
		<section>
			<?php foreach ($posts as $post) { ?>
				<div>

				<h2><?=htmlentities($post['title']); ?></h2>
				<p><?=htmlentities($post['content']); ?></p>
				<p class="author"><?=htmlentities($post['author']); ?></p>
				<p class="date">Posted: <?=htmlentities($post['published_date']); ?></p>

				</div>
			<?php } ?>
		</section>
	</main>
</body>
</html>