<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class DownloadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('download', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'image' => 'image',
                    'pdf' => 'pdf',
                    'link' => 'link'
                ]
            ])
        ;
    }
}