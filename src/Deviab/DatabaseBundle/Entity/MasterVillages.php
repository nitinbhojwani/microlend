<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * MasterVillages
 *
 * @ORM\Table(name="master_villages", indexes={@ORM\Index(name="fk_panchayat_id_idx", columns={"panchayat_id"})})
 * @ORM\Entity
 */
class MasterVillages
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
     * @ORM\Column(name="village_name", type="string", length=45, nullable=true)
     */
    private $villageName;

    /**
     * @Groups({"borrower_portfolio"})
     * @var \Deviab\DatabaseBundle\Entity\MasterPanchayat
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\MasterPanchayat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="panchayat_id", referencedColumnName="id")
     * })
     */
    private $panchayat;


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
     * Get villageName
     *
     * @return string
     */
    public function getVillageName()
    {
        return $this->villageName;
    }

    /**
     * Set villageName
     *
     * @param string $villageName
     * @return MasterVillages
     */
    public function setVillageName($villageName)
    {
        $this->villageName = $villageName;

        return $this;
    }

    /**
     * Get panchayat
     *
     * @return \Deviab\DatabaseBundle\Entity\MasterPanchayat
     */
    public function getPanchayat()
    {
        return $this->panchayat;
    }

    /**
     * Set panchayat
     *
     * @param \Deviab\DatabaseBundle\Entity\MasterPanchayat $panchayat
     * @return MasterVillages
     */
    public function setPanchayat(\Deviab\DatabaseBundle\Entity\MasterPanchayat $panchayat = null)
    {
        $this->panchayat = $panchayat;

        return $this;
    }
}
