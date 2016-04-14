<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * MasterDistrict
 *
 * @ORM\Table(name="master_district", indexes={@ORM\Index(name="fk_state_id_idx", columns={"state_id"})})
 * @ORM\Entity
 */
class MasterDistrict
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
     * @var string
     * @Groups({"borrower_portfolio"})
     * @ORM\Column(name="district_name", type="string", length=45, nullable=false)
     */
    private $districtName;

    /**
     * @var \Deviab\DatabaseBundle\Entity\MasterStates
     * @Groups({"borrower_portfolio"})
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\MasterStates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     * })
     */
    private $state;


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
     * Get districtName
     *
     * @return string
     */
    public function getDistrictName()
    {
        return $this->districtName;
    }

    /**
     * Set districtName
     *
     * @param string $districtName
     * @return MasterDistrict
     */
    public function setDistrictName($districtName)
    {
        $this->districtName = $districtName;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Deviab\DatabaseBundle\Entity\MasterStates
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set state
     *
     * @param \Deviab\DatabaseBundle\Entity\MasterStates $state
     * @return MasterDistrict
     */
    public function setState(\Deviab\DatabaseBundle\Entity\MasterStates $state = null)
    {
        $this->state = $state;

        return $this;
    }
}
