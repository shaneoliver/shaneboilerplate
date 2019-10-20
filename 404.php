<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Shane_Oliver
 * @since 1.0.0
 */

defined('ABSPATH') or die;

$context = Timber::context();

$post = new \Timber\Post();
$templates = ['404.html.twig', 'index.html.twig'];
$context['title'] = '404 Error';
$context['post'] = $post;

Timber::render($templates, $context);