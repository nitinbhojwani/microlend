<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * BorrowerImages
 *
 * @ORM\Table(name="borrower_images", indexes={@ORM\Index(name="fk_borrower_id_idx", columns={"borrower_id"})})
 * @ORM\Entity
 */
class BorrowerImages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_profile_pic", type="boolean", nullable=false)
     */
    private $isProfilePic;

    /**
     * @var string
     * @Groups({"borrower_portfolio","project_portfolio"})
     * @ORM\Column(name="image_url", type="string", length=255, nullable=false)
     */
    private $imageUrl;

    /**
     * @var \Deviab\DatabaseBundle\Entity\BorrowerDetails
     *
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\BorrowerDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="borrower_id", referencedColumnName="id")
     * })
     */
    private $borrower;


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
     * Get isProfilePic
     *
     * @return boolean
     */
    public function getIsProfilePic()
    {
        return $this->isProfilePic;
    }

    /**
     * Set isProfilePic
     *
     * @param boolean $isProfilePic
     * @return BorrowerImages
     */
    public function setIsProfilePic($isProfilePic)
    {
        $this->isProfilePic = $isProfilePic;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return BorrowerImages
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get borrower
     *
     * @return \Deviab\DatabaseBundle\Entity\BorrowerDetails
     */
    public function getBorrower()
    {
        return $this->borrower;
    }

    /**
     * Set borrower
     *
     * @param \Deviab\DatabaseBundle\Entity\BorrowerDetails $borrower
     * @return BorrowerImages
     */
    public function setBorrower(\Deviab\DatabaseBundle\Entity\BorrowerDetails $borrower = null)
    {
        $this->borrower = $borrower;

        return $this;
    }
}
