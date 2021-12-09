<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{

    /**
     * @Route("/", name="Formation_index", methods={"GET"})
     */
    public function index(FormationRepository $FormationRepository)
    {
        $ListFormation = $FormationRepository->findAll();
        return $this->Json($ListFormation);
    }

    /**
     * @Route("/add", name="Formation_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $SI): Response
    {
        $res = $request->getContent();
        $Formation = $SI->deserialize($res, Formation::class, 'json');
        
        $entityManager->persist($Formation);
        $entityManager->flush();
        return $this->json($Formation);
        
    }
    /**
     * @Route("/delete/{id}", name="Formation_delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $entityManager, FormationRepository $FR): Response
    {

        $Formation = $FR->find($id);
        if ($Formation) {
            $entityManager->remove($Formation);
            $entityManager->flush();
            return  $this->json("DELETED");
        } else {
            return  $this->json("ERROR");
        }
    }
    /**
     * @Route("/find/{id}", name="Formation_show", methods={"GET"})
     */
    public function show($id, FormationRepository $FR): Response
    {
        return $this->json($FR->find($id));
    }

    /**
     * @Route("/update", name="Formation_edit", methods={"POST"})
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, SerializerInterface $SI): Response
    {
        $res = $request->getContent();
        $Formation = $SI->deserialize($res, Formation::class, 'json');

        if ($Formation) {
            $entityManager->persist($Formation);
            $entityManager->flush();
        }

        return $this->json($Formation);
    }
}
