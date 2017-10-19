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
			<p>Jacinta Luxa, a 27-year-old owner of Digital Cafe, is a restless entrepreneur looking to
				renovate a DIY website that has limitations on how her site engages with customers. She is
				confident that a full-stack web developer will be able to deliver a site that will meet her
				expectations and can convey what she is trying to accomplish. The technology she utilizes
				for her business are: an iMac, iPad mini, and iPhone 6s. Her primary frustration is trying
				to attract the millennial demographic. She wants to utilize 'Reddit Clone' as a means to find information
				on a variety of topics/discussions on message boards.</p>
			<h3>Use Case</h3>
			<p>Utilizes site to browse/discover/participate in topics and discussions.</p>
			<h3>Interaction Flow</h3>
			<ul>
				<li>Make an user account to log into site</li>
				<li>Simply login if account already exist</li>
				<li>Utilize search feature to find topic/discussion of interest</li>
				<li>If message board regarding topic/discussion doesn't exist, create message board</li>
				<li>Once message board is found, or created, post comment/question/reply to post</li>
			</ul>
			<h2>Entities & Attributes</h2>
			<h3>PROFILE</h3>
			<ul>
				<li>profileId (Primary key)</li>
				<li>profileActivationToken</li>
				<li>profileAtHandle</li>
				<li>profileEmail</li>
				<li>profileHash</li>
				<li>profileSalt</li>
			</ul>
			<h3>POST</h3>
			<ul>
				<li>postId (Primary key)</li>
				<li>postProfileId (Foreign key)</li>
				<li>postTopic</li>
				<li>postContent</li>
				<li>postDate</li>
			</ul>
			<h3>COMMENT</h3>
			<ul>
				<li>commentId (Primary key)</li>
				<li>commentProfileId (Foreign key)</li>
				<li>commentPostId (Foreign key)</li>
				<li>commentContent</li>
				<li>commentDate</li>
			</ul>
			<h2>Relations</h2>
			<ul>
				<li>One 'PROFILE' can have many 'POST' - (1 - n)</li>
				<li>One ‘POST’ can have many ‘COMMENT’ - (1 - n)</li>
				<li>One 'PROFILE' can have many 'COMMENTS'</li>
			</ul>
		</main>
		<footer></footer>
	</body>
</html>