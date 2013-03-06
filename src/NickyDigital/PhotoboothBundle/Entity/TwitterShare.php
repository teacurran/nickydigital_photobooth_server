<?php

namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TwitterShare
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TwitterShare
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
	 * @ORM\ManyToOne(targetEntity="Account", inversedBy="twitterShares")
	 */
	private $account;

	/**
	 * @ORM\ManyToOne(targetEntity="Photo", inversedBy="twitterShares")
	 */
	private $photo;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $oauthToken;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $oauthSecret;

	/**
	 * @ORM\Column(type="string", length=140)
	 */
	protected $shareText;

	// TODO: figure out why Timestampable isn't populating
	/**
	 * @var created $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $created;

	// TODO: figure out why Timestampable isn't populating
	/**
	 * @var dateSent $updated
	 *
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $dateSent;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $status;

	public function setCreated($created)
	{
		$this->created = $created;
	}

	public function getCreated()
	{
		return $this->created;
	}

	public function setDateSent($dateSent)
	{
		$this->dateSent = $dateSent;
	}

	public function getDateSent()
	{
		return $this->dateSent;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setPhoto($photo)
	{
		$this->photo = $photo;
	}

	public function getPhoto()
	{
		return $this->photo;
	}

	public function setOauthToken($oauthToken)
	{
		$this->oauthToken = $oauthToken;
	}

	public function getOauthToken()
	{
		return $this->oauthToken;
	}

	public function setShareText($shareText)
	{
		$this->shareText = $shareText;
	}

	public function getShareText()
	{
		return $this->shareText;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function getUsername()
	{
		return $this->username;
	}



    /**
     * Set status
     *
     * @param string $status
     * @return TwitterShare
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set account
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\Account $account
     * @return TwitterShare
     */
    public function setAccount(\NickyDigital\PhotoboothBundle\Entity\Account $account = null)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return \NickyDigital\PhotoboothBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

	public function setOauthSecret($oauthSecret)
	{
		$this->oauthSecret = $oauthSecret;
	}

	public function getOauthSecret()
	{
		return $this->oauthSecret;
	}

	
}