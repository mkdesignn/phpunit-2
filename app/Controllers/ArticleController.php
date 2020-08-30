<?php

namespace App\Controllers;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\Validator\Validation;

class ArticleController
{

    public function storeArticle(Request $request)
    {
        $constraint = new Collection([
            'title' => [new Required(), new Length(['min' => 25])],
            'content' => [new Required(), new Length(['min' => 50])]]);

        $validation = Validation::createValidator();
        $violations = $validation->validate($request->request->all(), $constraint);

        $data = [];
        foreach ($violations as $key => $violation){
            $data[str_replace(['[', ']'], ['', ''], $violation->getPropertyPath())] = $violation->getMessage();
        }

        if(count($data) > 0)
            return new JsonResponse($data, 400);
        else
            return new JsonResponse($request->request->all(), 200);
    }

}
