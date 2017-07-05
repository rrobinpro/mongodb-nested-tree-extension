<?php

namespace NestedTreeExtension\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * MongoDB Nested trait (php >= 5.4)
 *
 * Parent and root fields must declare in Document
 *
 * @author Litvinenko Andrey <andreylit@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
trait NestedSetDocument
{
    /**
     * @Mongo\Field(type="int")
     * @Gedmo\TreeLeft
     */
    protected $left;

    /**
     * @Mongo\Field(type="int")
     * @Gedmo\TreeRight
     */
    protected $right;

    /**
     * @Mongo\Field(type="int")
     * @Gedmo\TreeLevel
     */
    protected $level;

    public function getLeft()
    {
        return $this->left;
    }

    public function setLeft($left)
    {
        $this->left = $left;
        return $this;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function setRight($right)
    {
        $this->right = $right;
        return $this;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }
}