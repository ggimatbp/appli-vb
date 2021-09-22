<?php

namespace App\Controller;

use App\Entity\ApEmployee;
use App\Form\ApEmployeeType;
use App\Repository\ApEmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ap/employee")
 */
class ApEmployeeController extends AbstractController
{
    /**
     * @Route("/", name="ap_employee_index", methods={"GET"})
     */
    public function index(ApEmployeeRepository $apEmployeeRepository): Response
    {
        return $this->render('ap_employee/index.html.twig', [
            'ap_employees' => $apEmployeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ap_employee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $apEmployee = new ApEmployee();
        $form = $this->createForm(ApEmployeeType::class, $apEmployee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($apEmployee);
            $entityManager->flush();

            return $this->redirectToRoute('ap_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_employee/new.html.twig', [
            'ap_employee' => $apEmployee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_employee_show", methods={"GET"})
     */
    public function show(ApEmployee $apEmployee): Response
    {
        return $this->render('ap_employee/show.html.twig', [
            'ap_employee' => $apEmployee,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ap_employee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ApEmployee $apEmployee): Response
    {
        $form = $this->createForm(ApEmployeeType::class, $apEmployee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ap_employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ap_employee/edit.html.twig', [
            'ap_employee' => $apEmployee,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ap_employee_delete", methods={"POST"})
     */
    public function delete(Request $request, ApEmployee $apEmployee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apEmployee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($apEmployee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ap_employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
