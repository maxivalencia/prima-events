<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\User;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;    
    }

    /**
     * @Route("/", name="utilisateur_index", methods={"GET"})
     */
    public function index(Request $request, UtilisateurRepository $utilisateurRepository, PaginatorInterface $paginator): Response
    {

        $pagination = $paginator->paginate(
            $utilisateurRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="utilisateur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $utilisateur = new Utilisateur();
        $user = new User();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setUsername($utilisateur->getLogin());
            $user->setPassword($utilisateur->getPassword());
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            //$user->setRoles(["ROLE_USER"]);
            $user->setRoles(['ROLE_'.$utilisateur->getRole()]);
            $utilisateur->setPassword('argoni2');
            $entityManager->persist($utilisateur);
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisateur_show", methods={"GET"})
     */
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="utilisateur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Utilisateur $utilisateur): Response
    {        
        $user = new User();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_index');
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="utilisateur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Utilisateur $utilisateur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $userRepository = $entityManager->getRepository(User::class);
            $user = $userRepository->findOneBy(['username' => $utilisateur->getLogin()]);
            $entityManager->remove($utilisateur);
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('utilisateur_index');
    }
}
