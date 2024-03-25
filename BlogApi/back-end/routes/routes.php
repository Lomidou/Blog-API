<?php

require_once __DIR__ . '/router.php';

// GET
get('get/posts', 'back-end/views/post/read.php');

// GET
get('/posts/single', 'back-end/views/post/read_single.php');

// POST
post('/posts/create', 'back-end/views/post/create.php');

// PUT
put('/posts/update', 'back-end/views/post/update.php');

// DELETE
delete('/posts/delete', 'back-end/views/post/delete.php');

// 404
any('/404', 'views/404.php');
