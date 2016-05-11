<?php
require("../includes/db_connect.php");

$msg = "";
$error = "";

if (isset($_POST['add'])) {
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
		if (isset($_POST['add'])) {

			$msg = "Ditt inlägg är nu postat";

			try {
				$stmt = $db->prepare("INSERT INTO blog_tbl (title, content, author) VALUES(:title, :content, :author)");
				$stmt->execute(array(':title' => $title, ':content' => $content, ':author' => $author));		
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
	<h2>Add post</h2>
	<p><?php echo $msg ?></p>
	<form action="add.php" method="POST">
		<input type="text" name="title" placeholder="Title">
		<input type="text" name="content" placeholder="Content">
		<input type="text" name="author" placeholder="Author">
		<input type="submit" name="add" value="Submit">
	</form>
</fieldset>