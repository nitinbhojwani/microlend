<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deviab\LoginBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Deviab\LoginBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserInterface;

class LenderController extends Controller
{

    public function patchLenderAction($lenderId)
    {
        $requestParams = $this->getRequest()->request->all();
        $em = $this->container->get('doctrine')->getEntityManager();
        $lenderRepo = $em->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lender = $lenderRepo->findOneById($lenderId);
        $user = $this->get('security.context')->getToken()->getUser();
        if (!$lender) {
            return new Response(json_encode(['error' => 'Lender Not Found']), Codes::HTTP_NOT_FOUND);
        }
        if (!$user || !$user->getId() === $lender->getUser()->getId()) {
            return new Response(json_encode(['error' => 'Access Denied']), Codes::HTTP_FORBIDDEN);
        }
        if (isset($requestParams['fname'])) {
            $lender->setFname($requestParams['fname']);
        }
        if (isset($requestParams['lname'])) {
            $lender->setLname($requestParams['lname']);
        }
        if (isset($requestParams['address'])) {
            $lender->setAddress($requestParams['address']);
        }
        if (isset($requestParams['gender'])) {
            $lender->setGender($requestParams['gender']);
        }
        if (isset($requestParams['dob'])) {
            $lender->setDob($requestParams['dob']);
        }
        if (isset($requestParams['primary_mobile_number'])) {
            $lender->setPrimaryMobileNumber($requestParams['primary_mobile_number']);
        }
        if (isset($requestParams['profile_pic'])) {
            $lender->setProfilePic($requestParams['profile_pic']);
        }
        if (isset($requestParams['google_id'])) {
            $lender->setGoogleId($requestParams['google_id']);
        }
        if (isset($requestParams['facebook_id'])) {
            $lender->setFacebookId($requestParams['facebook_id']);
        }

        $passwordChange = false;

        if (isset($requestParams['old_password']) && isset($requestParams['new_password'])) {
            $oldPassword = $requestParams['old_password'];
            $newPassword = $requestParams['new_password'];
            $passwordChange = true;
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            if (!$encoder->isPasswordValid($user->getPassword(), $oldPassword, $user->getSalt())) {
                $passwordChanged = false;
            } else {
                $passwordChanged = true;
                $user->setPassword($encoder->encodePassword($newPassword, $user->getSalt()));
                $em->persist($user);
            }
        }

        $em->persist($lender);
        $em->flush();

        if ($passwordChange && !$passwordChanged) {
            return new Response(json_encode(['success' => false, 'msg' => 'Wrong Old Password']), Codes::HTTP_OK);
        }
        return new Response(json_encode(['success' => true, 'msg' => 'All is Well']), Codes::HTTP_OK);
    }

    public function getLenderAction()
    {
        $queryParams = $this->getRequest()->query->all();
        $em = $this->container->get('doctrine')->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        if (!$user || (!in_array('ROLE_LENDER', $user->getRoles()))) {
            return new Response(json_encode(['error' => 'Access Denied']), Codes::HTTP_FORBIDDEN);
        }
        $lenderRepo = $em->getRepository('DeviabDatabaseBundle:LenderDetails');
        $lender = $lenderRepo->findOneById($user->getLender()->getId());
        if (!$lender) {
            return new Response(json_encode(['error' => 'Lender Not Found']), Codes::HTTP_NOT_FOUND);
        }

        return View::create($user, Codes::HTTP_OK)
            ->setSerializationContext(SerializationContext::create()
                ->setGroups(array('profile')));
    }
}
