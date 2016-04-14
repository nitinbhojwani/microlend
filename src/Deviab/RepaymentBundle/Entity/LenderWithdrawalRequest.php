<?php

namespace Deviab\RepaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * LenderWithdrawalRequest
 *
 * @ORM\Table(name="lender_withdrawal_requests")
 * @ORM\Entity
 */
class LenderWithdrawalRequest
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
     * @ORM\JoinColumn(name="lender_id", referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\LenderDetails", inversedBy="withdrawal_requests")
     */
    private $lender;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="requested_at", type="datetime")
     */
    private $requestedAt;

    /**
     * @var string
     * @ORM\Column(name="account_number", type="string", length=250, nullable=true)
    */
    private $accountNumber;

    /**
     * @var string
     * @ORM\Column(name="ifsc_code", type="string", length=250, nullable=true)
    */
    private $ifscCode;

    /**
     * @var string
     * @ORM\Column(name="account_name", type="string", length=250, nullable=true)
    */
    private $accountName;

    /**
     * @var string
     * @ORM\Column(name="bank_name", type="string", length=250, nullable=true)
    */
    private $bankName;

    /**
     * @var string
     * @ORM\Column(name="status", type="string", length=250, nullable=true)
    */
    private $status;



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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * @param int $lender
     */
    public function setLender($lender)
    {
        $this->lender = $lender;
    }

    /**
     * Get requestedAt
     *
     * @return \DateTime
     */
    public function getRequestedAt()
    {
        return $this->requestedAt;
    }

    /**
     * Set requestedAt
     *
     * @param \DateTime $requestedAt
     */
    public function setRequestedAt($requestedAt)
    {
        $this->requestedAt = $requestedAt;
    }

    /**
     * Get ifscCode
     *
     * @return string
     */
    public function getIfscCode()
    {
        return $this->ifscCode;
    }

    /**
     * Set ifscCode
     *
     * @param string $ifscCode
     */
    public function setIfscCode($ifscCode)
    {
        $this->ifscCode = $ifscCode;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set accountNumber
     *
     * @param string $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    /**
     * Get accountName
     *
     * @return string
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * Set accountName
     *
     * @param string $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
    }

    /**
     * Get bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Set bankName
     *
     * @param string $bankName
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


}
