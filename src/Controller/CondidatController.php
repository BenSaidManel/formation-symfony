<?php

namespace App\Controller;

use App\Entity\Condidat;
use App\Form\CondidatType;
use App\Repository\CondidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/condidat")
 */
class CondidatController extends AbstractController
{
   /**
     * @Route("/", name="Condidat_index", methods={"GET"})
     */
    public function index(CondidatRepository $CondidatRepository)
    {
        $ListCondidat = $CondidatRepository->findAll();
       
        return $this->Json($ListCondidat);
       
    }

   

    /**
     * @Route("/add", name="Condidat_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $SI): Response
    {
        $res = $request->getContent();
        $Condidat = $SI->deserialize($res, Condidat::class, 'json');
        $entityManager->persist($Condidat);
        $entityManager->flush();
        return $this->json($Condidat);
    }
    /**
     * @Route("/delete/{id}", name="Condidat_delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $entityManager, CondidatRepository $FR): Response
    {

        $Condidat = $FR->find($id);
        if ($Condidat) {
            $entityManager->remove($Condidat);
            $entityManager->flush();
            return  $this->json("DELETED");
        } else {
            return  $this->json("ERROR");
        }
    }
    /**
     * @Route("/find/{id}", name="Condidat_show", methods={"GET"})
     */
    public function show($id, CondidatRepository $FR): Response
    {
        return $this->json($FR->find($id));
    }

    /**
     * @Route("/update", name="condidat_edit", methods={"POST"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager,SerializerInterface $SI): Response
    {
        $res = $request->getContent();
        $Condidat = $SI->deserialize($res, Condidat::class, 'json');

        if ($Condidat) {
            $entityManager->persist($Condidat);
            $entityManager->flush();

           
        }

       return $this->json($Condidat);
    }

   
}
