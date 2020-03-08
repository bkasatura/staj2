<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use phpDocumentor\Reflection\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("admin/hotel")
 */
class HotelController extends AbstractController
{
    /**
     * @Route("/", name="admin_hotel_index", methods={"GET"})
     * @Template("admin/hotel/index.html.twig")
     * @param HotelRepository $hotelRepository
     * @return array
     */
    public function index(HotelRepository $hotelRepository): array
    {
        return  [
            'hotels' => $hotelRepository->findAll(),
        ];
    }

    /**
     * @Route("/new", name="admin_hotel_new", methods={"GET","POST"})
     * @Template("admin/hotel/new.html.twig")
     * @param Request $request
     * @return array|RedirectResponse
     */
    public function new(Request $request)
    {
        $hotel = new Hotel();
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /**  @var \Symfony\Component\HttpFoundation\File\File $file  */
            $file = $form['image']->getData();
            if ($file) {
                $fileName=$this->generateUniqueFileName().'.' .$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                }catch(FileException $e){

                }
                $hotel->setImage($fileName);

            }
            $entityManager->persist($hotel);
            $entityManager->flush();

            return $this->redirectToRoute('admin_hotel_index');
        }
        return  [
            'hotel' => $hotel,
            'form' => $form->createView(),
        ];
    }
    /**
     * @Route("/{id}", name="admin_hotel_show", methods={"GET"})
     * @Template("admin/hotel/show.html.twig")
     * @param Hotel $hotel
     * @return array
     */
    public function show(Hotel $hotel): array
    {
        return [
            'hotel' => $hotel,
        ];
    }

    /**
     * @Route("/{id}/edit", name="admin_hotel_edit", methods={"GET","POST"})
     * @Template("admin/hotel/edit.html.twig")
     * @param  Request $request
     * @param Hotel $hotel
     * @return array|RedirectResponse
     */
    public function edit(Request $request, Hotel $hotel)
    {
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**  @var file $file  */
            $file = $form['image'] -> getData();
            if ($file) {
                $fileName=$this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('images_directory'),
                        $fileName
                    );
                }catch(FileException $e){

                    }
                    $hotel->setImage($fileName);
            }
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_hotel_index');
        }

        return[
            'hotel' => $hotel,
            'form' => $form->createView(),
        ];
    }


    /**
     * @return string
     */

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    /**
     * @Route("/{id}", name="admin_hotel_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hotel $hotel): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hotel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hotel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_hotel_index');
    }
}
