<?php

namespace NeptuneVs\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AdminEditUserType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder
                ->add('nom')
                ->add('prenom')
                ->add('email', 'email')
                ->add('roles', 'choice', array(
                    'choices' => array(
                        'ROLE_DIRECTEUR_PLONGEE' => 'Directeur de plongée',
                        'ROLE_BIOLOGIE' => 'Biologie',
                        'ROLE_MATERIEL' => 'Matériel',
                        'ROLE_LOISIR' => 'Loisir',
                        'ROLE_SECRETAIRE' => 'Secrétaire',
                        'ROLE_TECHNIQUE' => 'Technique',
                        'ROLE_MODERATEUR' => 'Moderateur',
                        'ROLE_PRESIDENT' => 'Président',
                        'ROLE_WEBMASTER' => 'Webmaster',
                    ),
                    'multiple' => true,))
                ->add('locked')
        ;
    }

    public function getName() {
        return 'neptunevs_bundle_userbundle_adminedituser';
    }

}