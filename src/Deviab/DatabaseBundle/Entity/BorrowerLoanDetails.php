<?php

namespace Deviab\DatabaseBundle\Entity;

use Deviab\DatabaseBundle\Entity\BorrowerDetails;
use Deviab\DatabaseBundle\Entity\LoanOperationalStrategies;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;


/**
 * BorrowerLoanDetails
 *
 * @ORM\Table(name="borrower_loan_details", indexes={@ORM\Index(name="fk_borrower_id_idx", columns={"borrower_id"}), @ORM\Index(name="fk_operational_id_idx", columns={"operational_strategy_id"})})
 * @ORM\Entity
 */
class BorrowerLoanDetails
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
     * @Groups({"project_portfolio"})
     * @ORM\Column(name="user_story", type="text", nullable=true)
     */
    private $userStory;

    /**
     * @var BorrowerDetails
     *
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\BorrowerDetails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="borrower_id", referencedColumnName="id")
     * })
     */
    private $borrower;

    /**
     * @var LoanOperationalStrategies
     * @Groups({"borrower_portfolio"})
     * @ORM\ManyToOne(targetEntity="Deviab\DatabaseBundle\Entity\LoanOperationalStrategies")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operational_strategy_id", referencedColumnName="id")
     * })
     */
    private $operationalStrategy;

    /**
     * @ORM\Column(name="amount_raised", type="double", nullable=true)
     * @Groups({"borrower_portfolio"})
     */
    private $amountRaised;

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
     * @return string
     */
    public function getUserStory()
    {
        return $this->userStory;
    }

    /**
     * @param string $userStory
     */
    public function setUserStory($userStory)
    {
        $this->userStory = $userStory;
    }

    /**
     * @return \Deviab\DatabaseBundle\Entity\BorrowerDetails
     */
    public function getBorrower()
    {
        return $this->borrower;
    }

    /**
     * @param \Deviab\DatabaseBundle\Entity\BorrowerDetails $borrower
     */
    public function setBorrower($borrower)
    {
        $this->borrower = $borrower;
    }

    /**
     * @return \Deviab\DatabaseBundle\Entity\LoanOperationalStrategies
     */
    public function getOperationalStrategy()
    {
        return $this->operationalStrategy;
    }

    /**
     * @param \Deviab\DatabaseBundle\Entity\LoanOperationalStrategies $operationalStrategy
     */
    public function setOperationalStrategy($operationalStrategy)
    {
        $this->operationalStrategy = $operationalStrategy;
    }

    /**
     * @return mixed
     */
    public function getAmountRaised()
    {
        return $this->amountRaised;
    }

    /**
     * @param mixed $amountRaised
     */
    public function setAmountRaised($amountRaised)
    {
        $this->amountRaised = $amountRaised;
    }


}
