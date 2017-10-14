<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Data Design Project</title>
	</head>
	<body>
		<header>
			<h1>Data Design - Conceptual Design</h1>
		</header>
		<main>
			<h2>Entities & Attributes</h2>
			<h3>POST</h3>
			<ul>
				<li>postId (Primary key)</li>
				<li>postTopic</li>
				<li>postComment</li>
				<li>postDate</li>
			</ul>
			<h3>COMMENT</h3>
			<ul>
				<li>commentId (Primary key)</li>
				<li>commentPostId (Foreign Key)</li>
				<li>commentContent</li>
				<li>commentDate</li>
			</ul>
			<h2>Relations</h2>
			<ul>
				<li>One ‘POST’ can have many ‘Comment’ - (1 - n)</li>
			</ul>
		</main>
	</body>
</html>