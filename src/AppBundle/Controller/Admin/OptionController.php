<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\MealOption;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/option")
 */
class OptionController extends Controller
{
    /**
     * @Route("/", name="option_index")
     */
    public function indexAction(){
        $mealOptionRep = $this->getDoctrine()->getRepository('AppBundle:MealOption');
        $mealOptions = $mealOptionRep->findAll();
        $deleteForms = [];
        foreach ($mealOptions as $mealOption){
            $deleteForms[$mealOption->getId()] = $this->createDeleteForm($mealOption)->createView();
        }
        return $this->render("admin/option/index.html.twig", [
            'options' => $mealOptions,
            'delete_forms' => $deleteForms,
        ]);
    }

    /**
     * @Route("/new", name="option_new")
     */
    public function newAction(Request $request){
        $mealOption = new MealOption();
        $form = $this->createForm('AppBundle\Form\MealOptionType', $mealOption);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($mealOption);
            $em->flush();

            return $this->redirectToRoute("option_index");
        }
        return $this->render("admin/option/new.html.twig",[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="option_edit")
     */
    public function editAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();
        $mealOption = $em->getRepository('AppBundle:MealOption')->find($id);
        $options = new ArrayCollection();
        foreach ($mealOption->getOptions() as $option){
            $options->add($option);
        }
        $form = $this->createForm('AppBundle\Form\MealOptionType', $mealOption);
        $form->handleRequest($request);

        if($form->isValid() && $form->isSubmitted()){
            foreach ($options as $option){
                if(false === $mealOption->getOptions()->contains($option)){
                    $em->remove($option);
                }
            }
            $em->persist($mealOption);
            $em->flush();

            return $this->redirectToRoute("option_index");
        }
        return $this->render("admin/option/edit.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="option_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MealOption $mealOption){
        $form = $this->createDeleteForm($mealOption);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $options = $mealOption->getOptions();
            foreach ($options as $option){
                $mealOption->removeOption($option);
                $em->remove($option);
            }
            $em->remove($mealOption);
            $em->flush();
        }

        return $this->redirectToRoute('option_index');
    }

    private function createDeleteForm(MealOption $mealOption){
        return $this->createFormBuilder($mealOption)
            ->setMethod('DELETE')
            ->setAction($this->generateUrl('option_delete', ['id' => $mealOption->getId()]))
            ->getForm();
    }
}