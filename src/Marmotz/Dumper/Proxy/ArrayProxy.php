<?php

namespace Marmotz\Dumper\Proxy;

use Marmotz\Dumper\Dump;


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
    protected $keys;
    protected $maxKeyLength;
    protected $pointer;

    /**
     * Constructor
     *
     * @param array &$array
     * @param Dump  $dumper
     */
    public function __construct(array &$array, Dump $dumper)
    {
        $this->setMaxKeyLength(0);

        $this->array = array();

        foreach ($array as $key => $value) {
            if ($key !== $dumper->getDumpedArrayMarker()) {
                $dumpedKey               = $dumper->getDump($key, null, Dump::FORMAT_SHORT);
                $this->array[$dumpedKey] = $value;

                $this->setIfMaxKeyLength(strlen($dumpedKey));
            }
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
    public function getMaxKeyLength()
    {
        return $this->maxKeyLength;
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
     * Set max key length only if $length is greater than current max key length
     *
     * @param integer $length
     *
     * @return ArrayProxy
     */
    public function setIfMaxKeyLength($length)
    {
        return $this->setMaxKeyLength(
            max($this->getMaxKeyLength(), $length)
        );
    }

    /**
     * Set max key length
     *
     * @param [type] $length
     *
     * @return ArrayProxy
     */
    public function setMaxKeyLength($length)
    {
        $this->maxKeyLength = $length;

        return $this;
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