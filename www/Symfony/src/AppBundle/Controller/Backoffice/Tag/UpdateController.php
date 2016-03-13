<?php

namespace AppBundle\Controller\Backoffice\Tag;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\TagType;

class UpdateController extends Controller
{
    public function deleteAction($tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($em->getRepository('AppBundle:Tag')->find($tagId));
        $em->flush();

        return new Response($this->generateUrl('backoffice_tag'));
    }

    public function submitAction(Request $request, $tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Tag')->find($tagId);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(TagType::class, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_tag'));
        }

        return $this->render('backoffice/tag/update.html.twig', [
            'tag' => $entity,
            'form' => $editForm->createView(),
        ]);
    }

    public function indexAction($tagId)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Tag')->find($tagId);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(TagType::class, $entity);

        return $this->render('backoffice/tag/update.html.twig', [
            'tag' => $entity,
            'form' => $form->createView(),
        ]);
    }
}
