<?php


namespace App\Normalizer;


use App\Entity\Album;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class AlbumNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * @inheritDoc
     * @var Album $object
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'createdAt' => $this->serializer->normalize($object->getCreatedAt()),
            'updatedAt' => $this->serializer->normalize($object->getUpdatedAt()),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Album;
    }
}