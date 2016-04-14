<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 19/09/15
 * Time: 1:08 AM
 */

namespace Deviab\RepaymentBundle\Services;

use Deviab\TransactionBundle\Entity\DeviabLenderTransaction;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;
use Deviab\BorrowerBundle\Services\BaseService;

class RepaymentService extends BaseService
{
    /**
     * @param Doctrine $doctrine
     */
    public function __construct( Doctrine $doctrine )
    {
        parent::__construct($doctrine);

        $this->doctrine = $doctrine;
    }

    public function lenderRepayment( $TMR )
    {

        $projectRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:Project');
        $project = $projectRepository->find(1);
        if ($project == null)
            return View::create("project not found", Codes::HTTP_BAD_REQUEST);
        $lenderRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lenders = $lenderRepository->findAll();
        $totalEMR = 0;
        foreach ($lenders as $lender) {
            $totalEMR += $lender->getCurrentStatus()->getExpectedMonthlyReturn();
        }
        if (!$totalEMR)
            return View::create("project ended", Codes::HTTP_BAD_REQUEST);
        foreach ($lenders as $lender) {
            $EMR = $lender->getCurrentStatus()->getExpectedMonthlyReturn();
            $AMR = $EMR * $TMR / $totalEMR;
            $lender->getWallet()->credit($AMR);
            $this->em->merge($lender->getWallet());
            $pl = $lender->getCurrentStatus()->getPricipalLeft();
            $il = $lender->getCurrentStatus()->getInterestLeft();
            if ($AMR <= $il) {
                $il = $il - $AMR + $pl * 0.6 / 100;
                $lender->getCurrentStatus()->setInterestLeft($il);
                $lender->getCurrentStatus()->decrementTenure();
                $lender->getCurrentStatus()->creditInterestRepaid($AMR);
            } else {
                $pl = $pl - $AMR + $il;
                $lender->getCurrentStatus()->setInterestLeft($pl * 0.6 / 100);
                $lender->getCurrentStatus()->setPricipalLeft($pl);
                $lender->getCurrentStatus()->creditInterestRepaid($il);
                $lender->getCurrentStatus()->creditPricipalRepaid($AMR - $il);
                $lender->getCurrentStatus()->decrementTenure();
            }
            if ($lender->getCurrentStatus()->getTenureLeft() < 1) {
                $EMR = $this->getEMR($lender->getCurrentStatus());
                $lender->getCurrentStatus()->setExpectedMonthlyReturn($EMR);
            } else {
                $lender->getCurrentStatus()->setExpectedMonthlyReturn(0);
            }
            $deviabLenderTransaction = new DeviabLenderTransaction();
            $deviabLenderTransaction->setAmount($AMR);
            $deviabLenderTransaction->setLender($lender);
            $deviabLenderTransaction->setProject($project);
            $deviabLenderTransaction->setTimestamp(new \DateTime());
            $deviabLenderTransaction->setTxnid(uniqid($lender->getFname() + $AMR + date("Y-m-d H:i:s")));
            $this->em->persist($deviabLenderTransaction);
            $this->em->merge($lender->getCurrentStatus());
            $this->em->merge($lender);

        }
        $this->em->flush();
        return View::create("Repaid AMR  and Lender Current Status updated", Codes::HTTP_OK);

    }

    public function getEMR( $EntitycurrentStatus )
    {
        $pl = $EntitycurrentStatus->getPricipalLeft();
        $il = $EntitycurrentStatus->getInterestLeft();
        $tl = $EntitycurrentStatus->getTenureLeft();
        $EMR = $pl / $tl + $il;
        return $EMR;
    }


}