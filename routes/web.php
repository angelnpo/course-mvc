<?php

use App\Controllers\AboutController;
use App\Controllers\ContactsController;
use App\Controllers\CoursesController;
use App\Controllers\HomeController;
use Lib\Router;

Router::get('/', [HomeController::class, 'index']);

Router::get('/contacts', [ContactsController::class, 'index']);
Router::get('/contacts/create', [ContactsController::class, 'create']);
Router::post('/contacts', [ContactsController::class, 'store']);
Router::get('/contacts/:id', [ContactsController::class, 'show']);
Router::get('/contacts/:id/edit', [ContactsController::class, 'edit']);
Router::post('/contacts/:id', [ContactsController::class, 'update']);
Router::post('/contacts/:id/delete', [ContactsController::class, 'delete']);

Router::get('/courses/:slug', [CoursesController::class, 'index']);
Router::get('/about', [AboutController::class, 'index']);

Router::dispatch();

?>