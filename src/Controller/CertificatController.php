<?php

namespace App\Controller;

use App\Entity\Condidat;
use App\Entity\Formateur;
use App\Entity\Certificat;
use App\Form\CertificatType;
use App\Repository\CondidatRepository;
use App\Repository\FormateurRepository;
use App\Repository\FormationRepository;
use App\Repository\CertificatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/certificat")
 */
class CertificatController extends AbstractController
{
    /**
     * @Route("/", name="Certificat_index", methods={"GET"})
     */
    public function index(CertificatRepository $CertificatRepository)
    {
        $ListCertificat = $CertificatRepository->findAll();
        return $this->Json($ListCertificat);
    }

    /**
     * @Route("/add", name="Certificat_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $SI, CondidatRepository $C, FormationRepository $t): Response
    {
        $cff = new Certificat();
        $f = $t->find(1);
        $can = $C->find(2);
        $cff->setCondidat($can);
        $cff->setFormation($f);
        $jsonObject = $SI->serialize($cff->getCondidat(), 'json');


       // $res = $request->getContent();
       // $Certificat = $SI->deserialize($res, Certificat::class, 'json');
        $entityManager->persist($cff);
        $entityManager->flush();
        return $this->json($jsonObject);
    }
    /**
     * @Route("/delete/{id}", name="Certificat_delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $entityManager, CertificatRepository $FR): Response
    {

        $Certificat = $FR->find($id);
        if ($Certificat) {
            $entityManager->remove($Certificat);
            $entityManager->flush();
            return  $this->json("DELETED");
        } else {
            return  $this->json("ERROR");
        }
    }
    /**
     * @Route("/find/{id}", name="Certificat_show", methods={"GET"})
     */
    public function show($id, CertificatRepository $FR): Response
    {
        return $this->json($FR->find($id));
    }
}
