<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 10.03.2019
 * Time: 22:53
 */

namespace Zvinger\BaseClasses\app\graphql\base;

use GraphQL\Type\Definition\ObjectType;
use Zvinger\BaseClasses\app\graphql\helpers\VendorTypesCollection;

class BaseGraphQLObjectType extends ObjectType
{
    /**
     * @param array $constructorVars
     * @return ObjectType
     */
    public static function initType($constructorVars = [])
    {
        return VendorTypesCollection::getField(static::class, null, $constructorVars);
    }
}
