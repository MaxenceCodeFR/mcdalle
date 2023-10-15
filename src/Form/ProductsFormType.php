<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Allergens;
use App\Entity\Categories;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\CategoriesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: [
                'label' => 'Nom du produit'
            ])
            ->add('images')
            ->add('price', MoneyType::class, options: [
                'label' => 'Prix du produit'
            ])
            ->add('categories_id', EntityType::class, options: [
                'class' => Categories::class,
                'choice_label' => 'name',
                'group_by' => 'parent_id.name',
                'query_builder' => function (CategoriesRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->where('c.parent_id IS NOT NULL')
                        ->orderBy('c.parent_id', 'ASC');
                }

            ])
            ->add('allergens', EntityType::class, options: [
                'class' => Allergens::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Allergènes'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
