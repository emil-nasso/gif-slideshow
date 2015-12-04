<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Slideshow;
use AppBundle\Form\SlideshowType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Slideshow controller.
 *
 * @Route("/slideshow")
 */
class SlideshowController extends Controller
{
    /**
     * Lists all Slideshow entities.
     *
     * @Route("/", name="slideshow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $slideshows = $em->getRepository('AppBundle:Slideshow')->findAll();

        return $this->render('slideshow/index.html.twig', array(
            'slideshows' => $slideshows,
        ));
    }

    /**
     * @Route("/{id}/nextgif", name="slideshow_next_gif")
     */
    public function nextGifAction(Slideshow $slideshow){
        $gif = $this->get('app_gifgrabber')->run($slideshow);
        return new Response($gif->getUrl());
    }

    /**
     * Creates a new Slideshow entity.
     *
     * @Route("/new", name="slideshow_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $slideshow = new Slideshow();
        $form = $this->createForm(SlideshowType::class, $slideshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slideshow);
            $em->flush();

            return $this->redirectToRoute('slideshow_show', array('id' => $slideshow->getId()));
        }

        return $this->render('slideshow/new.html.twig', array(
            'slideshow' => $slideshow,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Slideshow entity.
     *
     * @Route("/{id}", name="slideshow_show")
     * @Method("GET")
     */
    public function showAction(Slideshow $slideshow)
    {
        $deleteForm = $this->createDeleteForm($slideshow);

        return $this->render('slideshow/show.html.twig', array(
            'slideshow' => $slideshow,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Slideshow entity.
     *
     * @Route("/{id}/edit", name="slideshow_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Slideshow $slideshow)
    {
        $deleteForm = $this->createDeleteForm($slideshow);
        $editForm = $this->createForm(SlideshowType::class, $slideshow);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slideshow);
            $em->flush();

            return $this->redirectToRoute('slideshow_edit', array('id' => $slideshow->getId()));
        }

        return $this->render('slideshow/edit.html.twig', array(
            'slideshow' => $slideshow,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Slideshow entity.
     *
     * @Route("/{id}", name="slideshow_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Slideshow $slideshow)
    {
        $form = $this->createDeleteForm($slideshow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($slideshow);
            $em->flush();
        }

        return $this->redirectToRoute('slideshow_index');
    }

    /**
     * Creates a form to delete a Slideshow entity.
     *
     * @param Slideshow $slideshow The Slideshow entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Slideshow $slideshow)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('slideshow_delete', array('id' => $slideshow->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
