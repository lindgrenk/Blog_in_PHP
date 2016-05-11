<?php
require("../includes/db_connect.php");

// DELETE
if (isset($_POST['delete'])) {

	$id = $_POST['id'];

	try {
		$stmt = $db->prepare("DELETE FROM blog_tbl WHERE id=:id");
		$stmt->bindValue(':id', $id);
		$stmt->execute();
	} catch (PDOexception $e) {
		echo $e->getMessage();
	}
}

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
	<title>Blogg</title>
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
		<form action="add.php" method="POST">
			<input type="submit" name="submit" value="Add post">
		</form>

		<section>
			<?php foreach ($posts as $post) { ?>
				<div>

				<h2><?=htmlentities($post['title']); ?></h2>
				<p><?=htmlentities($post['content']); ?></p>
				<p class="author"><?=htmlentities($post['author']); ?></p>
				<p class="date">Posted: <?=htmlentities($post['published_date']); ?></p>
				
				<form action="update.php" method="POST">
				<input type="hidden" name="id" value=<?="{$post['id']}"?>>
				<input type="submit" name="update" value="Update">
				</form>

				<form action="" method="POST">
				<input type="hidden" name="id" value=<?="{$post['id']}"?>>
				<input type="submit" name="delete" value="Delete">
				</form>
				
				</div>
			<?php } ?>

		</section>
	</main>
</body>
</html>