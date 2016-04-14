<?php

namespace Deviab\TransactionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * LenderDeviabTransaction
 *
 * @ORM\Table(name="lender_deviab_transactions")
 * @ORM\Entity
 */
class LenderDeviabTransaction
{
    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\LenderDetails", inversedBy="fromlenderTransactions")
     * @ORM\JoinColumn(name="lender_id", referencedColumnName="id")
     */
    private $lender;

    /**
     * @Groups({"profile"})
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\Project", inversedBy="toProjectLenderTransactions")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @var \DateTime
     *
     * @Groups({"profile","transactionPage"})
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var float
     *
     * @Groups({"profile","transactionPage"})
     * @ORM\Column(name="amount", type="float")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_id", type="string")
     */
    private $paymentId;

    /**
     * @var string
     *
     * @Groups({"transactionPage"})
     * @ORM\Column(name="merchant_transaction_id", type="string")
     */
    private $merchantTransactionId;
    
    /**
     * @var string
     * @Groups({"transactionPage"})
     * @ORM\Column(name="status", type="string",nullable=true)
     */
    private $status;
    
    /**
     * @var string
     *
     * @ORM\Column(name="payment_mode", type="string",nullable=true)
     */
    private $paymentMode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customer_email", type="string")
     */
    private $customerEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_phone", type="string")
     */
    private $customerPhone;
    
    /**
     * @var string
     *
     * @ORM\Column(name="customer_name", type="string")
     */
    private $customerName;
    
    /**
     * this field is for lenderId
     * @var string
     *
     * @ORM\Column(name="udf_1", type="string",nullable=true)
     */
    private $udf1;
    
    /**
     * @var string
     *
     * @ORM\Column(name="udf_2", type="string",nullable=true)
     */
    private $udf2;
    
    /**
     * this field is for projectId
     * @var string
     *
     * @ORM\Column(name="udf_3", type="string",nullable=true,nullable=true)
     */
    private $udf3;
    
    /**
     * @var string
     *
     * @ORM\Column(name="udf_4", type="string",nullable=true)
     */
    private $udf4;
    
    /**
     * @var string
     *
     * @ORM\Column(name="udf_5", type="string",nullable=true)
     */
    private $udf5;
    
    /**
     * @var string
     *
     * @Groups({"transactionPage"})
     * @ORM\Column(name="product_info", type="string",nullable=true)
     */
    private $productInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="additional_charges", type="string",nullable=true)
     */
    private $additionalCharges;

    /**
     * @var string
     *
     * @ORM\Column(name="split_info", type="string",nullable=true)
     */
    private $splitInfo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="error_message", type="string",nullable=true)
     */
    private $errorMessage;
    
    /**
     * @var string
     *
     * @ORM\Column(name="notification_id", type="string",nullable=true)
     */
    private $notificationId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string",nullable=true)
     */
    private $hash;


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
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return LenderDeviabTransaction
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return LenderDeviabTransaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * @param mixed $lender
     */
    public function setLender($lender)
    {
        $this->lender = $lender;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    public function getPaymentId()
    {
        return $this->paymentId;
    }

    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
        return $this;
    }

    public function getMerchantTransactionId()
    {
        return $this->merchantTransactionId;
    }

    public function setMerchantTransactionId($merchantTransactionId)
    {
        $this->merchantTransactionId = $merchantTransactionId;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getPaymentMode()
    {
        return $this->paymentMode;
    }

    public function setPaymentMode($paymentMode)
    {
        $this->paymentMode = $paymentMode;
        return $this;
    }

    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;    
        return $this;
    }

    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone($customerPhone)
    {
        $this->customerPhone = $customerPhone;    
        return $this;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;    
        return $this;
    }

    public function getUdf1()
    {
        return $this->udf1;
    }

    public function setUdf1($udf1)
    {
        $this->udf1 = $udf1;    
        return $this;
    }

    public function getUdf2()
    {
        return $this->udf2;
    }

    public function setUdf2($udf2)
    {
        $this->udf2 = $udf2;    
        return $this;
    }

    public function getUdf3()
    {
        return $this->udf3;
    }

    public function setUdf3($udf3)
    {
        $this->udf3 = $udf3;    
        return $this;
    }

    public function getUdf4()
    {
        return $this->udf4;
    }

    public function setUdf4($udf4)
    {
        $this->udf4 = $udf4;    
        return $this;
    }

    public function getUdf5()
    {
        return $this->udf5;
    }

    public function setUdf5($udf5)
    {
        $this->udf5 = $udf5;    
        return $this;
    }

    public function getProductInfo()
    {
        return $this->productInfo;
    }

    public function setproductInfo($productInfo)
    {
        $this->productInfo = $productInfo;    
        return $this;
    }

    public function getAdditionalCharges()
    {
        return $this->additionalCharges;
    }

    public function setadditionalCharges($additionalCharges)
    {
        $this->additionalCharges = $additionalCharges;    
        return $this;
    }

    public function getSplitInfo()
    {
        return $this->splitInfo;
    }

    public function setsplitInfo($splitInfo)
    {
        $this->splitInfo = $splitInfo;    
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;    
        return $this;
    }

    public function getNotificationId()
    {
        return $this->notificationId;
    }

    public function setNotificationId($notificationId)
    {
        $this->notificationId = $notificationId;    
        return $this;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;    
        return $this;
    }

}
