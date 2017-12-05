<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cart-main")
     */
    public function indexAction()
    {
        return $this->render("cart/index.html.twig");
    }

    /**
     * @Route("/cart/add", name="cart-add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $id = $request->request->get('id');
        $meal = $this->getDoctrine()->getRepository('AppBundle:Meal')->find($id);
        $quantity = $request->request->get('mealQuantity');
        $cart = $this->container->get('shopping_cart');
        $cart->update($meal, $quantity);
        return $this->redirectToRoute("store-main");
    }
    /**
     * Deletes a category entity.
     *
     * @Route("cart/delete", name="cart_delete")
     */
    public function deleteAction(Request $request)
    {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('cart_item', $submittedToken)) {
            return $this->redirectToRoute('cart-main');
        }
        $id = $request->request->get('id');
        $em = $this->getDoctrine();
        $meal = $em->getRepository('AppBundle:Meal')->find($id);
        $cart = $this->container->get('shopping_cart');
        $cart->remove($meal);

        return $this->redirectToRoute('cart-main');
    }
}
