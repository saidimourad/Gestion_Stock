<?php

namespace App\Controller;

use App\Entity\ChangePassword;
use App\Form\FRUpdateType;
use App\Form\ResetPasswordType;
use App\Form\UserupdateType;
use App\Service\decodeID;
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


            $this->addFlash('success', 'Votre mot de passe à bien été changé !');

           return $this->redirectToRoute('home');
        }

        return $this->render('myprofile/changePassword.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));

    }


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')or is_granted('ROLE_FOURNISSEUR')")
     * @Route("/profile/{action}/{id}", name="profile", methods="DELETE|GET")
     */
    public function index($action=0, $id=0,decodeID $decodeID )
    {

        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep->findOneBy(['id' => (base64_decode($id) / $decodeID->getDecode())]);
        if ($action == 1) {
            $form1 = $this->createForm(UserupdateType::class, $user);

            return $this->render('user/detail.html.twig', [
                'user' => $user, 'form' => $form1->createView()
            ]);
        }
           elseif($action==2)

           {
            $form2 = $this->createForm(FRUpdateType::class, $user);

            return $this->render('fournisseur/detail.html.twig', [
                'user' => $user, 'form' => $form2->createView()
            ]);

        }

    }


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR')")
     *
     * @Route("/pwdupAdmUSER", name="pwdupAdmUSER", methods="POST")
     */


    public function editpasswordAdmUser(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

             $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(User::class);


        if( isset($_POST["valider"]) ) {

            $id = $_POST["userupdate"]["id"];
            $nom = $_POST["userupdate"]["nom"];
            $prenom = $_POST["userupdate"]["prenom"];
            $cin= $_POST["userupdate"]["cin"];
            $datenassance= $_POST["userupdate"]["datenassance"];
            $adresse= $_POST["userupdate"]["adresse"];
            $tel= $_POST["userupdate"]["tel"];
            $sexe= $_POST["userupdate"]["sexe"];
            $etatcivil= $_POST["userupdate"]["etatcivil"];
            $dateembauche= $_POST["userupdate"]["dateembauche"];
            $email= $_POST["userupdate"]["email"];
            $roles= $_POST["userupdate"]["roles"];
            $isActive= $_POST["userupdate"]["isActive"];

            $utilisateur = $rep->findOneBy(['id' => $id]);
            $utilisateur->setNom($nom);
            $utilisateur->setPrenom($prenom);
            $utilisateur->setCin($cin);
            $utilisateur->setDatenassance(\DateTime::createFromFormat('Y-m-d', $datenassance));
            $utilisateur->setAdresse($adresse);
            $utilisateur->setTel($tel);
            $utilisateur->setSexe($sexe);
            $utilisateur->setEtatcivil($etatcivil);
            $utilisateur->setDateembauche(\DateTime::createFromFormat('Y-m-d', $dateembauche));
            $utilisateur->setEmail($email);
            $utilisateur->setRoles($roles);
            $utilisateur->setIsActive($isActive);

            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('user');
        }

        return $this->redirectToRoute('user');


    }
    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR')")
     *
     * @Route("/pwdupAdmFR", name="pwdupAdmFR", methods="POST")
     */

    public function editpasswordAdmFR(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(User::class);


        if( isset($_POST["valider"]) ) {

            $id = $_POST["fr_update"]["id"];
            $nomste = $_POST["fr_update"]["nomste"];
            $mfste = $_POST["fr_update"]["mfste"];
            $gerantste= $_POST["fr_update"]["gerantste"];
            $adresse= $_POST["fr_update"]["adresse"];
            $tel= $_POST["fr_update"]["tel"];
            $email= $_POST["fr_update"]["email"];
            $activiteste= $_POST["fr_update"]["activiteste"];
            $isActive= $_POST["fr_update"]["isActive"];

            $utilisateur = $rep->findOneBy(['id' => $id]);
            $utilisateur->setNomste($nomste);
            $utilisateur->setMfste($mfste);
            $utilisateur->setGerantste($gerantste);
            $utilisateur->setAdresse($adresse);
            $utilisateur->setTel($tel);
            $utilisateur->setActiviteste($activiteste);
            $utilisateur->setEmail($email);
            $utilisateur->setIsActive($isActive);

            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('fournisseur');
        }

        return $this->redirectToRoute('fournisseur');


    }


}
