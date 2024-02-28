<?php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('トップページ', route('home'));
});

Breadcrumbs::for('page', function (BreadcrumbTrail $trail, $page) {
    $trail->parent('home');
    $trail->push($page->title, route('page', [
        'page' => $page->slug
    ]));
});

Breadcrumbs::for('category.index', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('home');
    $trail->push($category->name, route('category.index', [
        'category' => $category->slug
    ]));
});

Breadcrumbs::for('post.category', function (BreadcrumbTrail $trail, $post, $category) {
    $trail->parent('category.index', $category);
    $trail->push($post->title, route('post.category', [
        'category' => $category->slug,
        'post' => $post->slug,
    ]));
});

Breadcrumbs::for('post.post', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('home');
    $trail->push($post->title, route('post.post', [
        'post' => $post->slug,
    ]));
});

Breadcrumbs::for('register.guidance', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('入会案内', route('register.guidance'));
});

Breadcrumbs::for('user.home', function (BreadcrumbTrail $trail) {
    $trail->push('マイページ', route('user.home'));
});

Breadcrumbs::for('user.category.index', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('user.home');
    $trail->push($category->name, route('user.category.index', [
        'category' => $category->slug
    ]));
});

Breadcrumbs::for('user.curriculum.index', function (BreadcrumbTrail $trail, $curriculum) {
    $trail->parent('user.home');
    $trail->push($curriculum->name, route('user.curriculum.index', [
        'curriculum' => $curriculum->slug
    ]));
});

Breadcrumbs::for('user.curriculum.post', function (BreadcrumbTrail $trail, $curriculum, $post) {
    $trail->parent('user.curriculum.index', $curriculum);
    $trail->push($curriculum->name, route('user.curriculum.post', [
        'curriculum' => $curriculum->slug,
        'post' => $post->slug,
    ]));
});

Breadcrumbs::for('user.register.guidance', function (BreadcrumbTrail $trail) {
    $trail->parent('user.home');
    $trail->push('入会案内', route('user.register.guidance'));
});
