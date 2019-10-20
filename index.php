<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Shane_Oliver
 * @since 1.0.0
 */

defined('ABSPATH') or die;

$context = Timber::context();

$post = new Timber\Post();
$templates = ['index.html.twig'];

$context['post'] = $post;
$context['posts'] = new Timber\PostQuery();

Timber::render($templates, $context);