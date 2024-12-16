<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Validator\Validation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends AbstractController
{
    private $mailer;
    private $validator;
    private $entityManager;
    private $userRepository;

    public function __construct(MailerInterface $mailer, ValidatorInterface $validator, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }
    #[Route('/login', name: 'page_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/confirm', name: 'page_confirm')]
    public function index(): Response
    {
        return $this->render('auth/confirm.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route('/default', name: 'page_default')]
    public function default(): Response
    {
        return $this->render('auth/default.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws RandomException
     */
    #[Route('/forgot', name: 'page_forgot')]
    public function forgot(Request $request, MailerInterface $mailer, UrlGeneratorInterface $router): Response
    {
        // Récupérer l'email du formulaire
        $email = $request->get('email');

        // Vérifier que l'email n'est pas vide ou nul
        if (empty($email)) {
            return $this->render('auth/forgot.html.twig', [
                'error' => 'L\'email ne peut pas être vide.',
            ]);
        }

        // Validation de l'email
        $validator = Validation::createValidator();
        $violations = $validator->validate($email, [new EmailConstraint()]);

        if (count($violations) > 0) {
            return $this->render('auth/forgot.html.twig', [
                'error' => 'Adresse email invalide',
            ]);
        }

        // Vérifier si l'utilisateur existe avec cet email
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            return $this->render('auth/forgot.html.twig', [
                'error' => 'Aucun compte trouvé avec cet email',
            ]);
        }

        // Générer un token de réinitialisation
        $token = bin2hex(random_bytes(32));

        // Sauvegarder le token dans la base de données
        $user->setResetPasswordToken($token);
        $this->entityManager->flush();

        // Générer le lien de réinitialisation
        $url = $router->generate('page_reset', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

        // Créer l'email de réinitialisation
        $emailMessage = (new Email())
            ->from('matthisd77@gmail.com')  // Utilise une adresse email valide
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')
            ->html("<p>Bonjour,</p><p>Pour réinitialiser votre mot de passe, cliquez sur ce lien : <a href=\"$url\">Réinitialiser le mot de passe</a></p>");

        $mailer->send($emailMessage);

        return $this->render('auth/login.html.twig', [
            'success' => 'Un email de réinitialisation a été envoyé',
        ]);
    }

    #[Route('/register', name: 'page_register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/reset/{token}', name: 'page_reset')]
    public function reset(Request $request, string $token, MailerInterface $mailer): Response
    {
        // Trouver l'utilisateur avec le token
        $user = $this->userRepository->findOneByResetPasswordToken($token);

        if (!$user) {
            return $this->render('auth/reset.html.twig', [
                'error' => 'Token invalide ou expiré',
            ]);
        }

        // Si un nouveau mot de passe est soumis
        if ($request->isMethod('POST')) {
            $newPassword = $request->get('password');

            // Hashage du mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $user->setPassword($hashedPassword);

            // Supprimer le token de réinitialisation
            $user->setResetPasswordToken(null);
            $this->entityManager->flush();

            // Envoyer un email de confirmation
            $emailMessage = (new Email())
                ->from('no-reply@streemi.com')
                ->to($user->getEmail())
                ->subject('Votre mot de passe a été réinitialisé')
                ->html("<p>Bonjour,</p><p>Votre mot de passe a été réinitialisé avec succès.</p>");

            $mailer->send($emailMessage);

            return $this->render('auth/reset.html.twig', [
                'success' => 'Votre mot de passe a été réinitialisé avec succès',
            ]);
        }

        return $this->render('auth/reset.html.twig');
    }

    #[Route('/upload', name: 'page_upload')]
    public function upload(): Response
    {
        return $this->render('auth/upload.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
