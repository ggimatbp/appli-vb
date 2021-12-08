<?php

namespace App\Controller\Tabs\Catalog;



use App\Entity\ApCatalogModelBp;
use App\Form\ApCatalogModelBpType;
use App\Repository\ApCatalogCustomerBpRepository;
use App\Repository\ApCatalogModelBpRepository;
use App\Repository\ApCatalogFilesBpRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/ap/catalog/model/bp")
 */
class ApCatalogModelBpController extends AbstractController
{
    /**
     * @Route("/", name="ap_catalog_model_bp_index", methods={"GET"})
     */
    public function index(ApCatalogModelBpRepository $apCatalogModelBpRepository, ApCatalogCustomerBpRepository $apCatalogCustomerBpRepository): Response
    {
        return $this->render('tabs/Catalog/ap_catalog_model_bp/index.html.twig', [
            'ap_catalog_model_bps' => $apCatalogModelBpRepository->findAll(),
            'ap_catalog_customer_bps' => $apCatalogCustomerBpRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_catalog_model_bp_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apCatalogModelBp = new ApCatalogModelBp();
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/new.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/newPrecise/{id}", name="ap_catalog_model_bp_new_precise", methods={"GET","POST"})
     */
    public function newWithModel(Request $request, ApCatalogCustomerBpRepository $customerBpRepository): Response
    {
        $apCatalogModelBp = new ApCatalogModelBp();
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);
        $id = intval(basename("$_SERVER[REQUEST_URI]"));
        if ($form->isSubmitted() && $form->isValid()) {
            $customer = $customerBpRepository->find($id);
            $apCatalogModelBp->setCustomer($customer);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apCatalogModelBp);
            $entityManager->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/new.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_model_bp_show", methods={"GET"})
     */
    public function show(ApCatalogModelBp $apCatalogModelBp, ApCatalogFilesBpRepository $ApCatalogFilesBpRepository): Response
    {
        
        $id = $apCatalogModelBp->getId();
        $files = $ApCatalogFilesBpRepository->findAllById($id);
        return $this->render('tabs/Catalog/ap_catalog_model_bp/show.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp, 'files' => $files
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_catalog_model_bp_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApCatalogModelBp $apCatalogModelBp): Response
    {
        $form = $this->createForm(ApCatalogModelBpType::class, $apCatalogModelBp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tabs/Catalog/ap_catalog_model_bp/edit.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_catalog_model_bp_delete", methods={"POST"})
     */
    public function delete(Request $request, ApCatalogModelBp $apCatalogModelBp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apCatalogModelBp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apCatalogModelBp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_catalog_model_bp_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/pdf/{id}", name="pdf_js", methods={"GET"})
     */
    public function testPdfJs(ApCatalogModelBp $apCatalogModelBp, ApCatalogFilesBpRepository $ApCatalogFilesBpRepository): Response
    {
        
        $id = $apCatalogModelBp->getId();
        $files = $ApCatalogFilesBpRepository->findAllById($id);
        return $this->render('tabs/Catalog/ap_catalog_model_bp/Testshow.html.twig', [
            'ap_catalog_model_bp' => $apCatalogModelBp, 'files' => $files
        ]);
    }
}
