INSERT INTO profile (profileId, profileActivationToken, profileAtHandle,
							profileEmail, profileHash, profileSalt, profilePhone)
VALUES (
	-- generated UUID for profile ID converted to binary format
	UNHEX(REPLACE("bd4f1683-4ee6-4b17-9f19-8af2a3aeb230", "-", "")),
	-- activation token
	"11ccfb9bf715af1c5a00330888470fa0",
	-- at handle
	"@katkins2",
	-- email
	"kevindewayneatkins@gmail.com",
	-- hash
	"063b6645cdb3042291015982db2e30d5df9746a772fb0b42c8ba108bcc8326bl5fd587a8fb8ad6b08d434d9bb321fe92270d06ce836de0dadbc56469ffa31360",
	-- salt
	"8b00cee20d192975db6fc76b9694d7d0fab776b9416e74e4715f296f2e77b1fc",
	-- phone
	"12345678899"
);

INSERT INTO post (postId, postProfileId, postTopic, postContent, postDate)
VALUES (
	-- generated UUID for post ID converted to binary format
	UNHEX(REPLACE("6f14ba0b-daba-45fa-9506-4be0af8c2465", "-", "")),
	-- post profile ID
	UNHEX(REPLACE("bd4f1683-4ee6-4b17-9f19-8af2a3aeb230", "-", "")),
	-- post topic
	"",
	-- post content
	"",
	-- post date
	""
);

INSERT INTO comment (commentId, commentProfileId, commentPostId, commentContent, commentDate)
VALUES (
	-- comment id
	UNHEX(REPLACE("440bf065-4b16-4318-89f6-d76418395390", "-", "")),
	-- comment profile id
	UNHEX(REPLACE("bd4f1683-4ee6-4b17-9f19-8af2a3aeb230", "-", "")),
	-- comment post id
	UNHEX(REPLACE("6f14ba0b-daba-45fa-9506-4be0af8c2465", "-", "")),
	-- comment content id
	"",
	-- comment date
	""
);
-- update phone number of profile id
UPDATE profile
SET profilePhone = "1122334455"
WHERE profileId = "bd4f1683-4ee6-4b17-9f19-8af2a3aeb230";

-- update post content of post id
UPDATE post
SET postContent = "Where is Carmen San Diego?"
WHERE postId = "6f14ba0b-daba-45fa-9506-4be0af8c2465";

-- update comment content of post id
UPDATE comment
SET commentContent = "She is at some historical landmark somewhere..."
WHERE commentPostId = "440bf065-4b16-4318-89f6-d76418395390";

-- select profile handle from profile salt
SELECT profileAtHandle
FROM profile
WHERE profileSalt = "8b00cee20d192975db6fc76b9694d7d0fab776b9416e74e4715f296f2e77b1fc";

-- select post topic from post content
SELECT postTopic
FROM post
WHERE postContent = "Where is Carmen San Diego?";

-- select comment post id from comment profile id
SELECT commentPostId
FROM comment
WHERE commentProfileId = "bd4f1683-4ee6-4b17-9f19-8af2a3aeb230";

-- delete email from profile entity
DELETE FROM profile
WHERE profileEmail = "kevindewayneatkins@gmail.com";

-- delete empty date from post entity
DELETE FROM post
WHERE postDate = "";

-- delete empty date from comment entity
DELETE FROM comment
WHERE commentDate = "";