<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Meal;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/cart")
 */
class CartController extends Controller
{
    /**
     * @Route("/", name="cart-main")
     */
    public function indexAction()
    {
        return $this->render("cart/index.html.twig");
    }

    /**
     * @Route("/{id}/add", name="cart-add")
     * @param Meal $meal
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Meal $meal, Request $request)
    {
        if($request->request->has('add-cart-submit')){
            $orderItem = new OrderItem($meal);
            $quantity = $request->request->get('meal-quantity');
            $orderItem->setQuantity($quantity);

            if($request->request->has('select-meal-options')) {
                foreach ($request->request->get('select-meal-options') as $option) {
                    $option = $this->getDoctrine()->getRepository('AppBundle:Option')->find($option);
                    $orderItem->addSelectedOption($option);
                }
            }
            $cart = $this->container->get('shopping_cart');
            try{
                $cart->add($orderItem);
                $this->addFlash('success', 'The meal has been added to the shopping cart');
            }catch(\Exception $ex){
                $this->addFlash('danger', $ex->getMessage());
            }
            return $this->redirectToRoute('meal-index');
        }
        return $this->render("cart/add.html.twig", [
            'meal' => $meal,
        ]);
    }

    /**
     * @Route("/checkout", name="cart-checkout")
     */
    public function checkoutAction(Request $request){
        $customer = new Customer();
        $form = $this->createForm('AppBundle\Form\CustomerType', $customer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $cart = $this->container->get('shopping_cart');
            $orderItems = $cart->all();
            $amount = $cart->getSubTotal();

            $order = new Order();
            $order->setCustomer($customer);
            $order->setOrderItems($orderItems);
            $order->setAmount($amount);
            $order->setPaid(true);

            $em->persist($order);
            $em->flush();
            $cart->clear();
            $this->addFlash('success', 'Your order is being processed');
            return $this->redirectToRoute('meal-index');
        }

        return $this->render("cart/checkout.html.twig", [
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a category entity.
     *
     * @Route("/delete", name="cart-delete")
     */
    public function deleteAction(Request $request)
    {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('cart_item', $submittedToken)) {
            return $this->redirectToRoute('cart-main');
        }
        $id = $request->request->get('id');
        $cart = $this->container->get('shopping_cart');
        $cart->remove($id);

        return $this->redirectToRoute('cart-main');
    }
}
