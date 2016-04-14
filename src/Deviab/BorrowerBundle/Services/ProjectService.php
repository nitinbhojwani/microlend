<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 19/09/15
 * Time: 9:56 AM
 */

namespace Deviab\BorrowerBundle\Services;

use Deviab\TransactionBundle\Entity\LenderDeviabTransaction;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class ProjectService extends BaseService
{
    /**
     * @param Doctrine $doctrine
     */
    public function __construct( Doctrine $doctrine, $mailer )
    {
        parent::__construct($doctrine);

        $this->doctrine = $doctrine;
        $this->mailer = $mailer;
    }

    /**
     * @param $projectId
     * @return View
     */
    public function getProjectStatus( $projectId )
    {
        $projectRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:Project');
        $project = $projectRepository->find($projectId);
        if ($project == null)
            return View::create("project not found", Codes::HTTP_BAD_REQUEST);
        $quantum = $project->getCapitalAmount();
        $query = $this->em->createQueryBuilder();
        $fields = array('(ldt.lender)');
        $query
            ->select($fields)
            ->from('DeviabTransactionBundle:LenderDeviabTransaction', 'ldt')
            ->where('ldt.status = :x')
            ->orWhere('ldt.status = :y')
            ->setParameter('y', 'success')
            ->setParameter('x', 'release payment')->distinct();
        $lenders = $query->getQuery()->getArrayResult();
        $lenderIds = [];
        foreach ($lenders as $lender) {
            array_push($lenderIds, $lender['1']);
        }
        $lenderRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lenders = $lenderRepository->findById($lenderIds);;
        $names = [];
        foreach ($lenders as $lender) {
            $dic['name'] = $lender->getFname();
            $dic['url'] = $lender->getProfilePic();
            array_push($names, $dic);
        }
        $response = array('quantum' => $quantum, 'lenders' => $names);
        return View::create($response, Codes::HTTP_OK);
    }


    /**
     * @param $projectId
     * @return View
     */
    public function getFeaturedProject( $projectId )
    {
        $projectRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:Project');
        $project = $projectRepository->find($projectId);
        if ($project == null)
            return View::create("project not found", Codes::HTTP_BAD_REQUEST);
        $quantum = $project->getCapitalAmount();
        $query = $this->em->createQueryBuilder();
        $fields = array('IDENTITY(ldt.lender)');
        $query
            ->select($fields)
            ->from('DeviabTransactionBundle:LenderDeviabTransaction', 'ldt')
            ->where('ldt.status = :x')
            ->orWhere('ldt.status = :y')
            ->setParameter('y', 'success')
            ->setParameter('x', 'release payment')->distinct();
        $ldts = $query->getQuery()->getResult();
        $response = array('quantum' => $quantum, 'backers' => count($ldts));
        return View::create($response, Codes::HTTP_OK);
    }

    public function capturePayUTransaction( Request $request )
    {
        if ($request != null) {
            $secret = $request->headers->get('secret');
            if ($secret != "Ppeu7e;}]B)xgWq[*E4@$??B3~t.&G")
                return View::create("hackers not allowed", Codes::HTTP_BAD_REQUEST);
            $request = $request->getContent();
            $request = json_decode($request, true);
            $lenderId = $request['udf1'];
            $projectId = $request["udf2"];
            $amount = $request["amount"];
            $status = $request["status"];
            $lenderRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:LenderDetails');
            $lender = $lenderRepository->find($lenderId);
            $projectRepository = $this->doctrine->getRepository('DeviabDatabaseBundle:project');
            $project = $projectRepository->find($projectId);
            $lenderDeviabTransaction = new LenderDeviabTransaction();
            $lenderDeviabTransaction->setLender($lender);
            $lenderDeviabTransaction->setStatus($status);
            if ($status == "failed")
            $lenderDeviabTransaction->setErrorMessage($request["error_message"]);
            $lenderDeviabTransaction->setProject($project);
            $lenderDeviabTransaction->setAmount($amount);
            $lenderDeviabTransaction->setTimestamp(new \DateTime());
            $lenderDeviabTransaction->setCustomerEmail($request["customerEmail"]);
            $lenderDeviabTransaction->setCustomerName($request["customerName"]);
            $lenderDeviabTransaction->setMerchantTransactionId($request["merchantTransactionId"]);
            $lenderDeviabTransaction->setPaymentId($request["paymentId"]);
            $lenderDeviabTransaction->setCustomerPhone($request["customerPhone"]);
            $project->creditCapitalAmount($amount);
            $lender->getCurrentStatus()->creditPrincipalLeft($amount);
            $il = $amount * 0.6 / 100;
            $lender->getCurrentStatus()->creditInterrestLeft($il);
            $EMR = $this->getEMR($lender->getCurrentStatus());
            $lender->getCurrentStatus()->setExpectedMonthlyReturn($EMR);
            $this->em->merge($project);
            $this->em->merge($lender->getCurrentStatus());
            $this->em->persist($lenderDeviabTransaction);
            $this->em->flush();

            // $this->mailer->sendEmailMessage('Nitin', 'nitin@deviab.com', 'Sao Rocks', 'saoraghavendra@gmail.com', 'Jai Mata Di', 'Hi Hello Whatsup!');
            return View::create("Transaction captured", Codes::HTTP_OK);
        }
        return View::create("something went wrong dude", Codes::HTTP_BAD_REQUEST);
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