<?php

namespace App\Controller;

use App\Entity\Formateur;
use App\Form\FormateurType;
use App\Repository\FormateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Else_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/formateur")
 */
class FormateurController extends AbstractController
{
    /**
     * @Route("/", name="formateur_index", methods={"GET"})
     */
    public function index(FormateurRepository $formateurRepository)
    {
        $Listformateur = $formateurRepository->findAll();
        return $this->Json($Listformateur);
    }

    /**
     * @Route("/add", name="formateur_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $SI): Response
    {
        $res = $request->getContent();
        $formateur = $SI->deserialize($res, Formateur::class, 'json');
        $entityManager->persist($formateur);
        $entityManager->flush();
        return $this->json($formateur);
    }
    /**
     * @Route("/delete/{id}", name="formateur_delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $entityManager, FormateurRepository $FR): Response
    {

        $formateur = $FR->find($id);
        if ($formateur) {
            $entityManager->remove($formateur);
            $entityManager->flush();
            return  $this->json("DELETED");
        } else {
            return  $this->json("ERROR");
        }
    }
    /**
     * @Route("/find/{id}", name="formateur_show", methods={"GET"})
     */
    public function show($id, FormateurRepository $FR): Response
    {
        return $this->json($FR->find($id));
    }

}
