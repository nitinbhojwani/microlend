<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * MasterPanchayat
 *
 * @ORM\Table(name="master_panchayat", indexes={@ORM\Index(name="fk_block_id_idx", columns={"block_id"})})
 * @ORM\Entity
 */
class MasterPanchayat
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
     * @ORM\Column(name="panchayat_name", type="string", length=45, nullable=false)
     */
    private $panchayatName;

    /**
     * @var \Deviab\DatabaseBundle\Entity\MasterBlock
     * @Groups({"borrower_portfolio"})
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\MasterBlock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="block_id", referencedColumnName="id")
     * })
     */
    private $block;


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
     * Get panchayatName
     *
     * @return string
     */
    public function getPanchayatName()
    {
        return $this->panchayatName;
    }

    /**
     * Set panchayatName
     *
     * @param string $panchayatName
     * @return MasterPanchayat
     */
    public function setPanchayatName($panchayatName)
    {
        $this->panchayatName = $panchayatName;

        return $this;
    }

    /**
     * Get block
     *
     * @return \Deviab\DatabaseBundle\Entity\MasterBlock
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * Set block
     *
     * @param \Deviab\DatabaseBundle\Entity\MasterBlock $block
     * @return MasterPanchayat
     */
    public function setBlock(\Deviab\DatabaseBundle\Entity\MasterBlock $block = null)
    {
        $this->block = $block;

        return $this;
    }
}
