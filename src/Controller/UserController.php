<?php
namespace App\Controller;

use App\Form\UserRegistrationType;
use App\Form\PasswordResetType;
use App\Form\PasswordChangeType;
use App\Form\UserLoginType;
use App\Form\EditUserType;
use App\Entity\User;
use App\Entity\Repertoire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Swiftmailer\swiftmailer;


class UserController extends Controller
{
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserRegistrationType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setEnabled(false);
            $role = ['ROLE_USER'];
            $user->setRoles($role);
            $user->setUsername();
            $user->setConfirmationToken(base64_encode($user->getEmail()));

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $url = $this->generateUrl('check_mail',array('confirmationtoken' => $user->getConfirmationToken()));

           $message = (new \Swift_Message('Hello Email'))
            ->setFrom('tnpcclqp@netcourrier.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView(
                    // templates/emails/registration.html.twig
                    'email/registration.html.twig',
                    array('url' => $url)
                ),
                'text/html'
            );
            $result = $mailer->send($message);
           return $this->redirectToRoute('index');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function login(Request $request, AuthenticationUtils $authUtils)
    {
       
     // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
           'last_username' => $lastUsername,
           'error'         => $error,
        ));
    }

    public function checkmail($confirmationtoken,RegistryInterface $doctrine)
    {
        $user = $doctrine->getRepository(User::class)->findOneByConfirmationToken($confirmationtoken);
        if($user != null)
        {
            $user->setEnabled(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->render('user/mail_check.html.twig');
        }
        return $this->redirectToRoute('index');
    }


    public function reset_password_ask(Request $request,RegistryInterface $doctrine,\Swift_Mailer $mailer)
    {
        $email = $request->get('email');
            if($email != null)
            {
                $user = $doctrine->getRepository(User::class)->findOneByEmail($email);
                if($user != null)
                {
                    $user->setConfirmationResetPasswordToken(base64_encode($user->getPassword()));
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    $url = $this->generateUrl('reset_password_check',array('confirmationResetPasswordToken' => $user->getConfirmationResetPasswordToken()));

                    $message = (new \Swift_Message('Hello Email'))
                     ->setFrom('tnpcclqp@netcourrier.com')
                     ->setTo($user->getEmail())
                     ->setBody(
                         $this->renderView(
                             // templates/emails/registration.html.twig
                             'email/reset_password.html.twig',
                             array('url' => $url)
                         ),
                         'text/html'
                     );
                     $result = $mailer->send($message);
                    return $this->render('user/reset_password_email_sent.html.twig');
                }
            }
        
        return $this->render('user/reset_password.html.twig');
    }

    public function reset_password_check($confirmationResetPasswordToken,Request $request,RegistryInterface $doctrine,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $doctrine->getRepository(User::class)->findOneByConfirmationResetPasswordToken($confirmationResetPasswordToken);
        if($confirmationResetPasswordToken != null)
        {
        $form = $this->createForm(PasswordResetType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setConfirmationResetPasswordToken(null);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('login');
            }
            return $this->render(
                'user/reset_password_form.html.twig',
                array('form' => $form->createView())
            );
        }
        return $this->redirectToRoute('index');
    }

    public function edit_password(Request $request,RegistryInterface $doctrine,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordResetType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('login');
            }
            return $this->render(
                'user/reset_password_form.html.twig',
                array('form' => $form->createView())
            );
        return $this->redirectToRoute('index');
    }

    public function account()
    {
        $user = $this->getUser();
    
            return $this->render('user/my_account.html.twig');
    }

    public function edit_info(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($user->getPassword());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('account');
        }
    
            return $this->render('user/edit_info.html.twig',array(
                'form' =>$form->createView()
            ));
    }

    public function change_password(Request $request,RegistryInterface $doctrine,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordChangeType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('account');
            }
            return $this->render(
                'user/reset_password_form.html.twig',
                array('form' => $form->createView())
            );
        return $this->redirectToRoute('index');
    }
}