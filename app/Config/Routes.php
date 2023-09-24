<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/musicplayer', 'MainController::index');
$routes->post('upload_song', 'MainController::upload_song');
$routes->post('/create_playlist', 'MainController::create_playlist');
$routes->post('/addToPlaylist', 'MainController::addToPlaylist');
$routes->get('search', 'MainController::search');
$routes->get('/fetchUserPlaylists', 'PlaylistController::fetchUserPlaylists');


