<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Produit;
use App\Repository\ClientRepository;
use App\Repository\ProduitRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use UltraMsg\WhatsAppApi;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{






    /**
     * @Route("/valid", name="mail")
     */
    public function sendEmail(MailerInterface $mailer, SessionInterface $session, ProduitRepository $clientRepository)
    {
        $panier = $session->get("panier", []);

        // "Manufacture" the data
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantity) {
            $client = $clientRepository->find($id);

            if ($client) {
                $dataPanier[] = [
                    "produit" => $client,
                    "quantite" => $quantity
                ];

                $total += $client->getPrix() * $quantity;
            }
        }

        $email = (new TemplatedEmail())
            ->from('espritagri11@gmail.com')
            ->to('lmouldi769@gmail.com')
            ->subject('Confirmation Commande')
            ->text('nous a vous contacter pour confirme l achat')
            ->htmlTemplate('cart/confirmationpayement.html.twig')
            ->context([
                'dataPanier' => $dataPanier,
                'total' => $total,
            ]);

        // ->html('<p>Contenu du message en HTML</p>');

        try {
            $mailer->send($email);

            // flash success message
            $this->addFlash('success', 'Commend validé! Verifier votre adresse mail');
        } catch (\Exception $e) {
            // flash error message
            $this->addFlash('danger', 'Echec d\'envoi! ' . $e->getMessage());
        }

        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, ProduitRepository $clientRepository)
    {
        $panier = $session->get("panier", []);

        // "Manufacture" the data
        $dataPanier = [];
        $total = 0;

        foreach ($panier as $id => $quantity) {
            $client = $clientRepository->find($id);

            if ($client) {
                $dataPanier[] = [
                    "produit" => $client,
                    "quantite" => $quantity
                ];

                $total += $client->getPrix() * $quantity;
            }
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }



    /**
     * @Route("/addin/{id}", name="addinmarche")
     */
    public function addInMarche(Produit $client, SessionInterface $session)
    {
        // Get the current cart
        $panier = $session->get("panier", []);
        $id = $client->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // Save to the session
        $session->set("panier", $panier);
        // return $this->redirectToRoute("cart_index");
        return $this->redirect($this->generateUrl('app_client_index'));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Produit $client, SessionInterface $session)
    {
        // Get the current cart
        $panier = $session->get("panier", []);
        $id = $client->getId();

        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        // Save to the session
        $session->set("panier", $panier);

        // You can add additional logic here if needed, but no need to redirect or render

        // If you want to return a response (e.g., JSON response), you can do so:
        return $this->redirectToRoute("cart_index");
    }
    // /**
    //  * @Route("/add/{id}", name="add")
    //  */
    // public function add(Client $client, SessionInterface $session)
    // {
    //     // Get the current cart
    //     $panier = $session->get("panier", []);
    //     $id = $client->getId();

    //     if (!empty($panier[$id])) {
    //         $panier[$id]++;
    //     } else {
    //         $panier[$id] = 1;
    //     }

    //     // Save to the session
    //     $session->set("panier", $panier);
    //     return $this->redirectToRoute("cart_index");
    // }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Produit $client, SessionInterface $session)
    {
        // Get the current cart
        $panier = $session->get("panier", []);
        $id = $client->getId();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // Save to the session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Produit $client, SessionInterface $session)
    {
        // Get the current cart
        $panier = $session->get("panier", []);
        $id = $client->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        // Save to the session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }
}