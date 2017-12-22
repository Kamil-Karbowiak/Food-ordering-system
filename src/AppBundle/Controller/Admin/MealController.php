<?php
/**
 * Created by PhpStorm.
 * User: Kamil
 * Date: 2017-11-21
 * Time: 18:14
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Meal;
use AppBundle\Form\MealType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("admin/meal")
 */
class MealController extends Controller
{
    /**
     * @Route("/", name="admin-meal-index")
     */
    public function indexAction(){
        $em = $this->getDoctrine();
        $meals = $em->getRepository('AppBundle:Meal')->findAll();
        $deleteForms = [];
        foreach ($meals as $meal){
            $deleteForms[$meal->getId()] = $this->createDeleteForm($meal)->createView();
        }

        return $this->render("admin/meal/index.html.twig",[
            'meals' => $meals,
            'delete_forms' => $deleteForms]);
    }

    /**
     * @Route("/show/{id}", name="admin-meal-show")
     */
    public function showAction(Meal $meal){
        return $this->render("admin/meal/show.html.twig", ["meal" => $meal]);
    }

    /**
     * @Route("/new", name="admin-meal-new")
     */
    public function newAction(Request $request){
        $meal = new Meal();
        $form = $this->createForm('AppBundle\Form\MealType', $meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image = $meal->getImage2();
            if($image){
                $imageName = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('img_meals_directory'),
                    $imageName
                );
                $meal->setImage($imageName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();
            return $this->redirectToRoute("admin-meal-index");
        }

        return $this->render("admin/meal/new.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="admin-meal-edit")
     */
    public function editAction(Meal $meal, Request $request){
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image = $meal->getImage2();
            if($image){
                $imageName = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('img_meals_directory'),
                    $imageName
                );
                $meal->setImage($imageName);
            }
            $em->persist($meal);
            $em->flush();
            return $this->redirectToRoute("admin-meal-index");
        }
        return $this->render("admin/meal/edit.html.twig", [
            'form' => $form->createView(),
            'meal' => $meal]);
    }

    /**
     * @Route("/{id}", name="admin-meal-delete")
     */
    public function deleteAction(Request $request, Meal $meal){
        $form = $this->createDeleteForm($meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($meal);
            $em->flush();
        }

        return $this->redirectToRoute("admin-meal-index");
    }

    private function createDeleteForm(Meal $meal){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin-meal-delete', ['id' => $meal->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}