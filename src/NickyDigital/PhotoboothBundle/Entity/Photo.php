<?php

namespace NickyDigital\PhotoboothBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Photo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Photo
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
	 * @ORM\ManyToOne(targetEntity="PhotoEvent", inversedBy="photos")
	 */
	private $event;

	/**
	 * @ORM\Column(type="string", length=200)
	 */
	protected $filename;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $missing;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	protected $deleted;
	

	/**
	 * @var datetime $created
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
	 * @ORM\OneToMany(targetEntity="FacebookShare", mappedBy="photo")
	 */
	protected $facebookShares;

	public function setCreated($created)
	{
		$this->created = $created;
	}

	public function getCreated()
	{
		return $this->created;
	}

	public function setDeleted($deleted)
	{
		$this->deleted = $deleted;
	}

	public function getDeleted()
	{
		return $this->deleted;
	}

	public function setEvent($event)
	{
		$this->event = $event;
	}

	public function getEvent()
	{
		return $this->event;
	}

	public function setFacebookShares($facebookShares)
	{
		$this->facebookShares = $facebookShares;
	}

	public function getFacebookShares()
	{
		return $this->facebookShares;
	}

	public function setFilename($filename)
	{
		$this->filename = $filename;
	}

	public function getFilename()
	{
		return $this->filename;
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

	public function setMissing($missing)
	{
		$this->missing = $missing;
	}

	public function getMissing()
	{
		return $this->missing;
	}

	/**
	 * @param $updated
	 */
	public function setUpdated($updated)
	{
		$this->updated = $updated;
	}

	/**
	 * @return 
	 */
	public function getUpdated()
	{
		return $this->updated;
	}

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facebookShares = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add facebookShares
     *
     * @param \NickyDigital\PhotoboothBundle\Entity\FacebookShare $facebookShares
     * @return Photo
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
}