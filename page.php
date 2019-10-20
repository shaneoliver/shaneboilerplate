<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Shane_Oliver
 * @since 1.0.0
 */

defined('ABSPATH') or die;

$context = Timber::context();

$post = new Timber\Post();
$templates = ['page.html.twig', 'index.html.twig'];

$context['post'] = $post;

Timber::render($templates, $context);
