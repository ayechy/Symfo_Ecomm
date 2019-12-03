<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Produit;
use App\Form\ProduitType;


class EcomController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $prod = $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('Pages/home.html', [
            'prod' => $prod
        ]);
    }


   /**
     * @Route ("/create", name = "create")
     */
    public function create(request $request, ObjectManager $manager){
        $prod = new produit();

        $form = $this->createForm(ProduitType::class, $prod);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('home');
        
        }

        $formView = $form->createView();



        
        return $this->render('pages/create.html',[
            'form' => $formView
        ]);
    }


    /**
     * @Route("/more/{id}", name= "more")
     */
    public function more($id){
        $load = $this->getDoctrine()->getRepository(Produit::class)->find($id);

        return $this->render('pages/produit.html',[
            'load' =>$load
        ]);

    }



    /**
     * @Route("/panier",name = "panier")
     */
    public function panier(){
        return $this->render('pages/panier.html');
    }
    

}
