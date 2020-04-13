<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Song;
use App\Event\TestEvent;
use App\Exception\FormException;
use App\Form\Type\SongType;
use App\Listener\TestListener;
use App\Repository\SongRepository;
use App\Response\ApiResponse;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Schema\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SongController extends AbstractController
{
    /**
     * @Route("/songs", name="song", methods={"GET"})
     * @param SongRepository $songRepository
     * @return JsonResponse
     */
    public function index(SongRepository $songRepository)
    {
        $songs = $songRepository->findAllOrderDescByTitleUsingQueryBuilder(['album', 'playlists']);

        return $this->json($songs);
    }

    /**
     * @Route("/songs", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(Request $request) {
        $data = $request->request->all();

        $form = $this->createForm(SongType::class);

        $form->submit($data);
        if (!$form->isValid()) {
            throw new FormException($form);
        }

        $em = $this->getDoctrine()->getManager();

        /** @var Song $song */
        $song = $form->getData();

        $em->persist($song);
        $em->flush();

        return new ApiResponse();
    }

    /**
     * @Route("/songs/{id}", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param $id
     * @return ApiResponse
     */
    public function destroy($id) {
        $em = $this->getDoctrine()->getManager();

        $song = $em->getRepository(Song::class)->find($id);
        if (!$song) {
            throw $this->createNotFoundException('Song not found');
        }

        $em->remove($song);
        $em->flush();

        return new ApiResponse();
    }
}
