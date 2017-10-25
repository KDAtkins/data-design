<?php
/**
 * @author: Kevin Atkins
 *
 * Description: Making class for "Profile"
 *
 **/
namespace Edu\Cnm\DataDesign;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

class Profile implements \JsonSerializable {
	use ValidateUuid;
	use ValidateDate;
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
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
		}
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 **/
	public function getProfileId() : Uuid {
		return ($this->profileID);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid/string $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not a uuid or string
	 **/
	public function setProfileId($newProfileId) : void {
		try {
			$uuid = self::validateUuid($newProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->profileID = $uuid;
	}
	/**
	 * accesor method for profile activation token
	 *
	 * @return mixed value for profile activation token
	 */
	public function getProfileActivationToken() : string {
		return $this->profileActivationToken;
	}
	/**
	 * mutator method for profile activation
	 *
	 * @param mixed $newProfileActivation
	 */
	public function setProfileActivationToken($newProfileActivation) : void {
		$this->profileActivationToken = $newProfileActivation;
	}
	/**
	 * accessor method for profile at handle
	 *
	 * @return string value for profile at handle
	 */
	public function getProfileAtHandle() : string {
		return $this->profileAtHandle;
	}
	/**
	 * mutator method for profile at handle
	 *
	 * @param mixed $newProfileAtHandle
	 */
	public function setProfileAtHandle($newProfileAtHandle) : void {
		$this->profileAtHandle = $newProfileAtHandle;
	}
	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 */
	public function getProfileEmail() : string {
		return $this->profileEmail;
	}
	/**
	 * mutator method for profile email
	 *
	 * @param mixed $newProfileEmail
	 */
	public function setProfileEmail($newProfileEmail) : void {
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * accessor method for profile hash
	 *
	 * @return mixed value for profile hash
	 */
	public function getProfileHash() : string {
		return $this->profileHash;
	}
	/**
	 * mutator method for profile hash
	 *
	 * @param mixed $newProfileHash
	 */
	public function setProfileHash($newProfileHash) : void {
		$this->profileHash = $newProfileHash;
	}
	/**
	 * accessor method for profile salt
	 *
	 * @return mixed value for profile salt
	 */
	public function getProfileSalt() : string {
		return $this->profileSalt;
	}
	/**
	 * mutator method for profile salt
	 *
	 * @param mixed $newProfileSalt
	 */
	public function setProfileSalt($newProfileSalt) : void {
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileID;

		return($fields);
	}
}
