<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "Email",
                "required" => true,
                "trim" => true,
                "constraints" => [
                    new NotBlank([
                        "message"=>"Le champ Email ne peut pas être vide !"
                    ]),
                    new Length([
                        "max"=>"180",
                        "maxMessage"=>"L'email ne peut faire plus de 180 caractères !"
                    ]),
                    new Email([
                        "message"=>"Email non valide !"
                    ])
                ]])
            ->add('password')
            ->add("submit", SubmitType::class,[
                "label" => "Enregistrer"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
