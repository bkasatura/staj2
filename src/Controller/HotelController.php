<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\Hotel1Type;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/hotels")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="user_hotel_index", methods={"GET"})
     */
    public function index(HotelRepository $hotelRepository): Response
    {

        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_hotel_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hotel = new Hotel();
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user=$this->getUser();


            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('user_hotel_index');
        }

        return $this->render('hotel/new.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_hotel_show", methods={"GET"})
     */
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/show.html.twig', [
            'hotel' => $hotel,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_hotel_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hotel $hotel): Response
    {
        $form = $this->createForm(Hotel1Type::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_hotel_index');
        }

        return $this->render('hotel/edit.html.twig', [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_hotel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hotel $hotel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_hotel_index');
    }
}
