<?php

namespace Deviab\RepaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * LenderWallet
 *
 * @ORM\Table(name="lender_wallet")
 * @ORM\Entity
 */
class LenderWallet
{
    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="credits", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $credits;

    /**
     * @var \Deviab\DatabaseBundle\Entity\LenderDetails
     *
     * @ORM\OneToOne(targetEntity="Deviab\DatabaseBundle\Entity\LenderDetails", inversedBy="wallet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lender_id", referencedColumnName="id", unique=true, nullable=true)
     * })
     */
    private $lender;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * @param int $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    /**
     * @return \Deviab\DatabaseBundle\Entity\LenderDetails
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * @param \Deviab\DatabaseBundle\Entity\LenderDetails $lender
     */
    public function setLender($lender)
    {
        $this->lender = $lender;
    }

    public function credit($amount)
    {
        $this->credits += $amount;
    }

    public function debit($amount)
    {
        $this->credits -= $amount;
    }
}
