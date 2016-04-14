<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 17/09/15
 * Time: 4:47 PM
 */

namespace Deviab\TransactionBundle\Services;

use Deviab\TransactionBundle\Entity\DeviabBorrowerTransaction;
use Deviab\TransactionBundle\Entity\DeviabLenderTransaction;
use Deviab\TransactionBundle\Entity\LenderDeviabTransaction;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Doctrine\ORM\Query\ResultSetMapping;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;
use Deviab\BorrowerBundle\Services\BaseService;
use Symfony\Component\HttpFoundation\Request;

class InvestmentService extends BaseService
{
    /**
     * @param Doctrine $doctrine
     */
    public function __construct( Doctrine $doctrine )
    {
        parent::__construct($doctrine);

        $this->doctrine = $doctrine;
    }

    public function getLenderInvestment( $lenderId )
    {
        $lenderRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lender = $lenderRepository->find($lenderId);
        if ($lender != null) {
            $expectedMonthlyReturn = $lender->getCurrentStatus()->getExpectedMonthlyReturn();
            $lenderWalletBalance = $lender->getWallet()->getCredits();
            $lenderInvestments = $lender->getFromLenderTransactions();
            $lenderReturns = $lender->getToLenderTransactions();
            $principalRepayment = $lender->getCurrentStatus()->getPricipalRepaid();
            $interestRepayment = $lender->getCurrentStatus()->getInterestRepaid();
            $amountWithdrawn = 0;
            $totalInvestment = 0;
            foreach ($lenderInvestments as $transaction) {
                if ($transaction->getStatus() == "success" || $transaction->getStatus() == "Release Payment")
                    $totalInvestment = $totalInvestment + $transaction->getAmount();
            }
            $totalReturns = 0;
            foreach ($lenderReturns as $return) {
                $totalReturns = $totalReturns + $return->getAmount();
            }
            $dlts = $lender->getToLenderTransactions();
            $ldts = $lender->getFromLenderTransactions();
            $transactions = [];
            foreach ($dlts as $dlt)
                array_push($transactions, array('timestamp' => $dlt->getTimestamp()->format('U'), 'type' => "debit", 'amount' => $dlt->getAmount(), 'txnid' => $dlt->getTxnid()));
            foreach ($ldts as $ldt)
                array_push($transactions, array('timestamp' => $ldt->getTimestamp()->format('U'), 'type' => "debit", 'amount' => $ldt->getAmount(), 'txnid' => $ldt->getMerchantTransactionId()));
            $timestamp = array();
            foreach ($transactions as $key => $row) {
                $timestamp[$key] = $row['timestamp'];
            }
            array_multisort($timestamp, SORT_ASC, $transactions);
            $response = array('lenderWalletBalance' => $lenderWalletBalance, 'totalInvestment' => $totalInvestment, 'totalReturns' => $totalReturns, 'expectedMonthlyReturn' => $expectedMonthlyReturn, 'principalRepayment' => $principalRepayment, 'interestRepayment' => $interestRepayment, 'amountWithdrawn' => $amountWithdrawn, 'transactions' => $transactions);
            return View::create($response, Codes::HTTP_OK);
        }
        return View::create("lender not found", Codes::HTTP_BAD_REQUEST);
    }

}


