<?php

namespace NeptuneVs\Bundle\AgendaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserEventCarriereType extends AbstractType {

    private $niveauChoices;

    public function __construct(array $niveauChoices) {
        $this->niveauChoices = $niveauChoices;
    }

    public function buildForm(FormBuilder $builder, array $options) {

        $builder->add('niveau', 'choice', array('choices' => $this->niveauChoices))
                ->add('apero')
                ->add('user', 'hidden')
                ->add('event', 'hidden')
                ->add('scaphandre', 'hidden')
                ->add('apnee', 'hidden');
    }

    public function getName() {
        return 'neptunevs_bundle_agendabundle_usereventcarriere';
    }    
}