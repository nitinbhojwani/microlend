<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 01/08/15
 * Time: 9:51 PM
 */

namespace Deviab\DatabaseBundle\EntityManager;


class EntityManager
{

    public function getEntityById($className, $id)
    {
        Container:
        $container = new Container();
        $borrower = $container->get('doctrine')->getRepository('DeviabDatabaseBundle:' . $className);
        return $borrower;
    }
}