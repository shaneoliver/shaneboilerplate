<?php 

/*
 * This file is strictly for functions that need to be global and don't
 * belong on the Timber Post object. Consider extending TimberPost to add
 * functionality that belongs to a post
*/

if (! function_exists('dd')) :
    function dd()
    {
        echo '<pre>';
        array_map( function( $x ) { var_dump( $x ); }, func_get_args() );
        echo '</pre>';
        die;
    }
endif;