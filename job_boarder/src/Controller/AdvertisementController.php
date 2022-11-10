<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\Company;
use App\Entity\User;
use App\Form\AdminAdvertisementType;
use App\Form\AdvertisementType;
use App\Repository\AdvertisementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdvertisementController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig', [

        ]);
    }


    /**
     * @Route("/advertisement", name="advertisement")
     */
    public function advertisement(AdvertisementRepository $advertRepo)
    {
        $advertisement = $advertRepo->findBy(array(), array('id'=> 'desc'));

        return $this->render('user/advertisement.html.twig', [
            'advertisement'=>$advertisement
        ]);
    }



// ************************** ADMIN ********************************

    /**
     * @Route("/admin/advertisement", name="admin_advertisement")
     */
    public function array_admin_advertisement(AdvertisementRepository $advertRepo)
    {
        $advertisement = $advertRepo->findAll();
        return $this->render('/admin/array_admin_advertisement.html.twig', [
            'advert'=>$advertisement
        ]);
    }

    /**
     * @Route("/admin/company/{id}/advertisement", name="company_advertisement")
     */
    public function advertisement_by_company($id,  AdvertisementRepository $advertRepo, Company $company)
    {
        $advertisement = $advertRepo->findBy(['company'=>$id]);

        return $this->render('/admin/advertisement_by_company.html.twig', [
            'advertisement'=>$advertisement,
            'company'=>$company
        ]);
    }


    /**
     * @Route("/admin/add/advertisement", name="admin_add_advertisement")
     */
    public function admin_add_advertisement(Request $request, EntityManagerInterface $manager, Company $company)
    {
        $advert = new Advertisement();

        $form = $this->createForm(AdminAdvertisementType::class, $advert, array('add'=>true));
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $advert->setTitle('f');
            $manager->persist($advert);
            $manager->flush();

            $this->addFlash('success', "ad has been successfully added");

            return $this->redirectToRoute('advertisement');
        }
        return $this->render("admin/add_advertisement.html.twig", [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/update/advertisement/{id}", name="admin_update_advertisement")
     */
    public function admin_update_advertisement(Advertisement $advert, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminAdvertisementType::class, $advert, array('update'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($advert);
            $manager->flush();

            $this->addFlash('success', "ad has been successfully updated");

            return $this->redirectToRoute('advertisement');
        }
        return $this->render('admin/update_advertisement.html.twig', [
            'form'=>$form->createView(),
            'advert'=>$advert
        ]);
    }







    // ************************** RECRUITER *************************

    /**
     * @Route("/recruiter/company/{id}/advertisement", name="recruiter_advertisement")
     */
    public function advertisement_by_company_for_recruiter($id,  AdvertisementRepository $advertRepo, Company $company)
    {
        $advertisement = $advertRepo->findBy(['company'=>$id]);

        return $this->render('/recruiter/advertisement_by_company_recruiter.html.twig', [
            'advertisement'=>$advertisement,
            'company'=>$company
        ]);
    }


    /**
     * @Route("/recruiter/company/{id}/add/advertisement", name="add_advertisement")
     */
    public function add_advertisement($id, Request $request, EntityManagerInterface $manager, Company $company)
    {
        $advert = new Advertisement();

        $form = $this->createForm(AdvertisementType::class, $advert, array('add'=>true));
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $advert->setCompany($company);
            $advert->setTitle('f');
            $manager->persist($advert);
            $manager->flush();

            $this->addFlash('success', "ad has been successfully added");

            return $this->redirectToRoute('advertisement');
        }
        return $this->render("recruiter/add_advertisement.html.twig", [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/recruiter/update/advertisement/{id}", name="update_advertisement")
     */
    public function update_advertisement(Advertisement $advert, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdvertisementType::class, $advert, array('update'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($advert);
            $manager->flush();

            $this->addFlash('success', "ad has been successfully updated");

            return $this->redirectToRoute('advertisement');
        }
        return $this->render('recruiter/update_advertisement.html.twig', [
            'form'=>$form->createView(),
            'advert'=>$advert
        ]);
    }


    /**
     * @Route("/delete/advertisement/{id}", name="delete_advertisement")
     */
    public function delete_advertisement(EntityManagerInterface $manager, Advertisement $advertisement)
    {
        $manager->remove($advertisement);
        $manager->flush();

        $this->addFlash('danger', "ad has been successfully removed");

        return $this->redirectToRoute('advertisement');
    }

}
