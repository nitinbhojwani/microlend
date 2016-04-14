<?php

namespace Deviab\LoginBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Deviab\DatabaseBundle\Entity\LenderDetails;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank(groups={"Registration", "Profile"})
     */
    // protected $username;

    /**
     * @Groups({"profile"})
     * @Assert\NotBlank(groups={"Registration", "Profile"})
     */
    protected $email;

    /**
     * @Assert\NotBlank(groups={"Registration", "Profile"})
     */
    protected $password;

    /**
     * @Groups({"profile"})
     * @ORM\OneToOne(targetEntity="Deviab\DatabaseBundle\Entity\LenderDetails", mappedBy="user", cascade={"persist"})
     */
    private $lender;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        // $this->lender = new LenderDetails();
    }

    /**
     * Get lender
     *
     * @return LenderDetails
     */
    public function getLender()
    {
        return $this->lender;
    }

    /**
     * Set lender
     *
     * @param LenderDetails $lender
     * @return User
     */
    public function setlender($lender)
    {
        $this->lender = $lender;

        return $this;
    }
}