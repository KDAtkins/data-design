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
	 * @param null $newPostDate
	 **/
	public function __construct($newPostId, $newPostProfileId, $newPostTopic, $newPostDate = null) {
		try {
			$this->setPostId($newPostId);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostTopic($newPostTopic);
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
	 * inserts this Post into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO post(postId, postProfileId, postTopic, postDate) VALUES(:postId, :postProfileId, :postContent, :postDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->postDate->format("Y-m-d H:i:s.u");
		$parameters = ["postId" => $this->postId->getBytes(), "postProfileId" => $this->postProfileId->getBytes(), "postContent" => $this->postTopic, "postDate" => $formattedDate];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Post from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["postId" => $this->postId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Post in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE post SET postProfileId = :postProfileId, postTopic = :postTopic, postDate = :postDate WHERE postId = :postId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->postDate->format("Y-m-d H:i:s.u");
		$parameters = ["postId" => $this->postId->getBytes(),"postProfileId" => $this->postProfileId->getBytes(), "postTopic" => $this->postTopic, "postDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * gets the Post by postId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postId post id to search for
	 * @return Post|null Post found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getPostByPostId(\PDO $pdo, $postId) : ?Post {
		// sanitize the postId before searching
		try {
			$postId = self::validateUuid($postId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT postId, postProfileId, postTopic, postDate FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);
		// bind the post id to the place holder in the template
		$parameters = ["postId" => $postId->getBytes()];
		$statement->execute($parameters);
		// grab the post from mySQL
		try {
			$post = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postTopic"], $row["postDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($post);
	}
	/**
	 * gets the post by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostProfileId(\PDO $pdo, $postProfileId) : \SPLFixedArray {
		try {
			$postProfileId = self::validateUuid($postProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT postId, postProfileId, postTopic, postDate FROM post WHERE postProfileId = :postProfileId";
		$statement = $pdo->prepare($query);
		// bind the post profile id to the place holder in the template
		$parameters = ["postProfileId" => $postProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postTopic"], $row["postDate"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * gets the post by post topic
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postContent post topic to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostTopic(\PDO $pdo, string $postTopic) : \SPLFixedArray {
		// sanitize the description before searching
		$postTopic = trim($postTopic);
		$postTopic = filter_var($postTopic, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($postTopic) === true) {
			throw(new \PDOException("post content is invalid"));
		}
		// escape any mySQL wild cards
		$postTopic = str_replace("_", "\\_", str_replace("%", "\\%", $postTopic));
		// create query template
		$query = "SELECT postId, postProfileId, postTopic, postDate FROM post WHERE postContent LIKE :postContent";
		$statement = $pdo->prepare($query);
		// bind the post content to the place holder in the template
		$postTopic = "%$postTopic%";
		$parameters = ["postTopic" => $postTopic];
		$statement->execute($parameters);
		// build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postTopic"], $row["postDate"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * gets Posts by Date
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime $sunrisePostDate beginning date to search for
	 * @param \DateTime $sunsetPostDate ending date to search for
	 * @return \SplFixedArray Posts or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getPostByPostDate(\PDO $pdo, \DateTime $sunrisePostDate, \DateTime $sunsetPostDate) : \SplFixedArray {
		//enforce both dates are present
		if((empty ($sunrisePostDate) === true) || (empty($sunsetPostDate) === true)) {
			throw (new \InvalidArgumentException("dates are empty or insecure"));
		}
		//ensure both dates are in the correct format and are secure
		try {
			$sunrisePostDate = self::validateDateTime($sunrisePostDate);
			$sunsetPostDate = self::validateDateTime($sunsetPostDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT postId, postProfileId, postTopic, postDate FROM post WHERE postDate >= :sunrisePostDate AND postDate <= :sunsetPostDate";
		$statement = $pdo->prepare($query);
		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunrisePostDate->format("Y-m-d H:i:s.u");
		$formattedSunsetDate = $sunsetPostDate->format("Y-m-d H:i:s.u");
		// bind the post content to the place holder in the template
		$parameters = ["sunrisePostDate" => $formattedSunriseDate, "sunsetPostDate" => $formattedSunsetDate];
		$statement->execute($parameters);
		// build an array of comments
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postTopic"], $row["postDate"]);
				$post[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($posts);
	}
	/**
	 * gets all Posts
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Posts found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPosts(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT postId, postProfileId, postTopic, postDate FROM post";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postTopic"], $row["postDate"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($posts);
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