<?php
namespace Nemoneph\SipsPlugin\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 */
final class SipsGatewayConfigurationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secret_key', TextType::class, [
                'label' => 'Secret',
            ])
            ->add('merchant_id', TextType::class, [
                'label' => 'Merchant ID',
            ])
        ;
    }
}