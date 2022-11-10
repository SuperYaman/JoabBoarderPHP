<?php

namespace App\Controller;

use App\Entity\Advertisement;
use App\Entity\NotUserApply;
use App\Form\NotUserApplyType;
use App\Repository\NotUserApplyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotUserApplyController extends AbstractController
{
    /**
     * @Route("/advertisement/{id}/not/user/apply", name="not_user_apply")
     */
    public function not_user_apply(Request $request, EntityManagerInterface $manager, Advertisement $advertisement)
    {
        $notUserApply = new NotUserApply();

        $form = $this->createForm(NotUserApplyType::class, $notUserApply, array('add'=>true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notUserApply->setAdvertisement($advertisement);
            $manager->persist($notUserApply);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('not_user_apply/not_user_apply.html.twig', [
            'form'=>$form->createView(),
            'apply'=>$notUserApply,
            'advert'=>$advertisement
        ]);
    }



    // ************************ ADMIN - RECRUITER *******************

    /**
     * @Route("/recruiter/advertisement/{id}/not/user/apply/", name="not_user_apply_list")
     */
    public function unknow_user_apply_list($id, NotUserApplyRepository $applyRepo)
    {
        $applyList = $applyRepo->findBy(['advertisement'=>$id]);

        return $this->render('recruiter/not_user_apply_by_advertisement.html.twig', [
            'applyList'=>$applyList
        ]);
    }

    /**
     * @Route("/admin/update/not/user/apply/{id}", name="update_not_user_apply")
     */
    public function update_not_user_apply(NotUserApply $apply, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(NotUserApplyType::class, $apply, array('update'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($apply);
            $manager->flush();

            return $this->redirectToRoute('not_user_apply_list');
        }
        return $this->render('admin/update_not_user_apply.html.twig', [
            'form'=>$form->createView(),
            'apply'=>$apply
        ]);
    }

    /**
     * @Route("/admin/not/user/apply/list", name="admin_not_user_apply_list")
     */
    public function admin_not_user_list(NotUserApplyRepository $applyRepo)
    {
        $applyList = $applyRepo->findAll();

        return $this->render("admin/not_user_apply_list.html.twig",[
            'apply'=>$applyList
        ]);
    }

    /**
     * @Route("admin/delete/not/user/apply/{id}", name="admin_delete_not_user_apply")
     */
    public function admin_delete_not_user_apply(EntityManagerInterface $manager, NotUserApply $apply)
    {   
        $manager->remove($apply);
        $manager->flush();

        return $this->redirectToRoute('not_user_apply_list');
    }


}
