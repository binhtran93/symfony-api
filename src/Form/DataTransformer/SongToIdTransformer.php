<?php


namespace App\Form\DataTransformer;


use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SongToIdTransformer implements DataTransformerInterface
{

    /** @var EntityManagerInterface $em */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Song[] $value
     * @inheritDoc
     */
    public function transform($value)
    {
        if ($value === null) {
            return '';
        }

        $songIds = array_map(function($song) {
            /** @var Song $song */
            return $song->getid();
        }, $value);

        return implode(',', $songIds);
    }

    /**
     * @param string $value
     * @inheritDoc
     * @return Song[]|null
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            throw new TransformationFailedException(sprintf('Song with id does not exists'));
        }

        /** @var Song[] $songs */
        $songs = $this->em->getRepository(Song::class)->findBy([
            'id' => explode(',', $value)
        ]);

        if (count($songs) === 0) {
            throw new TransformationFailedException(sprintf('Song with id does not exists'));
        }

        return $songs;
    }
}