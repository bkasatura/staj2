<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Repository\Admin\CommentRepository;
use App\Repository\Admin\RoomRepository;
use App\Repository\HotelRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(HotelRepository $hotelRepository)
    {
        $slider=$hotelRepository->findBy([],['title'=>'ASC'], 3);
        $products=$hotelRepository->findBy([],['title'=>'DESC'], 4);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'slider' => $slider,
            'products' =>$products,
        ]);
    }

    /**
     * @Route("/hotel/{id}", name="hotel_show", methods={"GET"})
     */
    public function show(Hotel $hotel,$id,ImageRepository $imageRepository, HotelRepository $hotelRepository, CommentRepository $commentRepository,RoomRepository $roomRepository): Response
    {
        $hotels=$hotelRepository->findBy([],['title'=>'ASC'], 3);
        $images=$imageRepository->findBy(['hotel'=>$id]);
        $comments=$commentRepository->findBy(['hotelid'=>$id, 'status'=>'True']);
        return $this->render('home/hotelshow.html.twig', [
            'comments'=>$comments,
            'hotel' => $hotel,
            'hotels' => $hotels,
            'images' =>$images,
        ]);
    }

    /**
     * @Route("/about", name="home_about")
     */
    public function about(): Response
    {
        return $this->render('home/aboutus.html.twig', [

        ]);
    }






}
