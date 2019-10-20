<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Shane_Oliver
 * @since 1.0.0
 */

defined('ABSPATH') or die;

$context = Timber::context();

$post = new Timber\Post();
$templates = ['search.html.twig', 'archive.html.twig', 'index.html.twig'];

$context['post'] = $post;
$context['posts'] = new Timber\PostQuery();
$context['title'] = 'Search results for ' . get_search_query();

Timber::render($templates, $context);