<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Post"
 *
 **/
class Post {
	/**
	 * id for post id (primary key)
	 * @var Uuid $postId
	 **/
	private $postId;
	/**
	 * id for post profile id (foreign key)
	 * @var $postProfileID
	 **/
	private $postProfileId;
	/**
	 * topic for post
	 * @var  $postTopic
	 **/
	private $postTopic;
	/**
	 * content for post
	 * @var $postContent
	 **/
	private $postContent;
	/**
	 * date for post
	 * @var $postDate
	 **/
	private $postDate;

	/**
	 * Post constructor.
	 * @param $newPostId
	 * @param $newPostProfileId
	 * @param $newPostTopic
	 * @param $newPostContent
	 * @param null $newPostDate
	 */
	public function __construct($newPostId, $newPostProfileId, $newPostTopic, $newPostContent, $newPostDate = null) {
		try {
			$this->setPostId($newPostId);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostTopic($newPostTopic);
			$this->setPostContent($newPostContent);
			$this->setPostDate($newPostDate);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
}