<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    /**
     * Lists all event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }

    /**
     * Creates a new event entity.
     *
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('AppBundle\Form\EventType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing event entity.
     *
     */
    public function editAction(Request $request, Event $event)
    {
        $editForm = $this->createForm('AppBundle\Form\EventType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a event entity.
     *
     */
    public function deleteAction(Event $event)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();
        return $this->redirectToRoute('event_index');
    }
 public function indexFrontAction()
 {
     $em=$this->getDoctrine()->getManager() ;
     $events = $em->getRepository(Event::class)->findAll();

     return $this->render('event/front/indexFront.html.twig' , array('events'=>$events));
 }


 public function showEventAction(Event $event)
 {
     $isparticipated=false;
     $em=$this->getDoctrine()->getManager() ;
     $user=$this->getUser();
     if($user!=null)
     {
         $participant=$this->getDoctrine()->getRepository(Participant::class)->findOneBy(array(
             'user'=>$user,
             'event'=>$event,
         ));
         if ($participant!=null)
             $isparticipated=true;
     }

     $participants=$this->getDoctrine()->getRepository(Participant::class)->findBy(array(
        'event'=>$event
     ));



     return $this->render('event/front/event_details.html.twig', array('event'=>$event,
         'isparticipated'=>$isparticipated,
         'nbr'=>count($participants)
     ));

 }

 public function particperAction(Event $event)
 {
     $user= $this->getUser();
     $em=$this->getDoctrine()->getManager();
     if($user!=null){
         $participants=$this->getDoctrine()->getRepository(Participant::class)->findOneBy(array(
            'user'=>$user,
            'event'=>$event,
         ));
         if($participants!=null)
         {

             $em->remove($participants);
             $isparticipated=false;
         }
         else{
             $particpant= new Participant();
             $particpant->setUser($user);
             $particpant->setEvent($event);
             $em->persist($particpant);
             $isparticipated=true;
         }

         $em->flush();

         return $this->redirectToRoute('show_infos',array(
             'id'=>$event->getId(),
         ));

     } else{

         return $this->redirectToRoute('fos_user_security_login');
     }

 }

    public function participantsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $participants = $em->getRepository(Participant::class)->findAll();

        return $this->render('event/participants.html.twig', array(
            'participants' => $participants,
        ));
    }

}
