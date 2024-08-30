<?php

namespace App\Form;

use App\Entity\customer;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Product Name',
                'attr' => [
                    'class' => 'form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm',
                    'placeholder' => 'Enter product name'
                ],
                'required' => true,
            ])
            ->add('stock', IntegerType::class, [
                'label' => 'Stock Quantity',
                'attr' => [
                    'class' => 'form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm',
                    'placeholder' => 'Enter stock quantity'
                ],
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm',
                    'rows' => 4,
                    'placeholder' => 'Enter product description'
                ],
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'currency' => 'EUR',
                'attr' => [
                    'class' => 'form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm',
                    'placeholder' => 'Enter price'
                ],
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
