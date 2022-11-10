<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Entity\UserAdvertisement;
use App\Form\AdminUserType;
use App\Form\UpdateUserType;
use App\Repository\UserAdvertisementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

// ************************ ADMIN USER *************************

    /**
     * @Route("/admin/user/list", name="user_list")
     */
    public function user_list(UserRepository $userRepo)
    {
        $userList = $userRepo->findAll();

        return $this->render('admin/user_list.html.twig', [
            'user'=>$userList,
        ]);
    }


    /**
     * @Route("/admin/promote/user/{id}", name="promote_user")
     */
    public function promote_user($id, EntityManagerInterface $manager, UserRepository $userRepo)
    {
        $user = $userRepo->find($id);

        if ($user->getRoles() == ["ROLE_USER"]) {
            $user->setRoles(['ROLE_ADMIN']);
        }else{
            $user->setRoles(['ROLE_USER']);
        }

        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('user_list');
    }


    /**
     * @Route("/admin/create/user", name="admin_create_user")
     */
    public function admin_create_user(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager)
    {
        $user = new User();
        $form = $this->createForm(AdminUserType::class, $user, array('add'=>true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            if ($user->isRecruiter() == true) {
                $user->setRoles(['ROLE_RECRUITER']);
            }
            else
            {
                $user->setRoles(['ROLE_USER']);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }
        return $this->render('admin/admin_register.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/admin/update/user/{id}", name="admin_update_user")
     */
    public function admin_update_user(Request $request, User $user,  EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(AdminUserType::class, $user, array('update'=>true));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($user);
            $entityManager->flush();

            // return $userAuthenticator->authenticateUser(
            //     $user,
            //     $authenticator,
            //     $request
            // );
            return $this->redirectToRoute('user_list');
        }
        return $this->render('admin/admin_update_user.html.twig', [
            'form' => $form->createView(),
        ]);

    }


    /**
     * @Route("/admin/delete/user/{id}", name="delete_user")
     */
    public function delete_user($id, EntityManagerInterface $manager, UserRepository $userRepo)
    {
        $user = $userRepo->find($id);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('user_list');
    }


    // ************************ USER ****************************

    /**
     * @Route("/show/profile/{id}", name="show_profile")
     */
    public function show_profile(User $user)
    {
        return $this->render('user/show_profile.html.twig', [
            'user'=>$user,
            // 'company'=>$company
        ]);
    }

    /**
     * @Route("/profile/{id}/show/apply", name="show_user_apply")
     */
    public function show_user_apply($id, UserAdvertisementRepository $applyRepo)
    {
        $applys = $applyRepo->findBy(['user'=>$id]);

        return $this->render('user/show_apply_by_user.html.twig', [
            'applys'=>$applys
        ]);
    }

    /**
     * @Route("/profile/update/{id}", name="update_profile")
     */
    public function user_update($id, User $user, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UpdateUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())  {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute("show_profile", [
                'id'=>$id
            ]);
        }
        return $this->render("user/update_user.html.twig", [
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }



}
