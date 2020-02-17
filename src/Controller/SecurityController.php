<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends BaseController
{
    /**
     * @Route("/login", name="app_login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_habits');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'navi' => 'login',
            'last_username' => $lastUsername,
            'error' => $error
        ]);

    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('Will be intercepted before getting here');
    }

    /**
     * @Route("/reset-password", name="app_reset_password")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $formAuthenticator
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response|null
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator, AuthenticationUtils $authenticationUtils)
    {
        if($this->getUser() === null){
            return $this->redirect($this->generateUrl('app_login'));
        }

        $error = '';
        if ($request->isMethod('POST')) {
            $user = $this->getUser();

            if($passwordEncoder->isPasswordValid($user, $request->request->get('oldPassword'))){

                $user->setPassword($passwordEncoder->encodePassword(
                    $user,
                    $request->request->get('newPassword')
                ));
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $guardHandler->authenticateUserAndHandleSuccess(
                    $user,
                    $request,
                    $formAuthenticator,
                    'main'
                );
            }
            $error = 'Your old password was not correct';
        }

        return $this->render('security/reset_password.html.twig', [
            'navi' => 'change-password',
            'error' => $error,
        ]);
    }
}
