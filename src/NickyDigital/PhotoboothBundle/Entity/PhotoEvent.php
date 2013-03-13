<?php

namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PhotoEvent
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PhotoEvent
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
	 * @ORM\Column(type="string", length=100)
	 */
	protected $eventCode;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $folder;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $eventName;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $albumName;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $albumDesc;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $banner;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $shortShareText;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $longShareText;

	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	protected $emailShareSubject;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $emailShareText;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $tumblrShareText;

	/**
	 * @ORM\Column(type="string", length=200, nullable=true)
	 */
	protected $tumblrTags;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $current = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $showFacebook = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $showTwitter = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $showTumblr = false;

	/**
	 * @ORM\Column(type="boolean")
	 */
	protected $showEmail = false;

	/**
	 * @ORM\OneToMany(targetEntity="Photo", mappedBy="event")
	 */
	protected $photos;

	/**
	 * @ORM\OneToMany(targetEntity="Email", mappedBy="event")
	 */
	protected $emails;

	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $eventDate;

	// TODO: figure out why Timestampable isn't populating
	/**
	 * @var datetime $created
	 *
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $created;

	// TODO: figure out why Timestampable isn't populating
	/**
	 * @var datetime $updated
	 *
	 * @Gedmo\Timestampable(on="update")
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	protected $updated;

	public function setAlbumName($albumName)
	{
		$this->albumName = $albumName;
	}

	public function getAlbumName()
	{
		return $this->albumName;
	}

	public function setBanner($banner)
	{
		$this->banner = $banner;
	}

	public function getBanner()
	{
		return $this->banner;
	}

	/**
	 * @param \NickyDigital\PhotoboothBundle\Entity\datetime $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return \NickyDigital\PhotoboothBundle\Entity\datetime
	 */
	public function getCreated()
	{
		return $this->created;
	}

	public function setCurrent($current)
	{
		$this->current = $current;
	}

	public function getCurrent()
	{
		return $this->current;
	}

	public function setEmails($emails)
	{
		$this->emails = $emails;
	}

	public function getEmails()
	{
		return $this->emails;
	}

	public function setEventDate($eventDate)
	{
		$this->eventDate = $eventDate;
	}

	public function getEventDate()
	{
		return $this->eventDate;
	}

	public function setEventName($eventName)
	{
		$this->eventName = $eventName;
	}

	public function getEventName()
	{
		return $this->eventName;
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

	public function setLongShareText($longShareText)
	{
		$this->longShareText = $longShareText;
	}

	public function getLongShareText()
	{
		return $this->longShareText;
	}

	public function setPhotos($photos)
	{
		$this->photos = $photos;
	}

	public function getPhotos()
	{
		return $this->photos;
	}

	public function setShortShareText($shortShareText)
	{
		$this->shortShareText = $shortShareText;
	}

	public function getShortShareText()
	{
		return $this->shortShareText;
	}

	/**
	 * @param \NickyDigital\PhotoboothBundle\Entity\datetime $updated
	 */
	public function setUpdated($updated)
	{
		$this->updated = $updated;
	}

	/**
	 * @return \NickyDigital\PhotoboothBundle\Entity\datetime
	 */
	public function getUpdated()
	{
		return $this->updated;
	}

	public function setEventCode($eventCode)
	{
		$this->eventCode = $eventCode;
	}

	public function getEventCode()
	{
		return $this->eventCode;
	}

	public function setEmailShareText($emailShareText)
	{
		$this->emailShareText = $emailShareText;
	}

	public function getEmailShareText()
	{
		return $this->emailShareText;
	}

	public function setShowEmail($showEmail)
	{
		$this->showEmail = $showEmail;
	}

	public function getShowEmail()
	{
		return $this->showEmail;
	}

	public function setShowFacebook($showFacebook)
	{
		$this->showFacebook = $showFacebook;
	}

	public function getShowFacebook()
	{
		return $this->showFacebook;
	}

	public function setShowTumblr($showTumblr)
	{
		$this->showTumblr = $showTumblr;
	}

	public function getShowTumblr()
	{
		return $this->showTumblr;
	}

	public function setShowTwitter($showTwitter)
	{
		$this->showTwitter = $showTwitter;
	}

	public function getShowTwitter()
	{
		return $this->showTwitter;
	}

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add photos
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\Photo $photos
     * @return PhotoEvent
     */
    public function addPhoto(\NickyDigital\PhotoboothBundle\Entity\Photo $photos)
    {
        $this->photos[] = $photos;
    
        return $this;
    }

    /**
     * Remove photos
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\Photo $photos
     */
    public function removePhoto(\NickyDigital\PhotoboothBundle\Entity\Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Add emails
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\Email $emails
     * @return PhotoEvent
     */
    public function addEmail(\NickyDigital\PhotoboothBundle\Entity\Email $emails)
    {
        $this->emails[] = $emails;
    
        return $this;
    }

    /**
     * Remove emails
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\Email $emails
     */
    public function removeEmail(\NickyDigital\PhotoboothBundle\Entity\Email $emails)
    {
        $this->emails->removeElement($emails);
    }

	public function setFolder($folder)
	{
		$this->folder = $folder;
	}

	public function getFolder()
	{
		return $this->folder;
	}

	public function setAlbumDesc($albumDesc)
	{
		$this->albumDesc = $albumDesc;
	}

	public function getAlbumDesc()
	{
		return $this->albumDesc;
	}

	public function setEmailShareSubject($emailShareSubject)
	{
		$this->emailShareSubject = $emailShareSubject;
	}

	public function getEmailShareSubject()
	{
		return $this->emailShareSubject;
	}

	public function setTumblrShareText($tumblrShareText)
	{
		$this->tumblrShareText = $tumblrShareText;
	}

	public function getTumblrShareText()
	{
		return $this->tumblrShareText;
	}

	public function setTumblrTags($tumblrTags)
	{
		$this->tumblrTags = $tumblrTags;
	}

	public function getTumblrTags()
	{
		return $this->tumblrTags;
	}

	
}