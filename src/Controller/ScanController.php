<?php

namespace App\Controller;

use App\Entity\Scan;
use App\Form\ScanType;
use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\NumberColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScanController extends AbstractController
{
    /**
     * @Route("/scan", name="scan")
     */
    public function index(DataTableFactory $dataTableFactory): Response
    {
        $table = $dataTableFactory->create([])
            ->add('id', NumberColumn::class, ['label' => '#', 'className' => 'bold', 'searchable' => true])
            ->add('created_at', DateTimeColumn::class, ['label' => 'Created at', 'className' => 'bold', 'searchable' => true, 'format' => 'd-m-Y H:i:s'])
            ->add('firstname', TextColumn::class, ['label' => 'Firstname', 'className' => 'bold', 'searchable' => true])
            ->add('lastname', TextColumn::class, ['label' => 'Lastname', 'className' => 'bold', 'searchable' => true])
            ->add('code', TextColumn::class, ['label' => 'Code', 'className' => 'bold', 'searchable' => true])
            ->add('actions', TwigColumn::class, ['label' => 'Actions', 'className' => 'bold', 'searchable' => true, 'template' => 'scan/_partials/table/actions.html.twig']);

        return $this->render('scan/index.html.twig', [
            'controller_name' => 'ScanController',
            'datatble' => $table
        ]);
    }

    /**
     * @Route("/scan/new", name="scan_new")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {   
        $scan = new Scan;
        $form = $this->createForm(ScanType::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scan->setUserId($this->getUser());
            $scan->setCreatedAt(new \DateTime);
            $em->persist($scan);
            $em->flush();

            return $this->redirectToRoute('scan_new');
        }
        
        return $this->render('scan/new.html.twig', [
            'controller_name' => 'ScanController',
            'form' => $form->createView()
        ]);
    }
}
