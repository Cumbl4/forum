<?php
    require 'connect.php';

    $url = $_SERVER['REQUEST_URI'];

    $route = '/';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_all.php';
    }

    $route = '/authentication';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_auth.php';
    }

    $route = '/admin';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_adm.php';
    }

    $route = '/registration';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_reg.php';
    }

    $route = '/logout';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_log.php';
    }

    $route = '/page/(?<catSlug>[a-zA-Z0-9_-]+)';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_cat.php';
    }

    $route = '/page/(?<catSlug>[a-zA-Z0-9_-]+)/(?<topicSlug>[a-zA-Z0-9_-]+)';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_topic.php';
    }

    $route = '/users/(?<userName>[a-zA-Z0-9_-]+)';
    if (preg_match("#$route#", $url, $params)) {
        $page = include 'forum_users.php';
    }

    $layout = file_get_contents('layout_forum.php');
    $layout = str_replace('{{ title }}', $page['title'], $layout);
    $layout = str_replace('{{ content }}', $page['content'], $layout);
    $layout = str_replace('{{ info }}', $page['info'], $layout);


    echo $layout;