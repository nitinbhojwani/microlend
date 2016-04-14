<?php

namespace Deviab\FabricBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Deviab\LoginBundle\Entity\User;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Response;

class TransactionResultController extends Controller
{
    public function transactionResultAction($status)
    {
        if (!($status === 'success' || $status === 'failure')) {
            return new Response(json_encode(['error' => 'Invalid Status']), Codes::HTTP_NOT_FOUND);
        } else {
            $requestParams = $this->getRequest()->request->all();
            if (!array_intersect(array_keys($requestParams),
                ["status", "firstname", "amount", "txnid", "hash", "key", "productinfo", "email"])
            ) {
                return new Response(json_encode(['error' => 'Mandatory Params missing']), Codes::HTTP_BAD_REQUEST);
            }
            $status = $requestParams["status"];
            $firstname = $requestParams["firstname"];
            $amount = $requestParams["amount"];
            $txnid = $requestParams["txnid"];
            $posted_hash = $requestParams["hash"];
            $key = $requestParams["key"];
            $productinfo = $requestParams["productinfo"];
            $email = $requestParams["email"];
            $salt = "GQs7yium";

            if (isset($requestParams["additionalCharges"])) {
                $additionalCharges = $requestParams["additionalCharges"];
                $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            } else {
                $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            }
            $hash = hash("sha512", $retHashSeq);
            if ($hash != $posted_hash) {
                return new Response(json_encode(['error' => 'Invalid Transaction. Please try again']), Codes::HTTP_BAD_REQUEST);
            }

            return $this->render('FabricBundle:Payu:result.html.twig', $requestParams);
        }
    }
}
