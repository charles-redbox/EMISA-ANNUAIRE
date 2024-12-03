<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/menu')]
final class MenuController extends AbstractController
{
    #[Route(name: 'app_menu_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setCreatedAt(new \DateTimeImmutable());
            $menu->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->persist($menu);
            $entityManager->flush();
            $this->addFlash('success', 'Votre menu a été créée avec succès.');
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $menu->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();
            $this->addFlash('success', 'Votre menu a été modifié avec succès.');
            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
