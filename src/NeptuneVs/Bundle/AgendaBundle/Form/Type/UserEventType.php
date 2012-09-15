<?php

namespace NeptuneVs\Bundle\AgendaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserEventType extends AbstractType {

    private $niveauChoices;

    public function __construct(array $niveauChoices) {
        $this->niveauChoices = $niveauChoices;
    }

    public function buildForm(FormBuilder $builder, array $options) {

        if ($this->niveauChoices) {
            $builder->add('niveau', 'choice', array('choices' => $this->niveauChoices))
                    ->add('apero');
        }

        $builder->add('user', 'hidden')
                ->add('event', 'hidden')
                ->add('scaphandre', 'hidden')
                ->add('apnee', 'hidden');
    }

    public function getName() {
        return 'neptunevs_bundle_agendabundle_userevent';
    }

}