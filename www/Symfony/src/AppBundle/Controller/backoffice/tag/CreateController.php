<?php

namespace AppBundle\Controller\backoffice\tag;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;
use AppBundle\Form\Type\TagType;

class CreateController extends Controller
{
    public function submitAction(Request $request)
    {
        $entity = new Tag();
        $form = $this->createForm(TagType::class, $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backoffice_tag'));
        }

        return ['entity' => $entity, 'form' => $form->createView()];
    }

    public function indexAction()
    {
        $entity = new Tag();
        $form = $this->createForm(TagType::class, $entity);

        return $this->render('backoffice/tag/create.html.twig', [
            'entity' => $entity, 'form' => $form->createView(),
        ]);
    }
}
