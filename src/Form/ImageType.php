<?php

namespace App\Form;

use App\Entity\TricksImages;
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
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4096k',
                        'maxSizeMessage' => 'L\'image est trop volumineuse (Max 4Mo)',
                        'mimeTypes' => ['image/jpeg', 'image/jpg', 'image/png'],
                        'mimeTypesMessage' => 'Veuillez vérifier le format de l\'image (seulement JPEG, JPG et PNG acceptés)',
                    ])
                ],
                'attr' => [
                    'class' => 'thumbnail-upload'
                ],
                'label' => 'Thumbnail',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        
    }
}
