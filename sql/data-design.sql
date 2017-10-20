DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS comment;

CREATE TABLE profile (
	-- primary key
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAtHandle VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profilePhone VARCHAR(32),
	-- unique index made to avoid dublicates of profileEmail and profileHandle
	UNIQUE(profileEmail),
	UNIQUE (profileAtHandle),
	-- defined primary key
	PRIMARY KEY(profileId)
);

CREATE TABLE post (
	-- primary key
	postId BINARY(16) NOT NULL,
	-- foreign key
	postProfileId BINARY (16) NOT NULL,
	postTopic VARCHAR(200) NOT NULL,
	postContent VARCHAR(4000) NOT NULL,
	postDate DATETIME(6) NOT NULL,
	INDEX(postProfileId),
	-- defined foreign key and relation
	FOREIGN KEY(postProfileId) REFERENCES profile(profileId),
	-- defined primary key
	PRIMARY KEY(postId)
);

CREATE TABLE comment (
	-- primary key
	commentId BINARY(16) NOT NULL,
	-- foreign key
	commentProfileId BINARY(16) NOT NULL,
	commentPostId BINARY(16) NOT NULL,
	commentContent VARCHAR(400) NOT NULL,
	commentDate DATETIME(6) NOT NULL,
	INDEX(commentPostId),
	-- defined foreign key and relation
	FOREIGN KEY(commentPostId) REFERENCES post(postId),
	-- defined primary key
	PRIMARY KEY(commentId)
);

-- Select for Entities
SELECT * FROM profile;
SELECT  * FROM post;
SELECT * FROM comment;

-- Update for Entities
UPDATE profile SET profilePhone = "6192088596";
UPDATE post SET postContent = "Hello World";
UPDATE comment SET commentContent = "MySQL is a lot of work";

-- Delete for Entities
DELETE FROM profile WHERE profileEmail;
DELETE FROM post WHERE postTopic;
DELETE FROM comment WHERE commentContent;

-- Insert for Entities
INSERT INTO profile VALUES ();
INSERT INTO post VALUES ();
INSERT INTO comment VALUES ();