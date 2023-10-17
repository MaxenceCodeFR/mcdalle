<?php

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordRegex extends Compound
{

    protected function getConstraints(array $options): array
    {
        return [
            //regex -> pour avoir au minium un chiffre ou plus 
            // d = digit
            // i = case insensitive (autorise les majuscules et minuscules)
            // + = peut avoir plusieurs chiffres
            new Assert\Regex([
                'pattern' => '/\d+/i',
                'message' => 'Votre mot de passe doit contenir au moins un chiffre'
            ]),
            //regex -> pour avoir au minumum un caractère parmis la liste
            new Assert\Regex([
                'pattern' => '/[#?!@$%^&*-]+/i',
                'message' => 'Votre mot de passe doit contenir au moins un caractère spécial(#-?-!-@-$-%-^-&-*-)'
            ]),
        ];
    }
}
