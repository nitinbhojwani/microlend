<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * MasterStates
 *
 * @ORM\Table(name="master_states")
 * @ORM\Entity
 */
class MasterStates
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
     * @ORM\Column(name="state_name", type="string", length=45, nullable=false)
     */
    private $stateName;


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
     * Get stateName
     *
     * @return string
     */
    public function getStateName()
    {
        return $this->stateName;
    }

    /**
     * Set stateName
     *
     * @param string $stateName
     * @return MasterStates
     */
    public function setStateName($stateName)
    {
        $this->stateName = $stateName;

        return $this;
    }
}
