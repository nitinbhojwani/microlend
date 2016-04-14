<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * MasterBlock
 *
 * @ORM\Table(name="master_block", indexes={@ORM\Index(name="fk_district_id_idx", columns={"district_id"})})
 * @ORM\Entity
 */
class MasterBlock
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
     *
     * @ORM\Column(name="block_name", type="string", length=45, nullable=false)
     */
    private $blockName;

    /**
     * @var \Deviab\DatabaseBundle\Entity\MasterDistrict
     * @Groups({"borrower_portfolio"})
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\MasterDistrict")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     * })
     */
    private $district;


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
     * Get blockName
     *
     * @return string
     */
    public function getBlockName()
    {
        return $this->blockName;
    }

    /**
     * Set blockName
     *
     * @param string $blockName
     * @return MasterBlock
     */
    public function setBlockName($blockName)
    {
        $this->blockName = $blockName;

        return $this;
    }

    /**
     * Get district
     *
     * @return \Deviab\DatabaseBundle\Entity\MasterDistrict
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set district
     *
     * @param \Deviab\DatabaseBundle\Entity\MasterDistrict $district
     * @return MasterBlock
     */
    public function setDistrict(\Deviab\DatabaseBundle\Entity\MasterDistrict $district = null)
    {
        $this->district = $district;

        return $this;
    }
}
