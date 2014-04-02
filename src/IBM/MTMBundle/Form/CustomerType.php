<?php

namespace IBM\MTMBundle\Form;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

class CustomerType extends AbstractType
{
	private $updateForm;
	
	public function __construct($updateForm = false)
	{
		$this->updateForm = $updateForm;
	}
	/* (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add('account', 'text', array(
						'mapped' => true,
						'required' => true
					))
				->add('status', 'choice', array(
						'choices' => array('A' => 'Active', 'I' => 'Inactive'),
						'mapped' => true,
						'required'  => true
					))
				->add('firstName', 'text', array(
						'mapped' => true,
						'required' => true
					))
				->add('lastName', 'text', array(
						'mapped' => true,
						'required' => true
					))
				->add('address', 'text', array(
						'mapped' => true,
						'required' => true
					))
				->add('city', 'text', array(
						'mapped' => true,
						'required' => true
					))
				->add('state', 'text', array(
						'mapped' => true,
						'required' => true
				))
				->add('balance', 'number', array(
						'mapped' => false,
						'required' => true,
						'data' => 0,
						'precision' => 2,
						'constraints' => array(
							new NotBlank()
						)
				));
		if(!$this->updateForm) {
				$builder->add('password','repeated', array(
						'mapped' => false,
						'required' => true,
						'options' => array('attr' => array('class' => 'password-field')),
						'type' => 'password',
						'invalid_message' => 'The password fields must match',
						'first_options'  => array('label' => 'Password'),
						'second_options' => array('label' => 'Repeat Password'),
						'constraints' => array(
							new NotBlank(),
							new Length(array('min' => 6))
						)
				))
				->add('email','email', array(
						'mapped' => false,
						'required' => true,
						'constraints' => array(
							new NotBlank(),
							new Email(array('message' => 'The email {{ value }} is not valid', 'checkMX' => true, 'checkHost' => true))
						)
				))
				->add('Create','submit', array('attr' => array('class' => 'btn btn-success')));
		} else
			$builder->add('Update','submit', array('attr' => array('class' => 'btn btn-success')));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\FormTypeInterface::getName()
	 */
	public function getName() {
		return 'customer_type';
	}
}

?>
