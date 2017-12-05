<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Meal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MealController extends Controller
{
    /**
     * @Route("/", name="store-main")
     */
    public function indexAction(Request $request)
    {
        $meals = $this->getDoctrine()->getRepository('AppBundle:Meal')->findAll();
        return $this->render("store/index.html.twig", ['meals' => $meals]);
    }

    /**
     * @Route("meal/{id}", name="store-show")
     */
    public function showAction(Meal $meal)
    {
        $cart = $this->container->get('shopping_cart');
        $quantity = $cart->getQuantity($meal);
        return $this->render("store/show.html.twig",
            ['meal'    => $meal,
            'quantity' => $quantity]);
    }
}