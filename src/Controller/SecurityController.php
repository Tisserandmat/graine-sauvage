<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ResetPassType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//        if ($this->getUser()->getRoles(["ROLE_ADMIN"])) {
//            return $this->redirectToRoute('admin_home');
//        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="app_logout")
     */
    public function logout()
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }

    /**
     * @Route("/creation-de-compte", name="app_register")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $date = new DateTime('now');
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            )
                ->setRoles(["ROLE_USER"])
                ->setActivationToken(md5(uniqid()))
                ->setRegistrationDate($date);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new Email())
                ->from('grainesauvage@gmail.com')
                ->to($user->getEmail())
                ->subject('Veuillez valider votre compte Graine Sauvage')
                ->html($this->renderView('email/validation.html.twig', [
                    'token' => $user->getActivationToken()
                ]));


            $mailer->send($email);

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * * @Route("/activation/{token}", name="app_activation")
     * @param $token
     * @param UserRepository $userRepo
     */
    public function userActivation($token, UserRepository $userRepo)
    {
        $user = $userRepo->findOneBy(['activation_token' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Félicitation votre compte a bien été activé');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/recuperation-mot-de-passe", name="app_forgot_password")
     * @param UserRepository $userRepo
     * @param TokenGeneratorInterface $tokenGenerator
     * @param MailerInterface $mailer
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function forgottenPass(
        UserRepository $userRepo,
        TokenGeneratorInterface $tokenGenerator,
        MailerInterface $mailer,
        Request $request
    )
    {

        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $userRepo->findOneByEmail($data['email']);
            if (!$user) {
                $this->addFlash('danger', 'Cette adresse n\'existe pas');
                $this->redirectToRoute('app_login');
            }
            try {
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $exception) {
                $this->addFlash('warning', 'Une erreur est survenue');
                $this->redirectToRoute('app_login');
            }

            $email = (new Email())
                ->from('grainesauvage@gmail.com')
                ->to($user->getEmail())
                ->subject('Veuillez réinitialisé votre mot de passe')
                ->html($this->renderView('email/reset_password.html.twig', [
                    'token' => $user->getResetToken()
                ]));
            $mailer->send($email);

            $this->addFlash('success', 'un e-mail de réinitialisation de mot de passe vous à été envoyer. ');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/forgetten_password.html.twig', [
            'emailForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/reinitialisation-mot-de-passe/{token}", name="app_reset_password")
     * @param $token
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param MailerInterface $mailer
     * @return RedirectResponse|Response
     */
    public function resetPassword(
        $token,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        MailerInterface $mailer
    )
    {

        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'Token inconnu');
            return $this->redirectToRoute('app_login');
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setResetToken(null);

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->request->get('reset_password')['password']['first']
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Mot de passe mis à jour');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_pass.html.twig', [
            'passForm' => $form->createView(),
        ]);
    }
}
