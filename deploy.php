<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'YllyChatons');

// Project repository
set('repository', 'https://github.com/qvandekadsye/Yllychatons.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);


set('allow_anonymous_stats', false);

// Hosts

host('localhost')
    ->set('deploy_path', '/srv/http/')
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
    'deploy:assets', // you prefer
    'deploy:cache:clear',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
])->desc('Deploy');
    

// Tasks

desc("créé la clé privée ssh");
task("generatessh:private", function () {
    run("openssl genrsa -out config/jwt/private.pem -aes256 4096");
});

desc("créé la clé public ssh");
task("generatessh:public", function () {
    run("openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem");
});

desc("créé la deuxième clé privée ssh");
task("generatessh:private2", function () {
    run("openssl rsa -in config/jwt/private.pem -out config/jwt/private2.pem");
});

desc("intervertit les clés privée");
task("generatessh:changePrivate", function () {
    run("mv config/jwt/private.pem config/jwt/private.pem-back");
    run("mv config/jwt/private2.pem config/jwt/private.pem");
});


desc("crée la base de données");
task(
    'database:nomigrationPart',
    function () {
        run('bin/console doctrine:schema:create');
    }
);

before('database:migrate', "database:noMigrationPart");

// [Optional] If deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
