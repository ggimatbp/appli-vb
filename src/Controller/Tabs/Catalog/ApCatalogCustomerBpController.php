<?php

namespace App\Controller\Tabs\Catalog;

use App\Entity\ApCatalogCustomerBp;
use App\Form\ApCatalogCustomerBpType;
use App\Repository\ApCatalogCustomerBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApCatalogFilesBpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GlobalHistoryService;

/**
 * @Route("/ap/catalog/customer/bp")
 */
class ApCatalogCustomerBpController extends AbstractController
{
    const TAB_BP = "Batteries-Prod";

    /**
     * @Route("/", name="ap_catalog_customer_bp_index", methods={"GET"})
     */
    public function index(ApCatalogCustomerBpRepository $apCatalogCustomerBpRepository): Response
    {
        return $this->render('tabs/Catalog/ap_catalog_customer_bp/index.html.twig', [
            'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_catalog_customer_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request, GlobalHistoryService $GlobalHistoryService): Response
    {
        $tabName = self::TAB_BP;
        $apCatalogCustomerBp = new ApCatalogCustomerBp();
        $form = $this->createForm(ApCatalogCustomerBpType::class, $apCatalogCustomerBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogCustomerBp);
            $entityManager->flush();
            $GlobalHistoryService->setInHistory($apCatalogCustomerBp, 'new', ['attention']);

            return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
            //return $this->redirectToRoute('ap_catalog_customer_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_customer_bp/new.html.twig', [
            'ap_catalog_customer_bp' => $apCatalogCustomerBp,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_customer_bp_show", methods={"GET"})
     */
    public function show(ApCatalogCustomerBp $apCatalogCustomerBp, ApCatalogModelBpRepository $apCatalogModelBpRepository, $id): Response
    {
        $tabName = self::TAB_BP;
        $id = $apCatalogCustomerBp->getId();
        $ModelById = $apCatalogModelBpRepository->findAllById($id);
        return $this->render('tabs/Catalog/ap_catalog_customer_bp/show.html.twig', [
            'ap_catalog_customer_bp' => $apCatalogCustomerBp,
            'ModelById' => $ModelById,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_customer_bp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogCustomerBp $apCatalogCustomerBp): Response
    {
        $tabName = self::TAB_BP;
        $form = $this->createForm(ApCatalogCustomerBpType::class, $apCatalogCustomerBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_customer_bp/edit.html.twig', [
            'ap_catalog_customer_bp' => $apCatalogCustomerBp,
            'form' => $form,
            'tabName' => $tabName
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_customer_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogCustomerBp $apCatalogCustomerBp): Response
    {
        if ($this->isCsrfTokenValid('delete' . $apCatalogCustomerBp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogCustomerBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     *@Route("/archive/{id}", name="ap_catalog_customer_bp_archive", methods={"GET","POST"})
     */
    public function archive(ApCatalogCustomerBp $apCatalogCustomerBp, ApCatalogModelBpRepository $apCatalogModelBpRepository, ApCatalogFilesBpRepository $apCatalogFilesBpRepository, Request $request): Response
    {
        if ($this->isCsrfTokenValid('archiver' . $apCatalogCustomerBp->getId(), $request->request->get('_token')))
        {
            if ($apCatalogCustomerBp->getArchive() == 0) {
                $apCatalogCustomerBp->setArchive(1);
                $customerId = $apCatalogCustomerBp->getId();
                $allModelByCustomerId = $apCatalogModelBpRepository->findAllById($customerId);
                foreach ($allModelByCustomerId as $model) {
                    $model->setArchive(1);
                    $modelId = $model->getId();
                    $allFileByModelId = $apCatalogFilesBpRepository->findAllById($modelId);
                    foreach ($allFileByModelId as $file) {
                        $file->setArchive(1);
                    }
                }
            } else {
                $apCatalogCustomerBp->setArchive(0);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogCustomerBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('catalog_index', [], Response::HTTP_SEE_OTHER);
    }
}
