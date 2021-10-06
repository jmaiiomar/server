<?php

namespace App\Controller;

use App\Entity\Carnet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CarnetController extends AbstractController
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
     * @Route("/carnet/all", name="listCarnets")
     */
    public function findAll(): Response
    {
        $carnets = $this->getDoctrine()
            ->getRepository(Carnet::class)
            ->findBy(array(), array('prenom' => 'ASC'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $carnetsFormated = $serializer->normalize($carnets);
        return $this->json([
            'data' => $carnetsFormated,
        ]);
    }
    /**
     * @Route("/carnet/{id}", name="carnet")
     */
    public function findOne(Request  $request): Response
    {
        $carnet = $this->getDoctrine()
            ->getRepository(Carnet::class)
            ->find($request->get('id'));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $carnetFormated = $serializer->normalize($carnet);
        return $this->json([
            'data' => $carnetFormated,
        ]);
    }
    public function newCarnet($carnet,$request):void{
        $carnet->setNom($request->get('nom'));
        $carnet->setPrenom($request->get('prenom'));
        $carnet->setRegion($request->get('region'));
        $carnet->setTelephone((int)$request->get('telephone'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($carnet);
        $entityManager->flush();
    }
    /**
     * @Route("/carnet/new", name="carnet")
     */
    public function new(Request  $request): Response
    {
        $request = $this->transformJsonBody($request);

        $carnets = $this->getDoctrine()
            ->getRepository(Carnet::class)
            ->findOneBySomeField($request->get('nom') ,$request->get('prenom'),$request->get('telephone'));
        $carnet=new Carnet();
        if($carnets["carnet"]==null)
        {
            $this->newCarnet($carnet,$request);
        }
        else if($carnets["nbr"]<2 && $carnets["carnet"]->getNom()!=$request->get('nom') && $carnets["carnet"]->getPrenom()!=$request->get('prenom'))
        {
            $this->newCarnet($carnet,$request);

        }
        return $this->json([
            'data' =>$carnet ,
        ]);
    }


        /**
         * @Route("/carnet/delete/{id}", name="CarnetDelete", methods={"DELETE"})
         */
        public function delete($id): Response
    {
        $Carnet = $this->getDoctrine()
            ->getRepository(Carnet::class)
            ->find($id+0);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($Carnet);
        $entityManager->flush();
        return $this->json([
            'message' => "Deleted",
        ]);


    }
}
