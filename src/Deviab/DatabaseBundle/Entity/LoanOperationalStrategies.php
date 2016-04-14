<?php

namespace Deviab\DatabaseBundle\Entity;

use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * LoanOperationalStrategies
 *
 * @ORM\Table(name="loan_operational_strategies")
 * @ORM\Entity
 */
class LoanOperationalStrategies
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
     * @var float
     * @Groups({"borrower_portfolio"})
     * @ORM\Column(name="principal_amount", type="float", precision=10, scale=0, nullable=false)
     */
    private $principalAmount;

    /**
     * @var integer
     * @Groups({"borrower_portfolio"})
     * @ORM\Column(name="tenure", type="integer", nullable=false)
     */
    private $tenure;

    /**
     * @var float
     * @Groups({"borrower_portfolio"})
     * @ORM\Column(name="rate_of_interrest", type="float", precision=10, scale=0, nullable=false)
     */
    private $rateOfInterrest;

    /**
     * @var \DateTime
     * @Groups({"borrower_portfolio"})
     * @ORM\Column(name="campaign_date", type="date", nullable=false)
     */
    private $campaignDate;


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
     * Get principalAmount
     *
     * @return float
     */
    public function getPrincipalAmount()
    {
        return $this->principalAmount;
    }

    /**
     * Set principalAmount
     *
     * @param float $principalAmount
     * @return LoanOperationalStrategies
     */
    public function setPrincipalAmount($principalAmount)
    {
        $this->principalAmount = $principalAmount;

        return $this;
    }

    /**
     * Get tenure
     *
     * @return integer
     */
    public function getTenure()
    {
        return $this->tenure;
    }

    /**
     * Set tenure
     *
     * @param integer $tenure
     * @return LoanOperationalStrategies
     */
    public function setTenure($tenure)
    {
        $this->tenure = $tenure;

        return $this;
    }

    /**
     * Get rateOfInterrest
     *
     * @return float
     */
    public function getRateOfInterrest()
    {
        return $this->rateOfInterrest;
    }

    /**
     * Set rateOfInterrest
     *
     * @param float $rateOfInterrest
     * @return LoanOperationalStrategies
     */
    public function setRateOfInterrest($rateOfInterrest)
    {
        $this->rateOfInterrest = $rateOfInterrest;

        return $this;
    }

    /**
     * Get campaignDate
     *
     * @return \DateTime
     */
    public function getCampaignDate()
    {
        return $this->campaignDate;
    }

    /**
     * Set campaignDate
     *
     * @param \DateTime $campaignDate
     * @return LoanOperationalStrategies
     */
    public function setCampaignDate($campaignDate)
    {
        $this->campaignDate = $campaignDate;

        return $this;
    }
}
