<?php

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

class PasswordRegex extends Compound
{

    protected function getConstraints(array $options): array
    {
        return [
            //regex -> to have at elast one digit
            new Assert\Regex([
                'pattern' => '/\d+/i',
                'message' => 'Votre mot de passe doit contenir au moins un chiffre'
            ]),
            //regex -> to have at elast one special char from the list
            //note: list of special-char is [#?!@$%^&*-]. Adjust to suite your needs
            new Assert\Regex([
                'pattern' => '/[#?!@$%^&*-]+/i',
                'message' => 'Votre mot de passe doit contenir au moins un caractère spécial(#-?-!-@-$-%-^-&-*-)'
            ]),
        ];
    }
}
