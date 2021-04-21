<?php

namespace App\Controller;

use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\NumberColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
