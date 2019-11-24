<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FRType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {

    }

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/user", name="user")
     */
    public function index()
    {

        $utilisateurs = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', array('utilisateurs' => $utilisateurs));
    }


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/user/new", name="new_user")
     * @Route("/user/{action}/{id}", name="user_edit", methods="DELETE|GET|POST")
     */

    public function form(User $utilisateur = null, Request $request, UserPasswordEncoderInterface $passwordEncoder, $action = 0, $id = 0)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(User::class);
        $utilisateur = new User();
        if ((base64_decode($action)) > 0) {
            $utilisateur = $rep->findOneBy(['id' => (base64_decode($id) - 111985)]);
            if (base64_decode($action) > 1) {
                if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {

                    $em->remove($utilisateur);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('user');
                }
            }
        }


        $form = $this->createForm(UserType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('confirm_password')->getData()
                )
            );
            $utilisateur->setDatecreation(new \DateTime());
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('user');
        }

        return $this->render('user/new.html.twig', ['form' => $form->createView()]);

    }


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/fournisseur", name="fournisseur")
     */
    public function fournisseur()
    {

        $utilisateurs = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('fournisseur/index.html.twig', array('utilisateurs' => $utilisateurs));
    }


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/fournisseur/new", name="new_fournisseur")
     * @Route("/fournisseur/{action}/{id}", name="edit_fournisseur", methods="DELETE|GET|POST")
     */

    public function formFR(User $utilisateur = null, Request $request, UserPasswordEncoderInterface $passwordEncoder, $action = 0, $id = 0)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(User::class);
        $utilisateur = new User();
        if ((base64_decode($action)) > 0) {
            $utilisateur = $rep->findOneBy(['id' => (base64_decode($id) - 111985)]);
            if (base64_decode($action) > 1) {
                if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {

                    $em->remove($utilisateur);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('fournisseur');
                }
            }
        }

        $form = $this->createForm(FRType::class, $utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setPassword(
                $passwordEncoder->encodePassword(
                    $utilisateur,
                    $form->get('confirm_password')->getData()
                )
            );
            $utilisateur->setRoles(array('ROLE_FOURNISSEUR'));
            $utilisateur->setDatecreation(new \DateTime());
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('fournisseur');
        }

        return $this->render('fournisseur/new.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/user/activer/{action}/{id}", name="activeruser")
     */
    public function activer(UserRepository $activerReposotory, $action = 0, $id = 0)
    {

        if ((base64_decode($action)) == 0) {
            $activerReposotory->activer_user((base64_decode($id) - 111985));

            return $this->redirectToRoute('user');
        }

        if ((base64_decode($action)) == 1) {
            $activerReposotory->activer_user((base64_decode($id) - 111985));

            return $this->redirectToRoute('fournisseur');
        }

    }

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/user/desactiver/{action}/{id}", name="desactiveruser")
     */
    public function desactiver(UserRepository $activerReposotory, $action = 0, $id = 0)
    {
        if ((base64_decode($action)) == 0) {
            $activerReposotory->deactiver_user((base64_decode($id) - 111985));

            return $this->redirectToRoute('user');
        }
        if ((base64_decode($action)) == 1) {
            $activerReposotory->deactiver_user((base64_decode($id) - 111985));
            return $this->redirectToRoute('fournisseur');
        }
    }


    /**
     * @Route("/erreur404", name="erreur404")
     */
    public function erreur1()
    {

        return $this->render('security/404.html.twig');
    }

    /**
     * @Route("/erreur500", name="erreur500")
     */
    public function erreur2()
    {

        return $this->render('security/500.html.twig');
    }

}
