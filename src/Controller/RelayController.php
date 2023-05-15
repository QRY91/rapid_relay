<?php

namespace App\Controller;

use App\Entity\Relay;
use App\Entity\Discipline;
use App\Form\RelayType;
use App\Repository\RelayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/relay')]
class RelayController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/', name: 'app_relay_index', methods: ['GET'])]
    public function index(RelayRepository $relayRepository): Response
    {
        return $this->render('relay/index.html.twig', [
            'relays' => $relayRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_relay_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RelayRepository $relayRepository): Response
    {
        $relay = new Relay();
        $disciplines = $this->doctrine->getRepository(Discipline::class);

        // $discipline1 = new Discipline();
        // $discipline1->setName('madeupski');
        // $relay->getDisciplines()->add($discipline1);
        // $discipline2 = new Discipline();
        // $discipline2->setName('dopestuff');
        // $relay->getDisciplines()->add($discipline2);

        $form = $this->createForm(RelayType::class, $relay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relayRepository->save($relay, true);

            return $this->redirectToRoute('app_relay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('relay/new.html.twig', [
            'relay' => $relay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relay_show', methods: ['GET'])]
    public function show(Relay $relay): Response
    {
        return $this->render('relay/show.html.twig', [
            'relay' => $relay,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_relay_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Relay $relay, RelayRepository $relayRepository): Response
    {
        $form = $this->createForm(RelayType::class, $relay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $relayRepository->save($relay, true);

            return $this->redirectToRoute('app_relay_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('relay/edit.html.twig', [
            'relay' => $relay,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_relay_delete', methods: ['POST'])]
    public function delete(Request $request, Relay $relay, RelayRepository $relayRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$relay->getId(), $request->request->get('_token'))) {
            $relayRepository->remove($relay, true);
        }

        return $this->redirectToRoute('app_relay_index', [], Response::HTTP_SEE_OTHER);
    }
}
