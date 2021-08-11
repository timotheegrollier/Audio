<?php

namespace App\Form;

use App\Entity\Sound;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EditSoundType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isEdit = $options['method'] === 'PUT';
        $builder
            ->add('soundFile', VichFileType::class, [
                'required' => true,
                'label' => 'Votre son (mp3 / ogg / aac) : ',
                'allow_delete' => false,
                'download_uri' => false,
                'asset_helper' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '200M',
                        'mimeTypes' => [
                            "audio/mpeg",
                            "audio/ogg",
                            'audio/x-hx-aac-adts',
                        ],
                        'mimeTypesMessage' => 'Votre son doit être au format {{ types }}'
                    ]),
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG or PNG file)',
                'required' => false,
                'imagine_pattern' => 'edit_img',
                'allow_delete' => true,
                'download_uri' => false,
                'asset_helper' => false,

            ])

            ->add('titre', TextType::class, ['attr' => ['placeholder' => 'Name your sound ...']])
            ->add('description', TextareaType::class, ['attr' => ['placeholder' => 'Explain your sound ...']])
            ->add('type', EntityType::class, ['class' => Type::class, 'choice_label' => 'name'])
            ->add('download', CheckboxType::class, ['label' => 'Autoriser les téléchargements']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sound::class,
        ]);
    }
}