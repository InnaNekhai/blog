<?php
/**
 * Created by PhpStorm.
 * User: Артур
 * Date: 29.01.2018
 * Time: 20:09
 */

namespace App\Form;

use App\Entity\Comment;
use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Comment::class,
            'translation_domain' => 'messages',
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt' )
            ->add('commentatorName')
            ->add('text')
        ;
    }

}