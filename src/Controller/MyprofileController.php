<?php

namespace App\Controller;

use App\Entity\ChangePassword;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormError;


class MyprofileController extends AbstractController
{
    /**
     * @Route("/myprofile", name="myprofile")
     */
    public function index()
    {
        return $this->render('myprofile/index.html.twig', [
            'controller_name' => 'MyprofileController',
        ]);
    }



    /**
     * @Security("has_role('ROLE_USER') or has_role('ROLE_MANAGER') or has_role('ROLE_MAGASINIER')  or has_role('ROLE_ADMIN')")
     * @Route("/passwordupdateddd", name="password_updateddd")
     */
    public function changePasswordFormAction()
    {
        $entity = new User();
        //$form = $this->createFormBuilder($entity)
             $form=$this->createForm(ResetPasswordType::class, $entity);
           /* ->add('confirm_password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmer votre mot de passe'),
            ))*/
            //->getForm();

        return $this->render('myprofile/changePassword.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')or is_granted('ROLE_FOURNISSEUR')")
     *
     * @Route("/passwordupdateaction", name="password_updateaction")
     * @Route("/passwordupdate", name="password_update")
     */


    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        //$this->denyAccessUnlessGranted('ROLE_USER');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $changePassword = new ChangePassword();
        // rattachement du formulaire avec la class changePassword
        $form = $this->createForm(ResetPasswordType::class, $changePassword);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $newpwd = $form->get('Password')['first']->getData();

            $newEncodedPassword = $passwordEncoder->encodePassword($user, $newpwd);
            $user->setPassword($newEncodedPassword);

            $em->persist($user);
            $em->flush();

           // $message= " Votre mot de passe à bien été changé veuillez connecter de nouveaux! ";
           // echo '<script> alert("'.$message.'")</script>';

            $this->addFlash('success', 'Votre mot de passe à bien été changé !');

           return $this->redirectToRoute('home');
        }

        return $this->render('myprofile/changePassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
   // }













  /*  public function changePasswordAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


           $passwordEncoder = $this->get('security.password_encoder');

         //   dump($request->request);die();

            $oldPassword = $request->request->get('reset_password')['oldPassword'];




            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
                //$newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getConfirmPassword());
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $request->request->get('reset_password')['confirm_password']);
                $user->setPassword($newEncodedPassword);

              //  $em->persist($user);
               // $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('home');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('myprofile/changePassword.html.twig', array(
            'form' => $form->createView(),
        ));

        */

       /* $em = $this->getDoctrine()->getManager();
        $user = new User();
        $tokenStorage = $this->get('security.token_storage');
        $token = $tokenStorage->getToken();
        if (null !== $token && is_object($token->getUser())) {
            $user = $token->getUser();
            $form = $this->createFormBuilder($user)
                ->add('confirm_password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Nouveau mot de passe'),
                    'second_options' => array('label' => 'Confirmer votre mot de passe'),
                ))
                ->getForm();
            $form->handleRequest($request);

            if ($form->isValid()) {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', "Mise à jour effectué avec succée");
                return $this->render('myprofile/changePassword.html.twig', array(
                    'entity' => $user,
                    'form'   => $form->createView(),
                ));

            }
            $this->get('session')->getFlashBag()->add('error', "Il y a des erreurs dans le formulaire soumis !");
            return $this->render('myprofile/changePassword.html.twig', array(
                'entity' => $user,
                'form'   => $form->createView(),
            ));

        }
        throw $this->createNotFoundException('Vous n\'avez pas le droit, vous devrez étre authentifiée');*/





    }




}
