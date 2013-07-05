<?php

namespace Mattlab\Dumper\Proxy;

use Mattlab\Dumper\Dump;


/**
 * Array proxy
 *
 * @package Dumper
 * @author  Renaud Littolff <rlittolff@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link    https://github.com/marmotz/Dumper
 */
class ArrayProxy implements \Iterator
{
    protected $array;
    protected $maxLengthKey;
    protected $keys;
    protected $pointer;

    /**
     * Constructor
     *
     * @param Dump  $dumper
     *
     * @param array $array
     */
    public function __construct(Dump $dumper, array $array)
    {
        $this->maxLengthKey = 0;

        $this->array = array();

        foreach ($array as $key => $value) {
            $key   = $dumper->dump($key, Dump::FORMAT_KEY);
            $value = $dumper->dump($value);

            $this->array[$key] = $value;

            $this->maxLengthKey = max($this->maxLengthKey, strlen($key));
        }

        $this->keys    = array_keys($this->array);
        $this->pointer = 0;
    }

    /**
     * Return current item (Iterator interface)
     *
     * @return string
     */
    public function current()
    {
        return $this->array[$this->key()];
    }

    /**
     * Return max length for keys
     *
     * @return integer
     */
    public function getMaxLengthKey()
    {
        return $this->maxLengthKey;
    }

    /**
     * Return current key (Iterator interface)
     *
     * @return string
     */
    public function key()
    {
        return $this->keys[$this->pointer];
    }

    /**
     * Forward current element (Iterator interface)
     */
    public function next()
    {
        $this->pointer++;
    }

    /**
     * Rewind array (Iterator interface)
     */
    public function rewind()
    {
        $this->rewind = 0;
    }

    /**
     * Return array size
     *
     * @return integer
     */
    public function size()
    {
        return count($this->array);
    }

    /**
     * Say if current element is a valid element (Iterator interface)
     *
     * @return boolean
     */
    public function valid()
    {
        return isset($this->keys[$this->pointer]);
    }
}