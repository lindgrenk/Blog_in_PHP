<?php
require("../includes/db_connect.php");

$msg = "";
$error = "";
$id = trim($_POST['id']);

// SELECT
try {
	$stmt = $db->query("SELECT * FROM blog_tbl WHERE id=$id;");
	$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOexception $e) {
	echo $e->getMessage();
}

if (isset($_POST['accept'])) {

	$title   = trim($_POST['title']);
	$content = trim($_POST['content']);
	$author  = trim($_POST['author']);

	$regex = "/^[a-zA-Z0-9]*$/";

	if (!$title) {
		$error .= "<li>Skriv in titel</li>";
	}
	if ($title && !preg_match($regex, $title)) {
		$error .= "<li>Titel kan endast skrivas med bokstäver och siffror</li>";
	}
	if (!$content) {
		$error .= "<li>Skriv in content</li>";
	}
	if (!$author) {
		$error .= "<li>Skriv in author</li>";
	}
	if ($author && !preg_match($regex, $author)) {
		$error .= "<li>Author kan endast skrivas med bokstäver och siffror</li>";
	}

	$msg = "<ul>" . $error . "</ul>";

	if (empty($error)) {
		if (isset($_POST['accept'])) {
			
			$msg = "Ditt inlägg är nu uppdaterat";
			
			try {
				$stmt = $db->prepare("UPDATE blog_tbl SET title=:title, content=:content, author=:author WHERE id=:id");
				$stmt->execute(array(':title' => $title, ':content' => $content, ':author' => $author, ':id' => $id));
			} catch (PDOexception $e) {
				echo $e->getMessage();
			}
		}
	}
}
?>
<header>
	<nav>
		<a href="private.php">admin</a>
		<a href="public.php">public</a>
	</nav>
</header>
<fieldset>
	<h2>Update post</h2>
	<p><?php echo $msg ?></p>
	<form action="update.php" method="POST">
		<?php foreach ($fields as $field) { ?>
		<input type="text" name="title" placeholder="Title" value="<?=$field['title']?>">
		<input type="text" name="content" placeholder="Content" value="<?=$field['content']?>">
		<input type="text" name="author" placeholder="Author" value="<?=$field['author']?>">
		<input type="submit" name="accept" value="Submit">
		<input type="hidden" name="id" value="<?=$id?>">
		<?php } ?>
	</form>
</fieldset>