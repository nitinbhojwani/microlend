<?php
/**
 * Created by PhpStorm.
 * User: dk-jarvis
 * Date: 07/08/15
 * Time: 2:25 AM
 */

namespace Deviab\BorrowerBundle\Services;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class BaseService
{
    protected $doctrine;

    /**
     * Constructor
     *
     * @param Doctrine $doctrine - Doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }
}