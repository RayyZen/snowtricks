<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('thumbnail', FileType::class, [
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'maxSizeMessage' => 'L\'image est trop volumineuse (Max 4Mo)',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => 'Only .JPEG, .JPG or .PNG are allowed',
                    ])
                ],
                'attr' => [
                    'class' => 'thumbnail-upload'
                ],
                'label' => 'Thumbnail',
            ])
            ->add('additional', FileType::class, [
                'mapped' => false,
                'multiple' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'maxSizeMessage' => 'L\'image est trop volumineuse (Max 4Mo)',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => 'Only .JPEG, .JPG or .PNG are allowed)',
                    ])
                ],
                'attr' => [
                    'class' => 'aditional-upload'
                ],
                'label' => 'Additional Images',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}
