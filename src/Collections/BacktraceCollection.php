<?php

namespace Stratedge\Wye\Collections;

class BacktraceCollection extends Collection implements BacktraceCollectionInterface
{
    /**
     * Return a new collection of strings formatted generally into the
     * print_debug_backtrace() format.
     *
     * @return CollectionInterface
     */
    public function getTrace()
    {
        return $this->map(function ($item, $key) {
            // Convert arguments into something more readable
            if (!empty($item['args'])) {
                $args = array_map(function ($item) {
                    switch (true) {
                        case $item === null:
                            return 'null';
                        case $item === true:
                            return 'true';
                        case $item === false:
                            return 'false';
                        case is_array($item):
                            if (!count($item)) {
                                return 'array(0)';
                            } elseif (array_keys($item) !== range(0, count($item) -1)) {
                                return 'associative-array(' . count($item) . ')';
                            }
                            return 'sequential-array(' . count($item) . ')';
                        case is_object($item):
                            return get_class($item);
                        case is_string($item):
                            return "\"{$item}\"";
                        case is_numeric($item):
                            return $item;
                    }

                    return "\"{$item}\"";
                }, $item['args']);
            } else {
                $args = [];
            }

            return sprintf(
                '#%d %s%s%s(%s) called at [%s:%d]',
                $key,
                !empty($item['class']) ? $item['class'] : null,
                !empty($item['type']) ? $item['type'] : null,
                !empty($item['function']) ? $item['function'] : null,
                implode(', ', $args),
                !empty($item['file']) ? $item['file'] : null,
                !empty($item['line']) ? $item['line'] : null
            );
        });
    }
}
