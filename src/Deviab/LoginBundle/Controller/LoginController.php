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
use FOS\RestBundle\View\View;
use FOS\RestBundle\Util\Codes;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Deviab\LoginBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserInterface;

class LoginController extends Controller
{
    public function loginAction()
    {
        $requestParams = $this->getRequest()->request->all();
        $email = $requestParams['email'];
        $password = $requestParams['password'];
        $user_manager = $this->container->get('fos_user.user_manager');
        $em = $this->container->get('doctrine')->getEntityManager();
        $user = $em->getRepository('DeviabLoginBundle:User')->findOneBy(['email' => $email]);
        if (!$user) {
            return new Response(json_encode(['error' => 'Email is not registered']), Codes::HTTP_BAD_REQUEST);
        } else if (!$user->isEnabled()) {
            return new Response(json_encode(['error' => 'Email Confirmation Pending']), Codes::HTTP_BAD_REQUEST);
        }

        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return new Response(json_encode(['error' => 'Invalid Password']), Codes::HTTP_BAD_REQUEST);
        }

        $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

        $context = $this->container->get('security.context');
        $context->setToken($token);
        return new Response(json_encode(['email' => $email]), Codes::HTTP_OK);
    }

//    public function signupAction()
//    {
//        $requestParams = $this->getRequest()->request->all();
//        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
//        if (count(array_intersect(array_keys($requestParams), ['email', 'password'])) < 2) {
//            return new Response(json_encode(['error' => 'Email & Password are mandatory']), Codes::HTTP_BAD_REQUEST);
//        }
//        $username = $requestParams['username'];
//        $email = $requestParams['email'];
//        $password = $requestParams['password'];
//
//        $em = $this->container->get('doctrine')->getEntityManager();
//        $factory = $this->container->get('security.encoder_factory');
//        $user = $em->getRepository('DeviabLoginBundle:User')->findOneBy(['email' => $email]);
//        if ($user) {
//            return new Response(json_encode(['error' => 'Email Already registered']), Codes::HTTP_BAD_REQUEST);
//        }
//
//        $user = new User();
//        $user->setUsername($username);
//        $user->setEmail($email);
//        $user->setPlainPassword($password);
//        $user->setEnabled(!$confirmationEnabled);
//        $user->addRole('ROLE_LENDER');
//        $userManager = $this->container->get('fos_user.user_manager');
//        $userManager->updateUser($user);
//        $lender = $this->container->get('lender_service')->addLenderDetail([
//            'fname' => $requestParams['username'],
//            'user' => $user
//        ]);
//        $form = $this->container->get('fos_user.registration.form');
//        $formHandler = $this->container->get('fos_user.registration.form.handler');
//
//        $formHandler->jaiHo($user, true);
//        if ($confirmationEnabled) {
//            $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
//            return new Response(json_encode(['success' => 'Confirmation Email Sent']), Codes::HTTP_OK);
//        }
//        return new Response(json_encode(['success' => 'Login Now']), Codes::HTTP_OK);
//    }

    public function inviteAction()
    {
        $requestParams = $this->getRequest()->request->all();
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');
        if (count(array_intersect(array_keys($requestParams), ['email'])) < 1) {
            return new Response(json_encode(['error' => 'Email is mandatory']), Codes::HTTP_BAD_REQUEST);
        }
        $username = $email = $requestParams['email'];
        $password = 'DEVIAB@123';

        $em = $this->container->get('doctrine')->getEntityManager();
        $factory = $this->container->get('security.encoder_factory');
        $user = $em->getRepository('DeviabLoginBundle:User')->findOneBy(['email' => $email]);
        if ($user) {
            return new JsonResponse(['success' => 'Email Already registered'], Codes::HTTP_OK);
        }

        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(!$confirmationEnabled);
        $user->addRole('ROLE_LENDER');
        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->updateUser($user);
        $lender = $this->container->get('lender_service')->addLenderDetail([
            'user' => $user,
            'fname' => "Fill in your name",
        ]);
        // $form = $this->container->get('fos_user.registration.form');
        // $formHandler = $this->container->get('fos_user.registration.form.handler');

        // $formHandler->jaiHo($user, true);
        return new JsonResponse(['success' => 'Invite will be sent to your email ' . $requestParams['email']], Codes::HTTP_OK);
    }

    public function logoutAction()
    {

    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction( $token )
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            return new Response(json_encode('Invalid Token'), Codes::HTTP_NOT_FOUND);
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new Response(json_encode(['success' => 'Loggedin Now']), Codes::HTTP_OK);
        $this->authenticateUser($user, $response);

        // return $response;
        return $this->redirectToRoute('fabric_homepage');
    }

    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser( UserInterface $user, Response $response )
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }

    /**
     * Request reset user password: submit form and send email
     */
    public function sendResetEmailAction()
    {
        $email = $this->container->get('request')->request->get('email');

        /** @var $user UserInterface */
        $user = $this->container->get('fos_user.user_manager')->findUserByEmail($email);

        if (null === $user) {
            return new Response(json_encode(['error' => 'Email not Registered']), Codes::HTTP_BAD_REQUEST);
        }

        // if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
        //     return new Response(json_encode(['error'=>'Already one request Pending']), Codes::HTTP_BAD_REQUEST);
        // }

        if (null === $user->getConfirmationToken()) {
            /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $user->setConfirmationToken($tokenGenerator->generateToken());
        }

        $this->container->get('session')->set('fos_user_send_resetting_email/email', $this->getObfuscatedEmail($user));
        $this->container->get('fos_user.mailer')->sendResettingEmailMessage($user);
        $user->setPasswordRequestedAt(new \DateTime());
        $this->container->get('fos_user.user_manager')->updateUser($user);
        return new Response(json_encode(['success' => 'Check Email Now']), Codes::HTTP_OK);
        // return new RedirectResponse($this->container->get('router')->generate('fos_user_resetting_check_email'));
    }

    /**
     * Get the truncated email displayed when requesting the resetting.
     *
     * The default implementation only keeps the part following @ in the address.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getObfuscatedEmail( UserInterface $user )
    {
        $email = $user->getEmail();
        if (false !== $pos = strpos($email, '@')) {
            $email = '...' . substr($email, $pos);
        }

        return $email;
    }

    /**
     * Reset user password
     */
    public function resetAction( $token )
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            return new Response(json_encode(['error' => 'Invalid Token']), Codes::HTTP_BAD_REQUEST);
        }

        // if (!$user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
        //     return new RedirectResponse($this->container->get('router')->generate('fos_user_resetting_request'));
        // }

        $form = $this->container->get('fos_user.resetting.form');
        $formHandler = $this->container->get('fos_user.resetting.form.handler');
        $process = $formHandler->process($user);

        if ($process) {
            // $this->setFlash('fos_user_success', 'resetting.flash.success');
            // $response = new RedirectResponse($this->getRedirectionUrl($user));
            $response = new Response(json_encode(['success' => 'Logged In Now']), Codes::HTTP_OK);
            $this->authenticateUser($user, $response);

            // return $response;
            return $this->redirectToRoute('fabric_homepage');
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Resetting:reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}
