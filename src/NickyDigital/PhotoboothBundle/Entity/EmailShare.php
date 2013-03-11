<?php

namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EmailShares
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EmailShare
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
	 * @ORM\ManyToOne(targetEntity="Account", inversedBy="emailShares")
	 */
	private $account;

	/**
	 * @ORM\ManyToOne(targetEntity="Photo", inversedBy="twitterShares")
	 */
	private $photo;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $emailFrom;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $emailTo;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $subject;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $status;
	
	/**
	 * @ORM\Column(type="text")
	 */
	protected $body;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $serverResponse;

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

	public function setBody($body)
	{
		$this->body = $body;
	}

	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param \NickyDigital\PhotoboothBundle\Entity\created $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return \NickyDigital\PhotoboothBundle\Entity\created
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param \NickyDigital\PhotoboothBundle\Entity\dateSent $dateSent
	 */
	public function setDateSent($dateSent)
	{
		$this->dateSent = $dateSent;
	}

	/**
	 * @return \NickyDigital\PhotoboothBundle\Entity\dateSent
	 */
	public function getDateSent()
	{
		return $this->dateSent;
	}

	public function setEmailTo($emailTo)
	{
		$this->emailTo = $emailTo;
	}

	public function getEmailTo()
	{
		return $this->emailTo;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function getSubject()
	{
		return $this->subject;
	}


	

    /**
     * Set emailFrom
     *
     * @param string $emailFrom
     * @return EmailShare
     */
    public function setEmailFrom($emailFrom)
    {
        $this->emailFrom = $emailFrom;
    
        return $this;
    }

    /**
     * Get emailFrom
     *
     * @return string 
     */
    public function getEmailFrom()
    {
        return $this->emailFrom;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return EmailShare
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
     * @return EmailShare
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

	public function setServerResponse($serverResponse)
	{
		$this->serverResponse = $serverResponse;
	}

	public function getServerResponse()
	{
		return $this->serverResponse;
	}

	public function setPhoto($photo)
	{
		$this->photo = $photo;
	}

	public function getPhoto()
	{
		return $this->photo;
	}
	
	
	
}