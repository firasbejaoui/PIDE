<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Foundation;
use AppBundle\Entity\Membre;
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

    public function showFoundationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $foundations = $em->getRepository('AppBundle:Foundation')->findAll();

        return $this->render('foundation/front/index.html.twig', array(
            'foundations' => $foundations,
        ));
    }

    public function showFoundationAction(Foundation $foundation)
    {
        $ismember=false;
        $em=$this->getDoctrine()->getManager() ;
        $user=$this->getUser();
        if($user!=null)
        {
            $member=$this->getDoctrine()->getRepository(Membre::class)->findOneBy(array(
                'user'=>$user,
                'foundation'=>$foundation,
            ));
            if ($member!=null)
                $ismember=true;
        }

        $members=$this->getDoctrine()->getRepository(Membre::class)->findBy(array(
            'foundation'=>$foundation
        ));
        return $this->render('foundation/front/foundation.html.twig',array(
            'foundation'=>$foundation,
            'nbr'=>count($members),
            'ismember'=> $ismember,
            'member'=>$member
        ));
    }

    public function joinAction(Foundation $foundation)
    {
        $user= $this->getUser();
        $em=$this->getDoctrine()->getManager();
        if($user!=null){
            $membres=$this->getDoctrine()->getRepository(Membre::class)->findOneBy(array(
                'user'=>$user,
                'foundation'=>$foundation,
            ));
            if($membres!=null)
            {

                $em->remove($membres);
                $ismembre=false;
            }
            else{
                $membre= new Membre();
                $membre->setUser($user);
                $membre->setFoundation($foundation);
                $membre->setStatus(false);
                $em->persist($membre);
                $ismembre=true;
            }

            $em->flush();

            return $this->redirectToRoute('show_foundation',array(
                'id'=>$foundation->getId(),
            ));

        } else{

            return $this->redirectToRoute('fos_user_security_login');
        }

    }

    public function membresAction()
    {
        $em = $this->getDoctrine()->getManager();

        $membres = $em->getRepository(Membre::class)->findAll();

        return $this->render('foundation/members.html.twig', array(
            'membres' => $membres,
        ));
    }

    public function approveAction(Membre $membre)
    {
        $membre->setStatus(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('show_members');
    }

}
