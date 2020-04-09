<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 09/04/2020
 * Time: 15:34
 */

namespace App\Normalizer;


use App\Exception\FormException;
use Symfony\Component\Dotenv\Exception\FormatException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class FormExceptionNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;
    /**
     * @param FormException $object
     * @inheritdoc
     */
    public function normalize($object, $format = null, array $context = [])
    {
        $data   = [];
        $errors = $object->getErrors();

        foreach ($errors as $error) {
            $data[$error->getOrigin()->getName()][] = $error->getMessage();
        }

        return $data;
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof FormException;
    }
}