<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Comment"
 *
 **/
namespace Edu\Cnm\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "../vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Comment implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for comment id (primary key)
	 * @var Uuid $commentId
	 **/
	private $commentId;
	/**
	 * id for comment profile id (foreign key)
	 * @var $commentId
	 **/
	private $commentProfileId;
	/**
	 * id for comment post id (foreign key)
	 * @var $commentPostId
	 */
	private $commentPostId;
	/**
	 * content for comment
	 * @var $commentContent
	 */
	private $commentContent;
	/**
	 * date for comment
	 * @var $commentDate
	 */
	private $commentDate;
	/**
	 * Comment constructor.
	 * @param $newCommentId
	 * @param $newCommentProfileId
	 * @param $newCommentPostId
	 * @param $newCommentContent
	 * @param $newCommentDate
	 */
	public function __construct($newCommentId, $newCommentProfileId, $newCommentPostId, $newCommentContent, $newCommentDate) {
		try {
			$this->setCommentId($newCommentId);
			$this->setCommentProfileId($newCommentProfileId);
			$this->setCommentPostId($newCommentPostId);
			$this->setCommentContent($newCommentContent);
			$this->setCommentDate($newCommentDate);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for comment id
	 *
	 * @return Uuid value of comment id
	 */
	public function getCommentId(): Uuid {
		return $this->commentId;
	}

	/**
	 * mutator method for comment id
	 *
	 * @param Uuid/string $newCommentId new value of comment id
	 * @throws \RangeException if $newCommentId is not positive
	 * @throws \TypeError if $newCommentId is not uuid or string
	 **/
	public function setCommentId(Uuid $newCommentId) : void {
		try {
			$uuid = self::validateUuid($newCommentId);
		} catch (\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the tweet id
		$this->commentId = $uuid;
	}

	/**
	 * accessor method for comment profile id
	 *
	 * @return Uuid value of comment profile id
	 */
	public function getCommentProfileId() : Uuid {
		return $this->commentProfileId;
	}

	/**
	 * mutator method for comment profile id
	 *
	 * @param string | Uuid $newCommentProfileId new value of tweet profile id
	 * @throws \RangeException if $newCommentProfileId is not positive
	 * @throws \TypeError if $newCommentProfileId is not an integer
	 */
	public function setCommentProfileId($newCommentProfileId) {
		try {
			$uuid = self::validateUuid($newCommentProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the comment profile id
		$this->commentProfileId = $uuid;
	}

	/**
	 * accessor method for comment post id
	 *
	 * @return Uuid value of comment post id
	 */
	public function getCommentPostId() {
		return $this->commentPostId;
	}

	/**
	 * mutator method for comment post id
	 *
	 * @param string | Uuid $newCommentPostId new value of tweet profile id
	 * @throws \RangeException if $newCommentPostId is not positive
	 * @throws \TypeError if $newCommentPostId is not an integer
	 */
	public function setCommentPostId($newCommentPostId) : void {
		try {
			$uuid = self::validateUuid($newCommentPostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the comment profile id
		$this->commentPostId = $uuid;
	}

	/**
	 * accessor method for comment content
	 *
	 * @return string value of comment content
	 */
	public function getCommentContent() {
		return $this->commentContent;
	}

	/**
	 * mutator method for comment content
	 *
	 * @param string $newCommentContent new value of post topic
	 * @throws \InvalidArgumentException if $newCommentContent is not a string or insecure
	 * @throws \RangeException if $newCommentContent is > 4000
	 * @throws \TypeError if $newCommentContent is not a string
	 **/
	public function setCommentContent(string $newCommentContent) {
		// verify the comment content is secure
		$newCommentContent = trim($newCommentContent);
		$newCommentContent = filter_var($newCommentContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCommentContent) === true) {
			throw(new \InvalidArgumentException("comment content is empty or insecure"));
		}
		// verify the comment content will fit in the database
		if(strlen($newCommentContent) > 4000) {
			throw(new \RangeException("comment content too large"));
		}
		// store the comment content
		$this->commentContent = $newCommentContent;
	}

	/**
	 * accessor method for comment date
	 *
	 * @return string value of comment date
	 */
	public function getCommentDate() {
		return $this->commentDate;
	}

	/**
	 * @param mixed $newCommentDate
	 */
	public function setCommentDate($newCommentDate = null) : void {
		// base case: if the date is null, use the current time and date
		if($newCommentDate === null) {
			$this->postDate = new \DateTime();
			return;
		}
		// store the like date using the ValidateDate trait
		try {
			$newCommentDate = self::validateDateTime($newCommentDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->commentDate = $newCommentDate;
	}

	/**
	 * inserts this comment into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		/** @noinspection SqlResolve */
		// create query template
		$query = "INSERT INTO comment(commentId, commentProfileId, commentPostId, commentContent, commentDate) VALUES
 					(:commentId, :commentProfileId, :commentPostId, :commentContent, :commentDate)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->commentDate->format("Y-m-d H:i:s.u");
		$parameters = ["commentId" => $this->commentId->getBytes(), "commentProfileId" => $this->commentProfileId->getBytes(),
							"commentPostId" => $this->commentPostId->getBytes(), "commentContent" => $this->commentContent,
							"commentDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this Comments from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// create query template
		$query = "DELETE FROM comment WHERE commentId = :commentsId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["postId" => $this->commentId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this comment in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// create query template
		$query = "UPDATE comment SET commentProfileId = :commentProfileId, commentPostId = :commentsPostId, 
					commentContent = :commentContent, commentDate = :commentDate WHERE commentId = :commentId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->commentDate->format("Y-m-d H:i:s.u");
		$parameters = ["commentId" => $this->commentId->getBytes(), "commentProfileId" => $this->commentProfileId->getBytes(),
							"commentPostId" => $this->commentPostId->getBytes(),"commentContent" => $this->commentContent,
							"commentDate" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * gets the comments by comment Id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentId comment id to search for
	 * @return Comment|null Comments found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getCommentsByCommentsId(\PDO $pdo, $commentId) : ?Comment {
		// sanitize the commentsId before searching
		try {
			$commentId = self::validateUuid($commentId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate FROM comment
 						WHERE commentId = :commentsId";
		$statement = $pdo->prepare($query);
		// bind the comments id to the place holder in the template
		$parameters = ["commentId" => $commentId->getBytes()];
		$statement->execute($parameters);
		// grab the comments from mySQL
		try {
			$comment = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$comment = new Comment($row["commentId"], $row["commentProfileId"], $row["commentPostId"],
												$row["commentContent"], $row["commentDate"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($comment);
	}
	/**
	 * gets the comments by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentsProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCommentsByCommentsProfileId(\PDO $pdo, $commentProfileId) : \SPLFixedArray {
		try {
			$commentProfileId = self::validateUuid($commentProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate 
					FROM comment WHERE commentProfileId = :commentProfileId";
		$statement = $pdo->prepare($query);
		// bind the comments profile id to the place holder in the template
		$parameters = ["commentProfileId" => $commentProfileId->getBytes()];
		$statement->execute($parameters);
		// build an array of comments
		$commentsArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentProfileId"], $row["commentPostId"],
								$row["commentContent"], $row["commentDate"]);
				$commentsArray[$commentsArray->key()] = $comment;
				$commentsArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($commentsArray);
	}
	/**
	 * gets the comments by post id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentsPostId post id to search by
	 * @return \SplFixedArray SplFixedArray of Comments found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCommentsByCommentsPostId(\PDO $pdo, $commentPostId) : \SPLFixedArray {
		try {
			$commentPostId = self::validateUuid($commentPostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate 
					FROM comment WHERE commentPostId = :commentPostId";
		$statement = $pdo->prepare($query);
		// bind the comments post id to the place holder in the template
		$parameters = ["commentsProfileId" => $commentPostId->getBytes()];
		$statement->execute($parameters);
		// build an array of comments
		$commentsArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentProfileId"], $row["commentPostId"],
												$row["commentContent"], $row["commentDate"]);
				$commentsArray[$commentsArray->key()] = $comment;
				$commentsArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($commentsArray);
	}
	/**
	 * gets the comments by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $commentsContent comments content to search for
	 * @return \SplFixedArray SplFixedArray of Comments found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getCommentsByCommentsContent(\PDO $pdo, string $commentContent) : \SPLFixedArray {
		// sanitize the description before searching
		$commentContent = trim($commentContent);
		$commentContent = filter_var($commentContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($commentContent) === true) {
			throw(new \PDOException("comments content is invalid"));
		}
		// escape any mySQL wild cards
		$commentContent = str_replace("_", "\\_", str_replace("%", "\\%", $commentContent));
		// create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate FROM comment 
					WHERE commentContent LIKE :commentContent";
		$statement = $pdo->prepare($query);
		$commentContent = "%$commentContent%";
		$parameters = ["commentContent" => $commentContent];
		$statement->execute($parameters);
		// build an array of posts
		$commentsArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentProfileId"], $row["commentPostId"],
												$row["commentContent"], $row["commentDate"]);
				$commentsArray[$commentsArray->key()] = $comment;
				$commentsArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($commentsArray);
	}
	/**
	 * gets comments by date
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime $sunriseCommentsDate beginning date to search for
	 * @param \DateTime $sunsetCommentsDate ending date to search for
	 * @return \SplFixedArray Comments or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCommentsByDate(\PDO $pdo, \DateTime $sunriseCommentsDate, \DateTime $sunsetCommentsDate) : \SplFixedArray {
		//enforce both date are present
		if((empty ($sunriseCommentsDate) === true) || (empty($sunsetCommentsDate) === true)) {
			throw (new \InvalidArgumentException("dates are empty or insecure"));
		}
		//ensure both dates are in the correct format and are secure
		try {
			$sunriseCommentsDate = self::validateDateTime($sunriseCommentsDate);
			$sunsetCommentsDate = self::validateDateTime($sunsetCommentsDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate FROM comment 
					WHERE commentDate >= :sunriseCommentsDate AND commentDate <= :sunsetCommentsDate";
		$statement = $pdo->prepare($query);
		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseCommentsDate->format("Y-m-d H:i:s.u");
		$formattedSunsetDate = $sunsetCommentsDate->format("Y-m-d H:i:s.u");
		// bind the comments content to the place holder in the template
		$parameters = ["sunriseCommentsDate" => $formattedSunriseDate, "sunsetCommentsDate" => $formattedSunsetDate];
		$statement->execute($parameters);
		// build an array of comments
		$commentsArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentId"], $row["commentProfileId"], $row["commentPostId"],
												$row["commentContent"], $row["commentDate"]);
				$comment[$commentsArray->key()] = $comment;
				$commentsArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($commentsArray);
	}
	/**
	 * gets all comments
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Comments found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllComments(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT commentId, commentProfileId, commentPostId, commentContent, commentDate FROM comment";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of comments
		$commentsArray = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$comment = new Comment($row["commentsId"], $row["commentsProfileId"], $row["commentsPostId"],
												$row["commentsContent"], $row["commentsDate"]);
				$commentsArray[$commentsArray->key()] = $comment;
				$commentsArray->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($commentsArray);
	}

	/**
	 * Specify data which should be serialized to JSON
	 * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["commentId"] = $this->commentId->toString();
		$fields["commentProfileId"] = $this->commentProfileId->toString();
		$fields["commentPostId"] = $this->commentPostId->toString();
		//format the date so that the front end can consume it
		$fields["commentDate"] = round(floatval($this->commentDate->format("U.u")) * 1000);
		return($fields);
	}
}