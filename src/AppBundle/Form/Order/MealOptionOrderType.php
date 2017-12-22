<?php
/**
 * Created by PhpStorm.
 * User: Kamil
 * Date: 2017-12-09
 * Time: 13:48
 */

namespace AppBundle\Form\Order;

use AppBundle\Entity\Meal;
use AppBundle\Entity\MealOption;
use AppBundle\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealOptionOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
             $builder
                 ->add(
                     $builder->create('mealOptions', CollectionType::class)
                     ->$builder->create('options', CollectionType::class)
                 );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }

}