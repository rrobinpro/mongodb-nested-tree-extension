<?php

namespace NestedTreeExtension\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use Gedmo\Exception\InvalidArgumentException;
use Gedmo\Exception\UnexpectedValueException;
use Gedmo\Tree\Strategy;
use NestedTreeExtension\Strategy\ODM\MongoDB\Nested;

class TreeListener extends \Gedmo\Tree\TreeListener
{
    /**
     * Tree processing strategies for object classes
     *
     * @var array
     */
    protected $strategies = [];

    /**
     * List of strategy instances
     *
     * @var array
     */
    protected $strategyInstances = [];

    public function getStrategy(ObjectManager $om, $class)
    {
        if (!isset($this->strategies[$class])) {
            $config = $this->getConfiguration($om, $class);
            if (!$config) {
                throw new UnexpectedValueException("Tree object class: {$class} must have tree metadata at this point");
            }
            $managerName = 'UnsupportedManager';
            if ($om instanceof \Doctrine\ORM\EntityManager) {
                $managerName = 'ORM';
            } elseif ($om instanceof \Doctrine\ODM\MongoDB\DocumentManager) {
                $managerName = 'ODM\\MongoDB';
            }

            if (!isset($this->strategyInstances[$config['strategy']])) {
                if ($config['strategy'] == 'nested') {
                    $strategyClass = Nested::class;
                } else {
                    $strategyClass = $this->getNamespace().'\\Strategy\\'.$managerName.'\\'.ucfirst($config['strategy']);
                }

                if (!class_exists($strategyClass)) {
                    throw new InvalidArgumentException($managerName." TreeListener does not support tree type: {$config['strategy']}");
                }
                $this->strategyInstances[$config['strategy']] = new $strategyClass($this);
            }

            $this->strategies[$class] = $config['strategy'];
        }

        return $this->strategyInstances[$this->strategies[$class]];
    }

    /**
     * Get the list of strategy instances used for
     * given object classes
     *
     * @param array $classes
     *
     * @return Strategy[]
     */
    protected function getStrategiesUsedForObjects(array $classes)
    {
        $strategies = array();
        foreach ($classes as $name => $opt) {
            if (isset($this->strategies[$name]) && !isset($strategies[$this->strategies[$name]])) {
                $strategies[$this->strategies[$name]] = $this->strategyInstances[$this->strategies[$name]];
            }
        }

        return $strategies;
    }
}
