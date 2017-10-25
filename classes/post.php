<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Post"
 *
 **/
namespace Edu\Cnm\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Post implements \JsonSerializable {
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
	 **/
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
	/**
	 * accesor method for post id
	 *
	 * @return Uuid value of post id
	 **/
	public function getPostId(): Uuid {
		return $this->postId;
	}
	/**
	 * @param Uuid/string $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newTweetId is not a uuid or string
	 **/
	public function setPostId(Uuid $newPostId) : void {
		try {
			$uuid = self::validateUuid($newPostId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the post id
		$this->postId = $uuid;
	}
	/**
	 * accessor method for post profile id
	 *
	 * @return Uuid value of post profile id
	 **/
	public function getPostProfileId() {
		return $this->postProfileId;
	}
	/**
	 * mutator method for $newPostProfileId
	 *
	 * @param mixed $newPostProfileId
	 **/
	public function setPostProfileId($newPostProfileId) : void {
		try {
			$uuid = self::validateUuid($newPostProfileId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the post profile id
		$this->postProfileId = $uuid;
	}
	/**
	 * accessor method for post topic
	 *
	 * @return string value of post topic
	 **/
	public function getPostTopic() {
		return $this->postTopic;
	}
	/**
	 * mutator method for post topic
	 *
	 * @param string $newPostTopic new value of post topic
	 * @throws \InvalidArgumentException if $newPostTopic is not a string or insecure
	 * @throws \RangeException if $newPostTopic is > 500
	 * @throws \TypeError if $newPostTopic is not a string
	 **/
	public function setPostTopic(string $newPostTopic) : void {
		// verify the tweet content is secure
		$newPostTopic = trim($newPostTopic);
		$newPostTopic = filter_var($newPostTopic, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

		if(empty($newPostTopic) == true) {
			throw(new \InvalidArgumentException("tweet content is empty or insecure"));
		}
		// verify the tweet content will fit in the database
		if(strlen($newPostTopic) > 500) {
			throw(new \RangeException("tweet content too large"));
		}
		// store the post content
		$this->postContent = $newPostTopic;
	}
	/**
	 * accessor method for post date
	 *
	 * @return \DateTime value of post date
	 **/
	public function getPostDate() : \DateTime {
		return $this->postDate;
	}
	/**
	 * mutator method for post date
	 *
	 * @param \DateTime\string\null $newPostDate post date as a DateTime object
	 * or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newPostDate is not a valid object or
	 * strings
	 * @throws \RangeException if $newPostDate is a date that does not exist
	 **/
	public function setPostDate($newPostDate = null) : void {
		// base case: if the date is null, use the current time and date
		if($newPostDate === null) {
			$this->postDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newPostDate = self::validateDateTime($newPostDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->postDate = $newPostDate;
	}
	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 **/
	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}