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
    protected $dumper;
    protected $keys;
    protected $maxKeyLength;
    protected $pointer;
    protected $recursion;

    /**
     * Constructor
     *
     * @param Dump  $dumper
     *
     * @param array $array
     */
    public function __construct(Dump $dumper, array $array)
    {
        $this
            ->setDumper($dumper)
            ->setMaxKeyLength(0)
        ;

        $this->array = array();

        foreach ($array as $key => $value) {
            $dumpedKey               = $this->getDumper()->getDump($key, null, Dump::FORMAT_KEY);
            $this->array[$dumpedKey] = $value;

            $this
                ->setIfMaxKeyLength(strlen($dumpedKey))
                ->addRecursion(
                    $dumpedKey,
                    $this->checkIfIsRecursion($array, $key)
                )
            ;
        }

        $this->keys    = array_keys($this->array);
        $this->pointer = 0;
    }

    /**
     * Set if a given key is a recursion
     *
     * @param string  $key
     * @param boolean $isRecursion
     *
     * @return ArrayProxy
     */
    public function addRecursion($key, $isRecursion)
    {
        $this->recursion[$key] = (boolean) $isRecursion;

        return $this;
    }

    /**
     * Check if given key of a given array is a recursion
     *
     * @param array $array
     * @param mixed $key
     *
     * @return boolean
     */
    public function checkIfIsRecursion(array $array, $key)
    {
        ob_start();
        var_dump($array);

        $contents = preg_replace(
            '/<[^>]+>/',
            '',
            html_entity_decode(ob_get_clean())
        );

        if (preg_match("/\s+'" . $key . "' =>\s+&/", $contents) === 1) {
            $hash = sha1($contents);

            if ($this->getDumper()->hasHash($hash)) {
                return true;
            } else {
                $this->getDumper()->addHash($hash);

                return false;
            }
        } else {
            return false;
        }
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
     * Returns dumper
     *
     * @return Dump
     */
    public function getDumper()
    {
        return $this->dumper;
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
     * Returns if given key is a recursion
     *
     * @param mixed $key
     *
     * @return boolean
     */
    public function isRecursion($key)
    {
        return isset($this->recursion[$key]) && $this->recursion[$key] === true;
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
     * Set dumper
     *
     * @param Dump $dumper
     *
     * @return ArrayProxy
     */
    public function setDumper(Dump $dumper)
    {
        $this->dumper = $dumper;

        return $this;
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