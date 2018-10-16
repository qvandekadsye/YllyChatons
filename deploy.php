<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'YllyChatons');

// Project repository
set('repository', 'https://github.com/qvandekadsye/Yllychatons.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

set('shared_files', ['app/config/parameters.yml', 'app/config/jwt/private.pem','app/config/jwt/private.pem']);


set('allow_anonymous_stats', false);

// Hosts

host('localhost')
    ->set('deploy_path', '/srv/http/yllychatons')
    ->user('quentinvdk');

task("composer:install", "composer install --no-dev");

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'composer:install',
    'database:nomigration',
    'deploy:assets',
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy');
    

// Tasks




desc("update la base de données");
task(
    'database:nomigration',
    function () {
        run('{{bin/php}} {{bin/console}} doctrine:schema:update --force');
    }
);


// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
