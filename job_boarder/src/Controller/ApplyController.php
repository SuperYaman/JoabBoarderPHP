<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\UserAdvertisement;
use App\Form\AdminApplyType;
use App\Form\ApplyType;
use App\Repository\UserAdvertisementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    /**
     * @Route("/advertisement/{id}/apply", name="apply")
     */
    public function apply(Request $request, EntityManagerInterface $manager, Advertisement $advertisement)
    {
        $apply = new UserAdvertisement();

        $form = $this->createForm(ApplyType::class, $apply, array('add'=>true));
        $form->handleRequest($request);

        $user = $this->getUser();
        // dd($user);

        if ($form->isSubmitted() && $form->isValid()) {

            $apply->setUser($this->getUser());
            $apply->setAdvertisement($advertisement);
            $manager->persist($apply);
            $manager->flush();

            $this->addFlash('success', "Your message has been sent");

            return $this->redirectToRoute('advertisement');
        }

        return $this->render('user/apply.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user,
            'advert'=>$advertisement
        ]);
    }

    /**
     * @Route("/recruiter/advertisement/{id}/apply/list", name="apply_list")
     */
    public function apply_list($id, UserAdvertisementRepository $applyRepo)
    {
        $applyList = $applyRepo->findBy(['advertisement'=>$id]);

        return $this->render('recruiter/apply_by_advertisement.html.twig', [
            'id'=>$id,
            'applyList'=>$applyList
        ]);
    }

    /**
     * @Route("user/{id}/apply/list", name="user_apply_list")
     */



    // ************************ ADMIN APPLY *************************

    /**
     * @Route("/admin/apply/list", name="admin_apply_list")
     */
    public function admin_apply_list(UserAdvertisementRepository $applyRepo)
    {
        $listApply = $applyRepo->findAll();

        return $this->render('admin/admin_apply_list.html.twig', [
            'applyList'=>$listApply
        ]);
    }

    /**
     * @Route("/admin/advertisement/apply", name="admin_create_apply")
     */
    public function admin_create_apply(Request $request, EntityManagerInterface $manager, Advertisement $advertisement)
    {
        $apply = new UserAdvertisement();

        $form = $this->createForm(AdminApplyType::class, $apply, array('add'=>true));
        $form->handleRequest($request);

        $user = $this->getUser();
        // dd($user);

        if ($form->isSubmitted() && $form->isValid()) {

            $apply->setUser($this->getUser());
            $apply->setAdvertisement($advertisement);
            $manager->persist($apply);
            $manager->flush();

            $this->addFlash('success', "Your message has been sent");

            return $this->redirectToRoute('advertisement');
        }

        return $this->render('admin/add_apply.html.twig', [
            'form'=>$form->createView(),
            'user'=>$user,
            'advert'=>$advertisement
        ]);
    }

    /**
     * @Route("admin/update/apply/{id}", name="admin_update_apply")
     */
    public function update_apply(UserAdvertisement $userAdvertisement, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminApplyType::class, $userAdvertisement, array('update'=>true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($userAdvertisement);
            $manager->flush();

            $this->addFlash('success', "Message has been updated");

            return $this->redirectToRoute('admin_apply_list');
        }
        return $this->render('admin/update_apply.html.twig', [
            'form'=>$form->createView(),
            'apply'=>$userAdvertisement
        ]);
    }

    /**
     * @Route("/admin/delete/apply/{id}", name="admin_delete_apply")
     */
    public function admin_delete_apply(EntityManagerInterface $manager, UserAdvertisement $apply)
    {
        $manager->remove($apply);
        $manager->flush();

        $this->addFlash('danger', "Your message has been removed");


        return $this->redirectToRoute('admin_apply_list');
    }



}
