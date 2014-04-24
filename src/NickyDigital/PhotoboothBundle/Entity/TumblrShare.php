<?php

namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TumblrShare
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class TumblrShare
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
	 * @ORM\ManyToOne(targetEntity="Account", inversedBy="tumblrShares")
	 */
	private $account;

	/**
	 * @ORM\ManyToOne(targetEntity="Photo", inversedBy="tumblrShares")
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
	 * @ORM\Column(type="string", length=255)
	 */
	protected $hostname;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $body;

	/**
	 * @var created $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $created;

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

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $serverResponse;


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
     * @return TumblrShare
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
     * @return TumblrShare
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

	public function setServerResponse($serverResponse)
	{
		$this->serverResponse = $serverResponse;
	}

	public function getServerResponse()
	{
		return $this->serverResponse;
	}

	public function setBody($body)
	{
		$this->body = $body;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setHostname($hostname)
	{
		$this->hostname = $hostname;
	}

	public function getHostname()
	{
		return $this->hostname;
	}

	
}