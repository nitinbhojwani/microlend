<?php

namespace Deviab\DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Deviab\DatabaseBundle\Entity\BorrowerDetails;
use JMS\Serializer\Annotation\Groups;

/**
 * Project
 *
 * @ORM\Table(name="projects")
 * @ORM\Entity
 */
class Project
{
    /**
     * @var integer
     *
     * @Groups({"profile"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="DeviabLenderTransaction", mappedBy="project")
     */
    private $fromProjectLenderTransactions;

    /**
     * @ORM\OneToMany(targetEntity="LenderDeviabTransaction", mappedBy="project")
     */
    private $toProjectLenderTransactions;

    /**
     * @ORM\OneToMany(targetEntity="BorrowerDetails", mappedBy="project")
     */
    private $borrowers;

    /**
     * @Groups({"profile"})
     * @Groups({"project_portfolio"})
     * @ORM\Column(name="capital_amount", type="float")
     */
    private $capitalAmount;

    public function __construct()
    {
        $this->borrowers = new ArrayCollection();
        $this->fromProjectLenderTransactions = new ArrayCollection();
        $this->toProjectLenderTransactions = new ArrayCollection();
    }

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
     * @return mixed
     */
    public function getFromProjectLenderTransactions()
    {
        return $this->fromProjectLenderTransactions;
    }

    /**
     * @param mixed $fromProjectLenderTransactions
     */
    public function setFromProjectLenderTransactions($fromProjectLenderTransactions)
    {
        $this->fromProjectLenderTransactions = $fromProjectLenderTransactions;
    }

    /**
     * @return mixed
     */
    public function getToProjectLenderTransactions()
    {
        return $this->toProjectLenderTransactions;
    }

    /**
     * @param mixed $toProjectLenderTransactions
     */
    public function setToProjectLenderTransactions($toProjectLenderTransactions)
    {
        $this->toProjectLenderTransactions = $toProjectLenderTransactions;
    }

    /**
     * @return mixed
     */
    public function getBorrowers()
    {
        return $this->borrowers;
    }

    /**
     * @param mixed $borrowers
     */
    public function setBorrowers($borrowers)
    {
        $this->borrowers = $borrowers;
    }

    /**
     * @return mixed
     */
    public function getCapitalAmount()
    {
        return $this->capitalAmount;
    }

    /**
     * @param $amount
     */
    public function creditCapitalAmount($amount)
    {
        $this->capitalAmount += $amount;
    }

    /**
     * @param $amount
     */
    public function debitCapitalAmount($amount)
    {
        $this->capitalAmount -= $amount;
    }


    /**
     * Add Borrower
     *
     * @param BorrowerDetails $borrower
     */
    public function addBorrower(BorrowerDetails $borrower)
    {
        $this->borrowers[] = $borrower;
    }


    /**
     * Remove Borrower
     *
     * @param BorrowerDetails $borrower
     */
    public function removeBorrower(BorrowerDetails $borrower)
    {
        $this->borrowers->removeElement($borrower);
    }


}