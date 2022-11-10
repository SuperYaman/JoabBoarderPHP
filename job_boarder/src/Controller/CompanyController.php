<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Form\AdminCompanyType;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    
    // ************************** ADMIN ****************************

    /**
     * @Route("/admin/company", name="admin_company")
     */
    public function array_admin_company(CompanyRepository $companyRepo)
    {
        $company = $companyRepo->findAll();

        return $this->render('admin/array_admin_company.html.twig', [
            'company'=>$company
        ]);
    }

    /**
     * @Route("/admin/add/company", name="admin_add_company")
     */
    public function admin_add_company(Request $request, EntityManagerInterface $manager)
    {
        $company = new Company();

        $form = $this->createForm(AdminCompanyType::class, $company, array('add'=>true));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $company->setUser($this->getUser());
            $manager->persist($company);
            $manager->flush();

            $this->addFlash('success', "company has been successfully added");

            return $this->redirectToRoute('admin_company');
        }
        return $this->render('admin/add_company.html.twig', [
            'form'=>$form->createView(),
            'company'=>$company
        ]);
    }

    /**
     * @Route("/admin/update/company/{id}", name="admin_update_company")
     */
    public function admin_update_company(Company $company, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(AdminCompanyType::class, $company, array('update'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($company);
            $manager->flush();

            $this->addFlash('success', "company has been successfully updated");

            return $this->redirectToRoute('admin_company');
        }
        return $this->render('admin/update_company.html.twig', [
            'form'=>$form->createView(),
            'company'=>$company
        ]);
    }





    // ************************ RECRUITER **************************

    /**
     * @Route("/recruiter/{id}/company", name="recruiter_company")
     */
    public function recruiter_company($id, CompanyRepository $companyRepo, User $recruiter)
    {

        $company = $companyRepo->findBy(['id'=>$id]);

        return $this->render('recruiter/recruiter_company.html.twig', [
            'id'=>$id,
            'company'=>$company,
            'recruiter'=>$recruiter
        ]);
    }


    /**
     * @Route("/recruiter/add/company", name="add_company")
     */
    public function add_company(Request $request, EntityManagerInterface $manager)
    {
        $company = new Company();

        $form = $this->createForm(CompanyType::class, $company, array('add'=>true));

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $company->setUser($this->getUser());
            $manager->persist($company);
            $manager->flush();

            $this->addFlash('success', "company has been successfully added");

            return $this->redirectToRoute('advertisement');
        }
        return $this->render('recruiter/add_company.html.twig', [
            'form'=>$form->createView(),
            'company'=>$company
        ]);
    }

    /**
     * @Route("/recruiter/update/company/{id}", name="update_company")
     */
    public function update_company(Company $company, Request $request, EntityManagerInterface $manager)
    {
        $form = $this->createForm(CompanyType::class, $company, array('update'=>true));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($company);
            $manager->flush();

            $this->addFlash('success', "company has been successfully updated");

            return $this->redirectToRoute('recruiter_company');
        }
        return $this->render('recruiter/update_company.html.twig', [
            'form'=>$form->createView(),
            'company'=>$company
        ]);
    }


    /**
     * @Route("/delete/company/{id}", name="delete_company")
     */
    public function delete_company(EntityManagerInterface $manager, Company $company)
    {
        $manager->remove($company);
        $manager->flush();

        $this->addFlash('danger', "company has been successfully removed");

        return $this->redirectToRoute('company');
    }







}

