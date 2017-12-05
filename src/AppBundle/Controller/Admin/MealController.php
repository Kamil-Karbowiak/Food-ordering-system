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
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/meal")
 */
class MealController extends Controller
{
    /**
     * @Route("/", name="meal_index")
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
     * @Route("/show/{id}", name="meal_show")
     */
    public function showAction(Meal $meal){
        return $this->render("admin/meal/show.html.twig", ["meal" => $meal]);
    }

    /**
     * @Route("/new", name="meal_new")
     */
    public function newAction(Request $request){
        $meal = new Meal();
        $form = $this->createForm('AppBundle\Form\MealType', $meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($meal);
            $em->flush();
            return $this->redirectToRoute("meal_index");
        }

        return $this->render("admin/meal/new.html.twig", ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="meal_edit")
     */
    public function editAction(Meal $meal, Request $request){
        $em            = $this->getDoctrine()->getManager();
        $restaurantRep = $em->getRepository('AppBundle:Restaurant');
        $categoryRep   = $em->getRepository('AppBundle:Category');
        $restaurants   = $restaurantRep->getAllAssoc();
        $categories    = $categoryRep->findAll();
        $form = $this->createForm(MealType::class, $meal, array(
            'restaurants' => $restaurants,
            'categories'  => $categories));
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
            return $this->redirectToRoute("meal_index");
        }
        return $this->render("admin/meal/edit.html.twig", [
            'form' => $form->createView(),
            'meal' => $meal]);
    }

    /**
     * @Route("/{id}", name="meal_delete")
     */
    public function deleteAction(Request $request, Meal $meal){
        $form = $this->createDeleteForm($meal);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($meal);
            $em->flush();
        }

        return $this->redirectToRoute("meal_index");
    }

    private function createDeleteForm(Meal $meal){
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('meal_delete', ['id' => $meal->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}