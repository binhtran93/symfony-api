<?php


namespace App\Normalizer;


use App\Entity\Song;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class SongNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * @inheritDoc
     * @var $object Song
     */
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            'id' => $object->getId(),
            'streamUrl' => $object->getStreamUrl(),
            'album' => $this->serializer->normalize($object->getAlbum()),
            'createdAt' => $this->serializer->normalize($object->getCreatedAt()),
            'updatedAt' => $this->serializer->normalize($object->getUpdatedAt()),
        ];
    }

    /**
     * @inheritDoc
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Song;
    }
}