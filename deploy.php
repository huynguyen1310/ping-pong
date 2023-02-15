<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:huynguyen1310/laravel-demo.git');

add('shared_files', ['.env']);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('146.190.93.45')
  ->set('remote_user', 'web')
  ->set('deploy_path', '~/site');

// Hooks

after('deploy:failed', 'deploy:unlock');
