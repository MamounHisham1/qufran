<?php

if (!function_exists('reorderArray')) {
    /**
     * Reorder the array based on a custom order or alphabetically.
     *
     * @param  array  $array
     * @param  array  $order
     * @return array
     */
    function reorderArray(array $array, array $order = []): array
    {
        if (!empty($order)) {
            $orderedArray = [];
            foreach ($order as $key) {
                if (array_key_exists($key, $array)) {
                    $orderedArray[$key] = $array[$key];
                }
            }
            return $orderedArray;
        }

        // Default: reorder alphabetically by keys
        ksort($array);
        return $array;
    }
}
