<?php
/**
 * Created by PhpStorm.
 * User: Kamil
 * Date: 2017-12-15
 * Time: 20:39
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Route("/", name="main-index")
     */
    public function indexAction(){
        return $this->render('welcome-page.html.twig');
    }

}