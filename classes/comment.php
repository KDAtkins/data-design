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
}