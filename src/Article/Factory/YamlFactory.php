<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 14:18
 */

namespace App\Article\Factory;

use App\Strategy\StrategyInterface;
use App\Strategy\YamlStrategy;

class YamlFactory extends AbstractFactory
{
    /**
     * @inheritDoc
     */
    public function __construct(StrategyInterface $strategy)
    {
        parent::__construct(new YamlStrategy());
    }

}