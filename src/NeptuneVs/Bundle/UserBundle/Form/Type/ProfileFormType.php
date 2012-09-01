<?php

namespace NeptuneVs\Bundle\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType {

    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class) {
        $this->class = $class;
    }

    public function buildForm(FormBuilder $builder, array $options) {
        parent::buildForm($builder, $options);
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'FOS\UserBundle\Form\Model\CheckPassword',
            'intention' => 'profile',
        );
    }

    public function getName() {
        return 'NeptuneVs_user_profile';
    }
    
    protected function buildUserForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')    
            ->add('email', 'email')
        ;
    }

}
