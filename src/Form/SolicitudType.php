<?php

namespace App\Form;

use App\Entity\CuentaBancaria;
use App\Entity\Solicitud;
use App\Repository\CuentaBancariaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class SolicitudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente', ClienteType::class,[
                'constraints'=>[
                    new Valid()
                ]
            ])
            ->add('formaPago')
            ->add('plan')
            ->add('cuentaBancaria',EntityType::class, [
                'class' => CuentaBancaria::class,
                'query_builder' => function (CuentaBancariaRepository $er) {
                    return $er->createQueryBuilder('c')->where('c.esCuentaEmpresarial=1');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Solicitud::class,
        ]);
    }
}
