<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/meal")
 */
class MealController extends Controller
{
    /**
     * @Route("/", name="meal-index")
     */
    public function indexAction(Request $request)
    {
        $meals = $this->getDoctrine()->getRepository('AppBundle:Meal')->findAll();
        return $this->render("store/index.html.twig", ['meals' => $meals]);
    }

    /**
     * @Route("/{id}", name="meal-show")
     */
    public function showAction(Meal $meal)
    {
        return $this->render("store/show.html.twig", [
            'meal' => $meal,
        ]);
    }


}