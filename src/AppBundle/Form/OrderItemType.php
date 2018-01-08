<?php
namespace AppBundle\Form;

use AppBundle\Entity\Meal;
use AppBundle\Entity\MealOption;
use AppBundle\Entity\Option;
use AppBundle\Form\Order\OptionOrderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                $builder->create('meal', FormType::class, [
                        'data_class' => Meal::class,
                        'label' => false,
                        ])
                        ->add(
                            $builder->create('mealOptions', CollectionType::class, [
                                'entry_type' => FormType::class,
                                'entry_options' => [
                                    'data_class' => MealOption::class,
                                ]
                                ])
                                ->add('name')
                            ->add(
                                $builder->create('options', CollectionType::class, [
                                    'entry_type' => FormType::class,
                                    'entry_options' => [
                                        'data_class' => Option::class,
                                    ]
                                    ])->add('value')))
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'  => 'AppBundle\Entity\OrderItem',
        ]);
    }
}