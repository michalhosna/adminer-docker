<?php

namespace docker {

    class ConfigProvider
    {
        /** @return array<int, ?string> */
        public static function getLoginConfig(): array
        {
            return [
                'db' => self::getEnv('ADMINER_DB'),
                'driver' => self::getEnv('ADMINER_DRIVER'),
                'password' => self::getEnv('ADMINER_PASSWORD'),
                'server' => self::getEnv('ADMINER_SERVER'),
                'username' => self::getEnv('ADMINER_USERNAME'),
                'name' => self::getEnv('ADMINER_NAME'),
            ];
        }

        /**
         * For Adminer::name()
         */
        public static function getAdminerName(): ?string
        {
            return self::getEnv('ADMINER_NAME');
        }

        public static function getLoginConfigSingle(string $key): ?string
        {
            return self::getLoginConfig()[$key] ?? null;
        }

        /**
         * For type safety.
         */
        public static function getEnv(string $key): ?string
        {
            return getenv($key) ?: null;
        }

    }

    class HelperFunctions
    {

    }


    function adminer_object()
    {

        class Adminer extends \Adminer
        {

            function name()
            {
                return ConfigProvider::getAdminerName() ?? parent::name();
            }

            function credentials(): array
            {
                [$server, $username, $password] = parent::credentials();

                return [
                    ConfigProvider::getLoginConfigSingle('server') ?? $server,
                    ConfigProvider::getLoginConfigSingle('username') ?? $username,
                    ConfigProvider::getLoginConfigSingle('password') ?? $password,
                ];
            }

            function login($login, $password): bool
            {
                return $password !== '' || ConfigProvider::getLoginConfigSingle('password') !== null;
            }

            function database(): string
            {
                $parent = parent::database();

                return !empty($parent) ? $parent : (ConfigProvider::getLoginConfigSingle('db') ?? '');
            }

            function loginForm()
            {
                // To send something when login form is fully prefilled
                echo '<input type="hidden" name="auth[hidden]">';
                parent::loginForm();
            }

            function loginFormField($name, $heading, $value): string
            {
                if (ConfigProvider::getLoginConfigSingle($name) !== null) {
                    $value = sprintf(
                        '<input type="%s" value="%s" disabled>',
                        $name === 'password' ? 'password' : 'text',
                        $name === 'password' ? '---------' : ConfigProvider::getLoginConfigSingle($name)
                    );
                }

                return $heading . $value;
            }

        }

        return new Adminer();
    }
}

namespace {

    if (basename($_SERVER['REQUEST_URI']) === 'adminer.css' && is_readable('adminer.css')) {
        header('Content-Type: text/css');
        readfile('adminer.css');
        exit;
    }

    if (\getenv('ADMINER_AUTOLOGIN') !== false) {
        $_GET['username'] = $_GET['username'] ?? '';

        if (\docker\ConfigProvider::getLoginConfigSingle('db') !== null && !isset($_GET['db'])) {
            $_GET['db'] = \docker\ConfigProvider::getLoginConfigSingle('db');
        }
    }

    if (\docker\ConfigProvider::getLoginConfigSingle('driver') !== null) {
        $_GET[\docker\ConfigProvider::getLoginConfigSingle('driver')] = '';
    }


    function adminer_object()
    {
        return \docker\adminer_object();
    }

    require('adminer.php');
}
