<?php


namespace App\Form\Type;


use App\Entity\Playlist;
use App\Form\DataTransformer\SongToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PlaylistType extends AbstractType
{

    /**
     * @var SongToIdTransformer $transform
     */
    private $transform;

    public function __construct(SongToIdTransformer $transform)
    {
        $this->transform = $transform;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('thumbnail', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('songs', TextType::class, [
                'invalid_message' => 'Not a valid song id',
            ]);

        $builder->get('songs')->addModelTransformer($this->transform);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Playlist::class,
            'allow_extra_fields' => true
        ]);
    }
}