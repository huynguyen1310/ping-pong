<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:huynguyen1310/laravel-demo.git');

add('shared_files', ['.env']);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('dev')
  ->setHostName('146.190.93.45')
  ->set('remote_user', 'web')
  ->set('deploy_path', '~/site');

// Grabs the dotenv file from the github secret
task('deploy:secrets', function () {
  file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
  upload('.env', get('deploy_path') . '/shared');
});

// Hooks

after('deploy:failed', 'deploy:unlock');
