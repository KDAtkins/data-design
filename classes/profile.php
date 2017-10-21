<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Profile"
 *
 **/
class Profile {
	/**
	 * id for profile id (primary key)
	 * @var Uuid $profileID
	 **/
	private $profileID;
	/**
	 * activation token for profile
	 * @var $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * at handle for profile
	 * @var $profileAtHandle
	 **/
	private $profileAtHandle;
	/**
	 * email for profile
	 * @var $profileEmail
	 **/
	private $profileEmail;
	/**
	 * hash for profile
	 * @var $profileHash
	 **/
	private $profileHash;
	/**
	 * salt for profile
	 * @var $profileSalt
	 **/
	private $profileSalt;

	/**
	 * Profile constructor.
	 * @param $newProfileId
	 * @param $newProfileActivationToken
	 * @param $newProfileAtHandle
	 * @param $newProfileEmail
	 * @param $newProfileHash
	 * @param $newProfileSalt
	 **/
	public function __construct($newProfileId, $newProfileActivationToken, $newProfileAtHandle,
										 $newProfileEmail, $newProfileHash, $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
}
