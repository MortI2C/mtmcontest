<?php

namespace IBM\MTMBundle\Form;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
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
				->add('Create','submit', array('attr' => array('class' => 'btn btn-success')));
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
