<?php

if (!function_exists('get_image_url')) {
    /**
     * Get the full URL for an image stored via Filament
     *
     * @param string|null $path
     * @return string|null
     */
    function get_image_url($path)
    {
        if (empty($path)) {
            return null;
        }

        // If path already starts with http/https, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // If path starts with 'public/', remove it (Filament stores with 'public/' prefix)
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7); // Remove 'public/'
        }

        // Return the storage URL
        return asset('storage/' . $path);
    }
}
