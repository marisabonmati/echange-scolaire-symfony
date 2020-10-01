<?php


namespace App\DoctrineFunctions;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class RandFunction extends FunctionNode
{
// DOCTRINE N'A PAS DE FONCTION 'RAND()' DONC NOUS FAISONS APPEL A LA FONCTION NATIVE 'RAND()' DE MYSQL
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'RAND()';
    }
}
