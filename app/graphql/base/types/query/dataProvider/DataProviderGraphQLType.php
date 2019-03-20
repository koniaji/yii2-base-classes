<?php
/**
 * Created by PhpStorm.
 * User: amorev
 * Date: 20.03.2019
 * Time: 22:57
 */

namespace Zvinger\BaseClasses\app\graphql\base\types\query\dataProvider;


use GraphQL\Type\Definition\Type;
use yii\data\DataProviderInterface;
use Zvinger\BaseClasses\app\graphql\base\BaseGraphQLObjectType;
use Zvinger\BaseClasses\app\graphql\base\types\input\PaginationInputType;

class DataProviderGraphQLType extends BaseGraphQLObjectType
{
    /**
     * DataProviderGraphQLType constructor.
     * @param $elementsTypeClass BaseGraphQLObjectType
     */
    public function __construct($elementsTypeClass)
    {
        $config = [
            'fields' => function () use ($elementsTypeClass) {
                return [
                    'elements' => [
                        'args' => [
                            'pagination' => PaginationInputType::initType(),
                        ],
                        'type' => Type::listOf($elementsTypeClass::initType()),
                        'resolve' => function (DataProviderInterface $value, $args) {
                            $pagination = $args['pagination'];
                            if ($pagination['page']) {
                                $value->getPagination()->setPage($pagination['page'] - 1);
                            }
                            if ($pagination['pageSize']) {
                                $value->getPagination()->setPageSize($pagination['pageSize']);
                            }

                            return $value->getModels();
                        },
                    ],
                ];
            },
        ];

        parent::__construct($config);
    }
}
