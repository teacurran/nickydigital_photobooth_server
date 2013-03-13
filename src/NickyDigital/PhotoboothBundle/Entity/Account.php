<?php
/**
 * User: T. Curran
 * Date: 3/4/13
 */


namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Accounts
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Account
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @param \DateTime $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $created;

	/**
	 * @var datetime $updated
	 *
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updated;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $email;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $facebookId;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $twitterId;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $name;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $location;

	/**
	 * @ORM\OneToMany(targetEntity="FacebookShare", mappedBy="account")
	 */
	protected $facebookShares;

	/**
	 * @ORM\OneToMany(targetEntity="TwitterShare", mappedBy="account")
	 */
	protected $twitterShares;

	/**
	 * @ORM\OneToMany(targetEntity="EmailShare", mappedBy="account")
	 */
	protected $emailShares;

	/**
	 * @ORM\OneToMany(targetEntity="TumblrShare", mappedBy="account")
	 */
	protected $tumblrShares;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->facebookShares = new \Doctrine\Common\Collections\ArrayCollection();
		$this->twitterShares = new \Doctrine\Common\Collections\ArrayCollection();
		$this->emailShares = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 * @return Account
	 */
	public function setCreated($created)
	{
		$this->created = $created;

		return $this;
	}

	/**
	 * Get created
	 *
	 * @return \DateTime
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * Set updated
	 *
	 * @param \DateTime $updated
	 * @return Account
	 */
	public function setUpdated($updated)
	{
		$this->updated = $updated;

		return $this;
	}

	/**
	 * Get updated
	 *
	 * @return \DateTime
	 */
	public function getUpdated()
	{
		return $this->updated;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return Account
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set facebookId
	 *
	 * @param string $facebookId
	 * @return Account
	 */
	public function setFacebookId($facebookId)
	{
		$this->facebookId = $facebookId;

		return $this;
	}

	/**
	 * Get facebookId
	 *
	 * @return string
	 */
	public function getFacebookId()
	{
		return $this->facebookId;
	}

	/**
	 * Set twitterId
	 *
	 * @param string $twitterId
	 * @return Account
	 */
	public function setTwitterId($twitterId)
	{
		$this->twitterId = $twitterId;

		return $this;
	}

	/**
	 * Get twitterId
	 *
	 * @return string
	 */
	public function getTwitterId()
	{
		return $this->twitterId;
	}

	/**
	 * Set name
	 *
	 * @param string $name
	 * @return Account
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set location
	 *
	 * @param string $location
	 * @return Account
	 */
	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	/**
	 * Get location
	 *
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * Add facebookShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\FacebookShare $facebookShares
	 * @return Account
	 */
	public function addFacebookShare(\NickyDigital\PhotoboothBundle\Entity\FacebookShare $facebookShares)
	{
		$this->facebookShares[] = $facebookShares;

		return $this;
	}

	/**
	 * Remove facebookShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\FacebookShare $facebookShares
	 */
	public function removeFacebookShare(\NickyDigital\PhotoboothBundle\Entity\FacebookShare $facebookShares)
	{
		$this->facebookShares->removeElement($facebookShares);
	}

	/**
	 * Get facebookShares
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getFacebookShares()
	{
		return $this->facebookShares;
	}

	/**
	 * Add twitterShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\TwitterShare $twitterShares
	 * @return Account
	 */
	public function addTwitterShare(\NickyDigital\PhotoboothBundle\Entity\TwitterShare $twitterShares)
	{
		$this->twitterShares[] = $twitterShares;

		return $this;
	}

	/**
	 * Remove twitterShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\TwitterShare $twitterShares
	 */
	public function removeTwitterShare(\NickyDigital\PhotoboothBundle\Entity\TwitterShare $twitterShares)
	{
		$this->twitterShares->removeElement($twitterShares);
	}

	/**
	 * Get twitterShares
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTwitterShares()
	{
		return $this->twitterShares;
	}

	/**
	 * Add emailShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\EmailShare $emailShares
	 * @return Account
	 */
	public function addEmailShare(\NickyDigital\PhotoboothBundle\Entity\EmailShare $emailShares)
	{
		$this->emailShares[] = $emailShares;

		return $this;
	}

	/**
	 * Remove emailShares
	 *
	 * @param \NickyDigital\PhotoboothBundle\Entity\EmailShare $emailShares
	 */
	public function removeEmailShare(\NickyDigital\PhotoboothBundle\Entity\EmailShare $emailShares)
	{
		$this->emailShares->removeElement($emailShares);
	}

	/**
	 * Get emailShares
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getEmailShares()
	{
		return $this->emailShares;
	}
}