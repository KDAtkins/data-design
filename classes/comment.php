<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Comment"
 *
 **/
class Comment {
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
		$this->commentId = $newCommentId;
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
		$this->commentProfileId = $newCommentProfileId;
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
		$this->commentPostId = $newCommentPostId;
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
			$newPostDate = self::validateDateTime($newCommentDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->commentDate = $newCommentDate;
	}
}