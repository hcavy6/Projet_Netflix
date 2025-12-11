<?php

namespace App\Controller;

use App\Business\TokenBusiness;
use App\Entity\Token;
use App\Entity\User;
use App\Entity\UserRepository;
use App\Form\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register')]
    public function create(
        Request                     $request,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $hasher,
        TokenBusiness               $tokenBusiness,
        MailerInterface             $mailer
    ): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));

            $token = $tokenBusiness->createToken($user);
            $user->addToken($token);
            $entityManager->persist($user);
            $entityManager->flush();

            $email = new Email();

            $email
                ->from('pierremartinant60@gmail.com')
                ->to($user->getEmail())
                ->text($this->renderBlockView('Mail/validate-email.html.twig', 'text', ['token' => $token]))
                ->html($this->renderBlockView('Mail/validate-email.html.twig', 'html', ['token' => $token]))
                ->subject($this->renderBlockView('Mail/validate-email.html.twig', 'subject', ['token' => $token]));
            $mailer->send($email);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $utils): Response
    {
        return $this->render('user/login.html.twig');
    }

    #[Route('/validate/{value}', name: 'app_validate')]
    public function confirmEmail(Token $token, EntityManagerInterface $entityManager): Response
    {
        if ($token->getExpiresAt() < new \DateTime()) {
            throw $this->createNotFoundException();
        }

        $user = $token->getUser();
        $user->setEnabled(true);

        $entityManager->persist($user);
        $entityManager->remove($token);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}
