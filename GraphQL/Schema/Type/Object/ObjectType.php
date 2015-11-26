<?php
/**
 * Date: 26.11.15
 *
 * @author Portey Vasil <portey@gmail.com>
 */

namespace Youshido\GraphQLBundle\GraphQL\Schema\Type\Object;


use Youshido\GraphQLBundle\GraphQL\Schema\Type\TypeInterface;

class ObjectType implements TypeInterface
{

    /** @var  string */
    protected $name;

    public function getFields()
    {
        return [];
    }

    public function getArguments()
    {
        return [];
    }

    /**
     * @param null  $value
     * @param array $args
     *
     * @return mixed
     */
    public function resolve($value = null, $args = [])
    {
        return null;
    }
}