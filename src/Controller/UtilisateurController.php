<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur/register", name="utilisateur")
     */
    public function new(Request  $request): Response
    {

            $utilisateur = new Utilisateur();
            $utilisateur->setNom($request->get('nom'));
            $utilisateur->setPrenom($request->get('prenom'));
            $utilisateur->setPwd($request->get('pwd'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->json(['message' => 'Welcome to your new controller!']);
    }
    /**
     * @Route("/utilisateur/register", name="utilisateur")
     */
    public function login(Request  $request): Response
    {

        $utilisateur = new Utilisateur();
        $utilisateur->setNom($request->get('nom'));
        $utilisateur->setPrenom($request->get('prenom'));
        $utilisateur->setPwd($request->get('pwd'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($utilisateur);
        $entityManager->flush();
        return $this->json(['message' => 'Welcome to your new controller!']);
    }
}
