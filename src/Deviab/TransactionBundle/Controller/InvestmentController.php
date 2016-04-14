<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 17/09/15
 * Time: 5:44 PM
 */

namespace Deviab\TransactionBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Deviab\LoginBundle\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;

class InvestmentController extends Controller
{
    public function getLenderInvestmentAction( $lenderId )
    {
        $investmentService = $this->container->get('investment_service');
        $investmentDetails = $investmentService->getLenderInvestment($lenderId);
        $context = SerializationContext::create()->setGroups(array('transactionPage'));
        return $investmentDetails->setSerializationContext($context);
    }

    public function transactionAction()
    {
        $token = $this->get('security.context')->getToken();
        $user = $token->getUser();
        $amount = $this->getRequest()->query->get('amount');
        if ($user instanceof User) {
            $lender = $user->getLender();
            $email = $user->getEmail();
            $firstname = $lender->getFname();
            $phone = $lender->getPrimaryMobileNumber();
            $txnid = uniqid($user->getEmail() + $amount + date("Y-m-d H:i:s"));
            $lenderId = $lender->getId();
            $projectId = 1;
            $data = "payu_key" . "|" . $txnid . "|" . $amount . "|" . "pilot" . "|" . $firstname . "|" . $email . "|" . $lenderId . "|" . $projectId . "|||||||||" . "payu_salt";
            $hash = hash('sha512', $data);
            $host = $this->get('router')->getContext()->getHost();

            $url = "https://secure.payu.in/_payment";
            $fields = array(
                'key' => "payu_key",
                'firstname' => $firstname,
                'email' => $email,
                'phone' => $phone,
                'productinfo' => "pilot",
                'txnid' => $txnid,
                'amount' => $amount,
                'udf1' => $lenderId,
                'udf2' => $projectId,
                'surl' => "http://try.lytyfy.org/#/dashboard",
                'furl' => "http://try.lytyfy.org/#/dashboard",
                'curl' => "http://try.lytyfy.org/#/dashboard",
                'hash' => $hash,
                'service_provider' => "payu_paisa"
            );
            if (!$amount) {
                $err = 'Amount Required';
            } else if (!$firstname || $firstname == "Fill in your name") {
                $err = 'FirstName Required';
            } else if (!$email) {
                $err = 'Email Required';
            } else if (!$phone) {
                $err = 'Phone Required';
            } else {
                return View::create($fields, Codes::HTTP_OK);
            }
            return View::create(array('error' => $err), Codes::HTTP_BAD_REQUEST);
        }
    }
}