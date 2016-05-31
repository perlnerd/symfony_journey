<?php

namespace AppBundle\Entity\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('auFirstName', 'text', array('label' => 'First Name'))
            ->add('auLastName', 'text', array('label' => 'Last Name'))
            ->add('save', 'submit');
    }

    public function getName()
    {
        return 'app_user_edit';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\UserAuth',
        ));
    }
}
