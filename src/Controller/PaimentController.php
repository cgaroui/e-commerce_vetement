<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Commande;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use symfony\bundle\FrameworkBundle\Controller\AbstractController;

class PaimentController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    #[Route('/commande/create-session-stripe/{refcommande}', name: 'paiment_stripe')]
    public function stripeChekout ($refCommande): RedirectResponse
    {


        $commande = $this->em->getRepository(Commande::class)->findOneBy(['refCommande' => $refCommande]);

        dd($commande);
        // Stripe::setApiKey(apiKey: 'sk_test_51QBFioIzYM3DZnexzgfxkfGVezLqemFWRPID48sCe9T2dss1IPPt0SsPFZonsJjXkBkMshaD5knUMw6rAedVSYWQ00iA1NBen5');
      

        // $checkout_session = \Stripe\Checkout\Session::create([
        // 'line_items' => [[
        //     # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
        //     'price' => '{{PRICE_ID}}',
        //     'quantity' => 1,
        // ]],
        // 'mode' => 'payment',
        // 'success_url' => $YOUR_DOMAIN . '/success.html',
        // 'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        // 'automatic_tax' => [
        //     'enabled' => true,
        // ],
        // ]);

    }
}