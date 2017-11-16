<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class MealController extends Controller
{
    /**
     * @Route("/", name="store-main")
     */
    public function indexAction(Request $request)
    {
        $isAjax = $request->isXmlHttpRequest();
        if($isAjax){
            $id = $request->request->get('id');
            $meal = $this->getDoctrine()->getRepository('AppBundle:Meal')->find($id);
            $mealJSON = json_encode($meal);
            return new Response($mealJSON);
        }
        $meals = $this->getDoctrine()->getRepository('AppBundle:Meal')->findAll();
        return $this->render("store/index.html.twig", ['meals' => $meals]);
    }

    /**
     * @Route("meal/{id}", name="store-show")
     */
    public function showAction($id)
    {
        $meal = $this->getDoctrine()->getRepository('AppBundle:Meal')->find($id);
        return $this->render("store/showMeal.html.twig", ['meal'=>$meal]);
    }
}