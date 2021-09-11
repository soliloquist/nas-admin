<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('application', 'nas-admin');
set('deploy_path', '~/{{application}}');
set('repository', 'git@github.com:soliloquist/nas-admin.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('54.169.178.69');

// Tasks

task('build', function () {
    cd('{{release_path}}');
    run('npm run build');
});

after('deploy:failed', 'deploy:unlock');
