<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Foundation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Foundation controller.
 *
 */
class FoundationController extends Controller
{
    /**
     * Lists all foundation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $foundations = $em->getRepository('AppBundle:Foundation')->findAll();

        return $this->render('foundation/index.html.twig', array(
            'foundations' => $foundations,
        ));
    }

    /**
     * Creates a new foundation entity.
     *
     */
    public function newAction(Request $request)
    {
        $foundation = new Foundation();
        $form = $this->createForm('AppBundle\Form\FoundationType', $foundation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($foundation);
            $em->flush();

            return $this->redirectToRoute('foundation_index');
        }

        return $this->render('foundation/new.html.twig', array(
            'foundation' => $foundation,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing foundation entity.
     *
     */
    public function editAction(Request $request,Foundation $foundation)
    {
        $editForm = $this->createForm('AppBundle\Form\FoundationType', $foundation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('foundation_index');
        }

        return $this->render('foundation/edit.html.twig', array(
            'foundation' => $foundation,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a foundation entity.
     *
     */
    public function deleteAction(Foundation $foundation)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($foundation);
            $em->flush();


        return $this->redirectToRoute('foundation_index');
    }

}
