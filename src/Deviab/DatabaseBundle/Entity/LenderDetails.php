<?php

namespace Deviab\DatabaseBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use Deviab\TransactionBundle\Entity\DeviabLenderTransaction;
use Deviab\TransactionBundle\Entity\BorrowerDeviabTransaction;
use Deviab\RepaymentBundle\Entity\LenderCurrentStatus;
use Deviab\RepaymentBundle\Entity\LenderWallet;
use Deviab\LoginBundle\Entity\User;

/**
 * LenderDetails
 *
 * @ORM\Table(name="lender_details")
 * @ORM\Entity
 */
class LenderDetails
{
    /**
     * @var integer
     * @Groups({"featured_project_portfolio", "profile"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Groups({"profile"})
     * @ORM\Column(name="fname", type="string", length=45, nullable=false)
     */
    private $fname;

    /**
     * @var string
     * @ORM\Column(name="lname", type="string", length=45, nullable=false)
     */
    private $lname;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=45, nullable=true)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="gender", type="string", length=10, nullable=false)
     */
    private $gender;

    /**
     * @var \DateTime
     * @ORM\Column(name="dob", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @Groups({"profile"})
     * @ORM\Column(name="primary_mobile_number", type="string", length=45, nullable=false)
     */
    private $primaryMobileNumber;

    /**
     * @var string
     * @ORM\Column(name="profile_pic", type="string", length=255, nullable=false)
     */
    private $profilePic;

    /**
     * @var string
     * @ORM\Column(name="google_id", type="string", length=45, nullable=true)
     */
    private $googleId;

    /**
     * @var string
     * @ORM\Column(name="facebook_id", type="string", length=45, nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\OneToMany(targetEntity="DeviabLenderTransaction", mappedBy="lender")
     */
    private $toLenderTransactions;

    /**
     * @ORM\OneToMany(targetEntity="LenderDeviabTransaction", mappedBy="lender")
     */
    private $fromLenderTransactions;

    /**
     * @ORM\OneToOne(targetEntity="LenderCurrentStatus", mappedBy="lender")
     */
    private $currentStatus;

    /**
     * @ORM\OneToOne(targetEntity="LenderWallet", mappedBy="lender")
     */
    private $wallet;

    /**
     * @var Deviab\LoginBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="User", inversedBy="lender")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true, nullable=false)
     * })
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="LenderWithdrawalRequest", mappedBy="lender")
     */
    private $withdrawalRequests;

    public function __construct()
    {
        $this->fromLenderTransactions = new ArrayCollection();
        $this->toLenderTransactions = new ArrayCollection();
        $this->withdrawalRequests = new ArrayCollection();
        // $this->wallet = new LenderWallet();
        // $this->currentStatus = new LenderCurrentStatus();
    }

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
     * Get fname
     *
     * @return string
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return LenderDetails
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return LenderDetails
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return LenderDetails
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return LenderDetails
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     * @return LenderDetails
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get primaryMobileNumber
     *
     * @return string
     */
    public function getPrimaryMobileNumber()
    {
        return $this->primaryMobileNumber;
    }

    /**
     * Set primaryMobileNumber
     *
     * @param string $primaryMobileNumber
     * @return LenderDetails
     */
    public function setPrimaryMobileNumber($primaryMobileNumber)
    {
        $this->primaryMobileNumber = $primaryMobileNumber;

        return $this;
    }

    /**
     * Get profilePic
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    /**
     * Set profilePic
     *
     * @param string $profilePic
     * @return LenderDetails
     */
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     * @return LenderDetails
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return LenderDetails
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * @return LenderCurrentStatus
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @param LenderCurrentStatus $currentStatus
     * @internal param $LenderCurrentStatus
     */
    public function setCurrentStatus(LenderCurrentStatus $currentStatus)
    {
        $this->currentStatus = $currentStatus;
    }

    /**
     * Get wallet
     *
     * @return LenderWallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * Set wallet
     *
     * @param LenderWallet $wallet
     * @return LenderDetails
     */
    public function setWallet($wallet)
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToLenderTransactions()
    {
        return $this->toLenderTransactions;
    }

    /**
     * @return mixed
     */
    public function getWithdrawalRequests()
    {
        return $this->withdrawalRequests;
    }

    /**
     * @return mixed
     */
    public function getFromLenderTransactions()
    {
        return $this->fromLenderTransactions;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return LenderDetails
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

}
