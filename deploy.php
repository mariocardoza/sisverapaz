<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'sisverapaz');

// Project repository
set('repository', 'git@github.com:mariocardoza/sisverapaz.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);


// Hosts

host('174.138.38.154')
    ->user('root')
    ->set('branch', 'master')
    ->set('php_version', '7.4')
    ->set('deploy_path', '/home/www/public/{{application}}');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});
desc('Restart server php fpm');
task('artisan:optimize', function () {});

// [Optional] if deploy fails automatically unlock.
task('restart-fpm', function () {
    run('sudo service php{{php_version}}-fpm restart');
});

after('deploy:failed', 'deploy:unlock');
after('deploy', 'restart-fpm');
// Migrate database before symlink new release.

//before('deploy:symlink', 'artisan:migrate');

