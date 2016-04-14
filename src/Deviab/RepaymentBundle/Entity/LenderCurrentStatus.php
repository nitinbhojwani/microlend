<?php

namespace Deviab\RepaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * LenderCurrentStatus
 *
 * @ORM\Table(name="lender_current_status")
 * @ORM\Entity
 */
class LenderCurrentStatus
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
     * @var \DateTime
     *
     * @Groups({"profile"})
     * @ORM\Column(name="timestamp", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $timestamp;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="principal_paid",type="integer",nullable=false,)
     */
    private $pricipalRepaid;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="interest_paid",type="integer",nullable=false,)
     */
    private $interestRepaid;
    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="pricipal_left",type="integer",nullable=false,)
     */
    private $pricipalLeft;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="tenure_left",type="integer",nullable=false,)
     */
    private $tenureLeft;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="interest_left",type="integer",nullable=false,)
     */
    private $interestLeft;

    /**
     * @var \Deviab\DatabaseBundle\Entity\LenderDetails
     *
     * @ORM\OneToOne(targetEntity="Deviab\DatabaseBundle\Entity\LenderDetails", inversedBy="currentStatus")
     * @ORM\JoinColumn(name="lender_id", referencedColumnName="id")
     */
    private $lender;

    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="expected_monthly_return",type="integer",nullable=false,)
     */
    private $expectedMonthlyReturn;


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
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int
     */
    public function getPricipalLeft()
    {
        return $this->pricipalLeft;
    }

    /**
     * @param int $pricipalLeft
     */
    public function setPricipalLeft($pricipalLeft)
    {
        $this->pricipalLeft = $pricipalLeft;
    }

    /**
     * @return int
     */
    public function getPricipalRepaid()
    {
        return $this->pricipalRepaid;
    }

    /**
     * @param int $pricipalRepaid
     */
    public function setPricipalRepaid($pricipalRepaid)
    {
        $this->pricipalRepaid = $pricipalRepaid;
    }

    /**
     * @return int
     */
    public function getTenureLeft()
    {
        return $this->tenureLeft;
    }

    /**
     * @param int $tenureLeft
     */
    public function setTenureLeft($tenureLeft)
    {
        $this->tenureLeft = $tenureLeft;
    }

    /**
     * @return int
     */
    public function getInterestLeft()
    {
        return $this->interestLeft;
    }

    /**
     * @param int $interestLeft
     */
    public function setInterestLeft($interestLeft)
    {
        $this->interestLeft = $interestLeft;
    }

    /**
     * @return int
     */
    public function getInterestRepaid()
    {
        return $this->interestRepaid;
    }

    /**
     * @param int $interestRepaid
     */
    public function setInterestRepaid($interestRepaid)
    {
        $this->interestRepaid = $interestRepaid;
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

    /**
     * @return int
     */
    public function getExpectedMonthlyReturn()
    {
        return $this->expectedMonthlyReturn;
    }

    /**
     * @param int $expectedMonthlyReturn
     */
    public function setExpectedMonthlyReturn($expectedMonthlyReturn)
    {
        $this->expectedMonthlyReturn = $expectedMonthlyReturn;
    }

    public function creditPrincipalLeft($amount)
    {
        $this->pricipalLeft += $amount;
    }

    public function debitPrincipalLeft($amount)
    {
        $this->pricipalLeft -= $amount;
    }

    public function creditInterrestLeft($amount)
    {
        $this->interestLeft += $amount;
    }

    public function debitInterrestLeft($amount)
    {
        $this->interestLeft -= $amount;
    }

    public function creditPricipalRepaid($amount)
    {
        $this->pricipalRepaid += $amount;
    }

    public function debitPricipalRepaid($amount)
    {
        $this->pricipalRepaid -= $amount;
    }

    public function creditInterestRepaid($amount)
    {
        $this->interestRepaid += $amount;
    }

    public function debitInterestRepaid($amount)
    {
        $this->interestRepaid -= $amount;
    }

    public function decrementTenure()
    {
        $this->tenureLeft -= 1;
    }

}