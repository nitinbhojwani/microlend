<?php

namespace Deviab\LoginBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Deviab\DatabaseBundle\Entity\LenderDetails;
use Deviab\RepaymentBundle\Entity\LenderCurrentStatus;
use Deviab\BorrowerBundle\Services\BaseService;
use Deviab\RepaymentBundle\Entity\LenderWallet;

class LenderService extends BaseService
{
    /**
     * @param Doctrine $doctrine
     */
    public function __construct( Doctrine $doctrine )
    {
        parent::__construct($doctrine);

        $this->doctrine = $doctrine;
    }

    public function addLenderDetail( $params = [] )
    {
        $lender = new LenderDetails();
        if (isset($params['fname'])) {
            $lender->setFname($params['fname']);
        }
        if (isset($params['lname'])) {
            $lender->setLname($params['lname']);
        }
        if (isset($params['address'])) {
            $lender->setAddress($params['address']);
        }
        if (isset($params['gender'])) {
            $lender->setGender($params['gender']);
        }
        if (isset($params['dob'])) {
            $lender->setDob($params['dob']);
        }
        if (isset($params['primary_mobile_number'])) {
            $lender->setPrimaryMobileNumber($params['primary_mobile_number']);
        }
        if (isset($params['profile_pic'])) {
            $lender->setProfilePic($params['profile_pic']);
        }
        if (isset($params['google_id'])) {
            $lender->setGoogleId($params['google_id']);
        }
        if (isset($params['facebook_id'])) {
            $lender->setFacebookId($params['facebook_id']);
        }
        if (isset($params['user'])) {
            $lender->setUser($params['user']);
        }

        $lenderCurrentStatus = new LenderCurrentStatus();
        $lenderCurrentStatus->setLender($lender);
        $lenderCurrentStatus->setTenureLeft(8);
        $lenderCurrentStatus->setTimestamp(new \DateTime());
        $lenderCurrentStatus->setPricipalRepaid(0);
        $lenderCurrentStatus->setInterestRepaid(0);
        $lenderCurrentStatus->setPricipalLeft(0);
        $lenderCurrentStatus->setInterestLeft(0);
        $lenderCurrentStatus->setExpectedMonthlyReturn(0);
        $lenderWallet = new LenderWallet();
        $lenderWallet->setLender($lender);
        $lenderWallet->setCredits(0);
        $this->em->persist($lenderCurrentStatus);
        $this->em->persist($lenderWallet);
        $this->em->persist($lender);
        $this->em->flush();

        return $lender;
    }
}
