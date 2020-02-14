<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fcategory controller.
 *
 */
class FCategoryController extends Controller
{
    /**
     * Lists all fCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fCategories = $em->getRepository('AppBundle:FCategory')->findAll();

        return $this->render('fcategory/index.html.twig', array(
            'fCategories' => $fCategories,
        ));
    }

    /**
     * Creates a new fCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $fCategory = new Fcategory();
        $form = $this->createForm('AppBundle\Form\FCategoryType', $fCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fCategory);
            $em->flush();

            return $this->redirectToRoute('fondations_category_index');
        }

        return $this->render('fcategory/new.html.twig', array(
            'fCategory' => $fCategory,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing fCategory entity.
     *
     */
    public function editAction(Request $request, FCategory $fCategory)
    {
        $editForm = $this->createForm('AppBundle\Form\FCategoryType', $fCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fondations_category_index');
        }

        return $this->render('fcategory/edit.html.twig', array(
            'fCategory' => $fCategory,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a fCategory entity.
     *
     */
    public function deleteAction( FCategory $fCategory)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($fCategory);
            $em->flush();

        return $this->redirectToRoute('fondations_category_index');
    }

}
