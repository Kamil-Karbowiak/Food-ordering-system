<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use AppBundle\Entity\MenuOptions;
use AppBundle\Entity\Restaurant;
use AppBundle\Entity\Variant;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MealType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price', MoneyType::class)
            ->add('quantity', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('image2', FileType::class, array(
                'label' => 'Choose image:  ',
                'data_class' => null,
                'required'    => false,
            ))
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('c');
                }])
            ->add('restaurant', EntityType::class, [
                'class' => Restaurant::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('r');
                }])
            ->add('save', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'  => 'AppBundle\Entity\Meal',
            'restaurants' => null,
            'categories'  => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_meal';
    }


}
