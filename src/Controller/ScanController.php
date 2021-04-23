<?php

namespace App\Controller;

use App\Entity\Scan;
use App\Entity\User;
use App\Form\ScanType;
use App\Message\Scan as MessageScan;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
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
    public function index(DataTableFactory $dataTableFactory, Request $request): Response
    {
        $table = $dataTableFactory->create([])
            ->add('id', NumberColumn::class, ['label' => '#', 'className' => 'bold', 'searchable' => true])
            ->add('created_at', DateTimeColumn::class, ['label' => 'Created at', 'className' => 'bold', 'searchable' => true, 'format' => 'd-m-Y H:i:s'])
            ->add('firstname', TextColumn::class, ['label' => 'Firstname', 'className' => 'bold', 'searchable' => true, 'field' => 'u.firstname'])
            ->add('lastname', TextColumn::class, ['label' => 'Lastname', 'className' => 'bold', 'searchable' => true, 'field' => 'u.lastname'])
            ->add('code', TextColumn::class, ['label' => 'Code', 'className' => 'bold', 'searchable' => true])
            ->add('actions', TwigColumn::class, ['label' => 'Actions', 'className' => 'bold', 'searchable' => true, 'template' => 'scan/_partials/table/actions.html.twig'])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Scan::class,
                'hydrate' => Query::HYDRATE_ARRAY,
                'query' => function(QueryBuilder $builider) {
                    $builider
                        ->addSelect('u.firstname')
                        ->addSelect('u.lastname')
                        ->addSelect('s.id')
                        ->addSelect('s.code')
                        ->addSelect('s.created_at')
                        ->from(Scan::class, 's')
                        ->leftJoin(User::class, 'u', Join::WITH, 'u.id = s.userId');
                }
            ]);
            $table->handleRequest($request);
        
        
            if ($table->isCallback()) {
                return $table->getResponse();
            }  
        return $this->render('scan/index.html.twig', [
            'controller_name' => 'ScanController',
            'datatable' => $table
        ]);
    }

    /**
     * @Route("/scan/new", name="scan_new")
     */
    public function new(Request $request): Response
    {   
        $scan = new Scan;
        $form = $this->createForm(ScanType::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userID = $this->getUser()->getId();
            $createdAt = new \DateTime;
            $code = $form->get('code')->getData();
            $photo = $form->get('photo')->getData();

            $this->dispatchMessage(new MessageScan($createdAt, $code, $userID, $photo));

            return $this->redirectToRoute('scan_new');
        }
        
        return $this->render('scan/new.html.twig', [
            'controller_name' => 'ScanController',
            'form' => $form->createView()
        ]);
    }
}
