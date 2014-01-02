<?php

/*
 * This file is part of the IRNewsBundle package.
 * 
 * (c) Julien Kirsch <informatic.revolution@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IR\Bundle\NewsBundle\Tests\Functional\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use IR\Bundle\NewsBundle\Model\Article as BaseArticle;

/**
 * @ORM\Entity
 * @ORM\Table(name="article")
 *
 * @author Julien Kirsch <informatic.revolution@gmail.com>
 */
class Article extends BaseArticle
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;  
}
