<?php

namespace App\Form;

use App\Entity\Diplome;
use App\Entity\Ppn;
use App\Repository\DiplomeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PpnType extends AbstractType
{
    protected $formation;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->formation = $options['formation'];

        $builder
            ->add('libelle', TextType::class, ['label' => 'label.libelle'])
            ->add('annee', TextType::class, ['label' => 'label.annee_sortie'])
            ->add('diplome', EntityType::class,[
                    'class' => Diplome::class,
                    'required' => false,
                    'choice_label' => 'libelle',
                    'query_builder' => function (DiplomeRepository $diplomeRepository) {
                        return $diplomeRepository->findByFormationBuilder($this->formation);
                    },
                    'label' => 'label.diplome'
                ]
                )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ppn::class,
            'formation' => null,
            'translation_domain' => 'form'

        ]);
    }
}
