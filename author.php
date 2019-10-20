<?php
/**
 * The template for displaying Author Archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Shane_Oliver
 * @since 1.0.0
 */

defined('ABSPATH') or die;

global $wp_query;

$context = Timber::context();

$post = new Timber\Post();
$templates = ['author.html.twig', 'index.html.twig'];

$context['post'] = $post;
$context['posts'] = new Timber\PostQuery();

if (isset($wp_query->query_vars['author'])) {
	$author = new Timber\User($wp_query->query_vars['author']);
	$context['author'] = $author;
	$context['title']  = 'Author Archives: ' . $author->name();
}

Timber::render($templates, $context);