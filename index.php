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
			<h2>Persona</h2>
			<h3>Jacinta Luxa</h3>
			<h3>User Story</h3>
			<p>Jacinta wants to utilize 'Reddit Clone' as a means to find information
				on a variety of topics/discussions on message boards.</p>
			<h3>Use Case/Interaction Flow</h3>
			<ul>
				<li>Make an user account to log into site</li>
				<li>Simply login if account already exist</li>
				<li>Utilize search feature to find topic/discussion of interest</li>
				<li>If message board regarding topic/discussion doesn't exist, create message board</li>
				<li>Once message board is found, or created, post comment/question/reply to post</li>
			</ul>
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
				<li>One ‘POST’ can have many ‘COMMENT’ - (1 - n)</li>
				<li></li>
			</ul>
		</main>
	</body>
</html>