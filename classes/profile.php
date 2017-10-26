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
	private $profileId;
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
	 * phone for profile
	 * @var $profilePhone
	 **/
	private $profilePhone;

	/**
	 * Profile constructor.
	 * @param $newProfileId
	 * @param $newProfileActivationToken
	 * @param $newProfileAtHandle
	 * @param $newProfileEmail
	 * @param $newProfileHash
	 * @param $newProfileSalt
	 * @param $newProfilePhone
	 **/
	public function __construct($newProfileId, $newProfileActivationToken, $newProfileAtHandle,
										 $newProfileEmail, $newProfileHash, $newProfileSalt, $newProfilePhone) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfilePhone($newProfilePhone);
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
		return ($this->profileId);
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
		$this->profileId = $uuid;
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
	 * @param string $newProfileAtHandle
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
	 * @param string $newProfileEmail
	 */
	public function setProfileEmail($newProfileEmail) : void {
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * accessor method for profile hash
	 *
	 * @return string value for profile hash
	 */
	public function getProfileHash() : string {
		return $this->profileHash;
	}
	/**
	 * mutator method for profile hash
	 *
	 * @param string $newProfileHash
	 */
	public function setProfileHash($newProfileHash) : void {
		$this->profileHash = $newProfileHash;
	}
	/**
	 * accessor method for profile salt
	 *
	 * @return string value for profile salt
	 */
	public function getProfileSalt() : string {
		return $this->profileSalt;
	}
	/**
	 * mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 */
	public function setProfileSalt($newProfileSalt) : void {
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * accessor method for profile phone
	 *
	 * @return string value for profile phone
	 */
	public function getProfilePhone() : string  {
		return $this->profilePhone;
	}
	/**
	 * mutator method for profile phone
	 *
	 * @param string $newProfilePhone
	 */
	public function setProfilePhone($profilePhone) {
		$this->profilePhone = $profilePhone;
	}
	/**
	 * inserts this profile into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		// create query template
		$query = "INSERT INTO profile(profileId, profileActivationToken, profileAtHandle, profileEmail,
 												profileHash, profileSalt, profilePhone) VALUES (:profileId, :profileActivationToken,
 												:profileAtHandle, :profileEmail, :profileHash, :profileSalt, :profilePhone)";
		$statement = $pdo->prepare($query);

		$parameters = ["profileId" => $this->profileId->getBytes(), "profileActivationToken" => $this->profileActivationToken,
							"profileAtHandle" => $this->profileAtHandle, "profileEmail" => $this->profileEmail,
							"profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt, "profilePhone" => $this->profilePhone];
		$statement->execute($parameters);
	}
	/**
	 * deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		//enforce the profileId is not null (don't delete a profile that does not exist)
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that does not exist"));
		}
		//create query template
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}

	/**
	 * updates this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		//Enforce the profileId is not null (don't update a profile that does not exist)
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}
		//create query template
		$query = "UPDATE profile SET profileId = :profileId, profileActivationToken = :profileActivationToken, 
					profileAtHandle = :profileAtHandle, profileEmail = :profileEmail, 
					profileHash = :profileHash, profileSalt = :profileSalt, profilePhone = :profilePhone";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holders in the template
		$parameters = ["profileId=>$this->profileId", "profileActivationToken" => $this->profileActivationToken,
							"profileAtHandle=>$this->profileAtHandle", "profileEmail" => $this->profileEmail,
							"profileHash" => $this->profileHash, "profileSalt" =>$this->profileSalt,
							"profilePhone" =>$this->profilePhone];
		$statement->execute($parameters);
	}
	/**
	 * gets the Profile by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $profileId to search for profile id
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, $profileId) : ?Profile {
		//sanitize the profile id before searching
		try {
			$profileId = self::validateUuid($profileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash,
 						profileSalt, profilePhone FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		//bind the profile id to the place holder in the template
		$parameters = ["profileId"=>$profileId];
		$statement->execute($parameters);
		//grab the Profile from mySQL
		try{
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"],
											$row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profilePhone"]);
			}
		}
		catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new\PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * get the Profile by user name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUserName to search for profile at handle
	 * @return \SPLFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 **/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName) : \SPLFixedArray {
		// sanitize the user name before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("not a valid user name"));
		}
		// create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, profileSalt, 
					profilePhone FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);
		//bind the profile user name to the place holder in the template
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);
		$profiles = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"],
								$row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profilePhone"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch (\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * get the Profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function	getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {
		//make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}
		//create the query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, 
					profileSalt, profilePhone FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);
		//bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);
		//grab the Profile from mySQL
		try {
			$profile = null;
			$statement-> setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"],
								$row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profilePhone"]);
			}
		}
		catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * get the profile by profile email
	 *
	 * @param \PDO $pdo pdo PDO connection object
	 * @param string $profileEmail to search for profile email
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getProfileByProfileEmail(\PDO $pdo, string $profileEmail) : ?Profile {
		//sanitize email before searching
		$profileEmail = trim($profileEmail);
		$profileEmail = filter_var($profileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($profileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}
		//create query template
		$query="SELECT profileId, profileActivationToken, profileAtHandle, profileEmail, profileHash, 
					profileSalt, profilePhone FROM profile WHERE profileEmail = :profileEmail";
		$statement = $pdo->prepare($query);
		//bind the profile email to the place holder in the template
		$parameters = ["profileEmail"=>$profileEmail];
		$statement->execute($parameters);
		//grab the Profile from mySQL
		try {
			$profile = null;
			$statement-> setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"],
												$row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profilePhone"]);
			}
		}
		catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($profile);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize() {
		$fields = get_object_vars($this);

		$fields["profileId"] = $this->profileId;

		return($fields);
	}
}
