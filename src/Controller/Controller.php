<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Form\ArgoFormuType;
use App\Entity\Argonaute;
use App\Service\ServiceArgonaute;


class Controller extends AbstractController
{
    /**
     * @Route("/", name="Page_principale")
     */
    public function index(ServiceArgonaute $paraService): Response
    {
        $NouvelArgo = new Argonaute();
        //$formu = $this->createForm( Argonaute::class, $NouvelArgo); 
        $formu = $this->createFormBuilder($NouvelArgo)
            ->add('Name')
            ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
            ->getForm();
        $NouvelArgo = $formu->getData();
        $paraService->addArgonaute($NouvelArgo);
        return $this->render('/index.html.twig', [
            //'controller_name' => 'Controller',
            'formulaire' => $formu->createView(),
            'listeArgonaute' => $paraService->getListeArgonautes(),
            ]
        );
    }
}
