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

	/**
	 * accesor method for post id
	 *
	 * @return Uuid value of post id
	 */
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
	 * @param mixed $newPostProfileId
	 */
	public function setPostProfileId($newPostProfileId) {
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
	 */
	public function getPostTopic() {
		return $this->postTopic;
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize() {
		// TODO: Implement jsonSerialize() method.
	}
}