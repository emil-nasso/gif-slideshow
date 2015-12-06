<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Providers\Provider;
use GifSlideshow\Grabber;
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
     * @param Slideshow $slideshow
     * @return Response
     * @throws \Exception
     */
    public function nextGifAction(Slideshow $slideshow){
        /** @var Provider $provider */
        $provider = $this->get('app_weightable_randomizer')->getRandom($slideshow->getAllProviders());
        /** @var Grabber $grabber */
        $grabber = $this->get($provider->getServiceName());

        $gif = $grabber->getFromProvider($provider);
        return new Response($gif->getUrl());
    }

    /**
     * Creates a new Slideshow entity.
     *
     * @Route("/new", name="slideshow_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
     * @param Slideshow $slideshow
     * @return Response
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
     * @param Request $request
     * @param Slideshow $slideshow
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
     * @param Request $request
     * @param Slideshow $slideshow
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
