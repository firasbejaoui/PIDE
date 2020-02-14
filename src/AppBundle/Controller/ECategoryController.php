<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ECategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ecategory controller.
 *
 */
class ECategoryController extends Controller
{
    /**
     * Lists all eCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $eCategories = $em->getRepository('AppBundle:ECategory')->findAll();

        return $this->render('ecategory/index.html.twig', array(
            'eCategories' => $eCategories,
        ));
    }

    /**
     * Creates a new eCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $eCategory = new Ecategory();
        $form = $this->createForm('AppBundle\Form\ECategoryType', $eCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eCategory);
            $em->flush();

            return $this->redirectToRoute('event_category_index');
        }

        return $this->render('ecategory/new.html.twig', array(
            'eCategory' => $eCategory,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing eCategory entity.
     *
     */
    public function editAction(Request $request, ECategory $eCategory)
    {
        $editForm = $this->createForm('AppBundle\Form\ECategoryType', $eCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_category_index');
        }

        return $this->render('ecategory/edit.html.twig', array(
            'eCategory' => $eCategory,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a eCategory entity.
     *
     */
    public function deleteAction(ECategory $eCategory)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($eCategory);
            $em->flush();

        return $this->redirectToRoute('event_category_index');
    }

}
