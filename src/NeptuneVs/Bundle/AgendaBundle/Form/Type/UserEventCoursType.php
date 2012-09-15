<?php

namespace NeptuneVs\Bundle\AgendaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserEventCoursType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {

        $builder->add('user', 'hidden')
                ->add('event', 'hidden')
                ->add('scaphandre', 'hidden')
                ->add('apnee', 'hidden');
    }

    public function getName() {
        return 'neptunevs_bundle_agendabundle_usereventcours';
    }

}