<?php

namespace IBM\MTMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
{
	
	private $updateUser;
	
	public function __construct($updateUser = false)
	{
		$this->updateUser = $updateUser;
	}
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$submitValue = ($this->updateUser) ? 'Update' : 'Create';
    	$constraintsPasword = ($this->updateUser) ? array(new Length(array('min' => 6))) : array(new NotBlank(), new Length(array('min' => 6)));
        $builder
            ->add('username','text',array(
        		'mapped' => true,
            	'required' => true
        	))
            ->add('email', 'email', array(
            	'mapped' => true,
            	'required' => true
            ))
       		->add('password','repeated',array(
       			'mapped' => true,
       			'required' => !$this->updateUser, //if updating user, not required, else it is
       			'options' => array('attr' => array('class' => 'password-field')),
       			'type' => 'password',
       			'invalid_message' => 'The password fields must match',
       			'first_options'  => array('label' => 'Password'),
       			'second_options' => array('label' => 'Repeat Password'),
       			'constraints' => $constraintsPasword
       		))
            ->add('role', 'choice', array(
            	'choices' => array('ROLE_ADMIN' => 'Administrator',
            			'ROLE_CUSTOMER' => 'Customer'),
            	'mapped' => true,
            	'required' => true
            ))
            ->add('customer')
            ->add($submitValue,'submit',array('attr' => array('class' => 'btn btn-success')));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IBM\MTMBundle\Entity\Users'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ibm_mtmbundle_users';
    }
}
