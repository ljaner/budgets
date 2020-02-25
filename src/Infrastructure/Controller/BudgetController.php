<?php


namespace App\Infrastructure\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class BudgetController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('budget/budget_request.html.twig');
    }

    /**
     * @Route("/check-email-budget", name="check_email_budget")
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEmailBudgetAction(Request $request)
    {
        $email = $request->get('email');

        $pos = strpos($email, "hotmail.com");
        if ($pos !== false) {
            return $this->json(['error' => "Email no puede ser de tipo hotmail"]);
        }
        return $this->json(['email' => $email]);
    }
}