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
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE)
            return null;
        if ($data === null)
            return $request;
        $request->request->replace($data);
        return $request;
    }
    /**
     * @Route("/utilisateur/register", name="register")
     */
    public function new(Request  $request): Response
    {
        $request = $this->transformJsonBody($request);

            $utilisateur = new Utilisateur();
            $utilisateur->setNom($request->get('nom'));
            $utilisateur->setPrenom($request->get('prenom'));
            $utilisateur->setEmail($request->get('email'));
            $utilisateur->setPwd($request->get('pwd'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();
            return $this->json(['data' => $utilisateur]);
    }
    /**
     * @Route("/utilisateur/login", name="login")
     */
    public function login(Request  $request): Response
    {
        $request = $this->transformJsonBody($request);
        $utilsateur = $this->getDoctrine()
            ->getRepository(Utilisateur::class)
            ->findOneBy(["email"=>$request->get('email'),"pwd"=>$request->get('pwd')]);
        return $this->json(['data' => $utilsateur]);
    }
}
