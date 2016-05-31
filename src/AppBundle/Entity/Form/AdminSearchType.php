<?php

namespace AppBundle\Entity\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSearchType extends AbstractType
{

    /**
     * THe form for a user search
     * @param  FormBuilderInterface $builder
     * @param  array                $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array('label' => ' ' , 'mapped'=> false))
            ->add('Search', 'submit')
            ->setAction('/admin/search');
    }

    public function getName()
    {
        return 'app_admin_search';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Journey',
        ));
    }
}
