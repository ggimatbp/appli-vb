<?php

namespace App\Controller\Tabs\Manager;

use App\Entity\ApAccess;
use App\Form\ApAccessType;
use App\Repository\ApAccessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/ap/access")
 */
class ApAccessController extends AbstractController
{
    /**
     * @Route("/", name="ap_access_index", methods={"GET"})
     */
    public function index(ApAccessRepository $apAccessRepository): Response
    {
        return $this->render('ap_access/index.html.twig', [
            'ap_accesses' => $apAccessRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_access_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apAccess = new ApAccess();
        $form = $this->createForm(ApAccessType::class, $apAccess, array('tabId' => $apAccess->getTab()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apAccess);
            $entityManager->flush();

            return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_access/new.html.twig', [
            'ap_access' => $apAccess,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_access_show", methods={"GET"})
     */
    public function show(ApAccess $apAccess): Response
    {
        return $this->render('ap_access/show.html.twig', [
            'ap_access' => $apAccess,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_access_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApAccess $apAccess): Response
    {
        $form = $this->createForm(ApAccessType::class, $apAccess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_access/edit.html.twig', [
            'ap_access' => $apAccess,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_access_delete", methods={"POST"})
     */
    public function delete(Request $request, ApAccess $apAccess): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apAccess->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apAccess);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_access_index', [], Response::HTTP_SEE_OTHER);
    }
    
    /**
     * @route("/addAuthOnClick/{id}", name="add_auth_on_click")
     */
    
    public function addAuthOnClick(ApAccess $apAccess, EntityManagerInterface $manager) : response
    {
        if($apAccess->getAdd() == 1)
        {
            $apAccess->setAdd(0);
            $manager->flush();
        }
        else
        {
            $apAccess->setAdd(1);
            $manager->flush();
        }
        return $this->json(["code" => 200,
         "message" => "access add",
        "status" => $apAccess->getAdd()], 200);
    }

    /**
     * @route("/deleteAuthOnClick/{id}", name="delete_auth_on_click")
     */
    
    public function DeleteAuthOnClick(ApAccess $apAccess, EntityManagerInterface $manager) : response
    {
        if($apAccess->getDelete() == 1)
        {
            $apAccess->setDelete(0);
            $manager->flush();
        }
        else
        {
            $apAccess->setDelete(1);
            $manager->flush();
        }
        return $this->json(["code" => 200,
        "message" => "access delete",
        "status" => $apAccess->getDelete()], 200);
    }


    /**
     * @route("/editAuthOnClick/{id}", name="edit_auth_on_click")
    */

    public function editAuthOnClick(ApAccess $apAccess, EntityManagerInterface $manager) : response
    {
        if($apAccess->getEdit() == 1)
        {
            $apAccess->setEdit(0);
            $manager->flush();
        }
        else
        {
            $apAccess->setEdit(1);
            $manager->flush();
        }
        return $this->json(["code" => 200,
         "message" => "access Edit",
        "status" => $apAccess->getEdit()],
          200);
    }

    /**
     * @route("/viewAuthOnClick/{id}", name="view_auth_on_click")
    */

    public function viewAuthOnClick(ApAccess $apAccess, EntityManagerInterface $manager) : response
    {
        if($apAccess->getView() == 1)
        {
            $apAccess->setView(0);
            $manager->flush();
        }
        else
        {
            $apAccess->setView(1);
            $manager->flush();
        }
        return $this->json(["code" => 200,
        "message" => "access View",
        "status" => $apAccess->getView()], 200);
    }

}
