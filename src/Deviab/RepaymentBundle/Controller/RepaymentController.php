<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 19/09/15
 * Time: 3:02 AM
 */

namespace Deviab\RepaymentBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Deviab\RepaymentBundle\Entity\LenderWithdrawalRequest;
use FOS\RestBundle\Util\Codes;

class RepaymentController extends Controller
{
    public function repayLenderAction($amount)
    {
        $repaymentService = $this->container->get('repayment_service');
        $response = $repaymentService->lenderRepayment($amount);
        return $response;
    }

    public function withdrawalRequestAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if (!$user || (!in_array('ROLE_LENDER', $user->getRoles()))) {
            return new Response(json_encode(['error' => 'Access Denied']), Codes::HTTP_FORBIDDEN);
        }

        $em = $this->container->get('doctrine')->getEntityManager();
        $lenderRepo = $em->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lender = $lenderRepo->findOneByUser($user);
        if (!$lender) {
            return new Response(json_encode(['error' => 'Lender Not Found']), Codes::HTTP_NOT_FOUND);
        }

        $requestParams = $this->getRequest()->request->all();
        if (!(isset($requestParams['account_number']) &&
         isset($requestParams['ifsc_code']) &&
         isset($requestParams['account_name']) &&
         isset($requestParams['bank_name']))) {
            return new Response(json_encode(['error' => 'account_number, ifsc_code, account_name, bank_name']), Codes::HTTP_BAD_REQUEST);
        }

        $accountNumber = $requestParams['account_number'];
        $ifscCode = $requestParams['ifsc_code'];
        $accountName = $requestParams['account_name'];
        $bankName = $requestParams['bank_name'];

        if (!($lender->getWallet() and $lender->getWallet()->getCredits())) {
            return new Response(json_encode(['error' => 'lender doesn\'t have funds to initiate repayment']), Codes::HTTP_BAD_REQUEST);
        }
        $lenderWithdrawalRequestRepo = $em->getRepository('DeviabRepaymentBundle:LenderWithdrawalRequest');
        if ($lenderWithdrawalRequestRepo->findOneBy(['lender'=> $lender, 'status'=>'processing'])) {
            return new Response(json_encode(['success' => 'there\'s already one withdrawal request in process']), Codes::HTTP_OK);
        }

        $lenderWithdrawalRequest = new LenderWithdrawalRequest();

        $lenderWithdrawalRequest->setAmount($lender->getWallet()->getCredits());
        $lenderWithdrawalRequest->setRequestedAt(new \DateTime());
        $lenderWithdrawalRequest->setAccountNumber($accountNumber);
        $lenderWithdrawalRequest->setIfscCode($ifscCode);
        $lenderWithdrawalRequest->setAccountName($accountName);
        $lenderWithdrawalRequest->setBankName($bankName);
        $lenderWithdrawalRequest->setStatus('processing');
        $lenderWithdrawalRequest->setLender($lender);

        $em->persist($lenderWithdrawalRequest);
        $em->flush();

        return new Response(json_encode(['success' => 'Request in Process']), Codes::HTTP_OK);
    }
}