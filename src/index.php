<?php
declare(strict_types=1);

if (basename($_SERVER['REQUEST_URI']) === 'adminer.css' && is_readable('adminer.css')) {
    header('Content-Type: text/css');
    readfile(__DIR__ . '/adminer.css');
    exit;
}

function adminer_object(): Adminer
{
    return new class extends Adminer
    {
        public function name(): ?string
        {
            return $this->getEnv('ADMINER_NAME') ?? parent::name();
        }

        public function loginForm(): void
        {
            parent::loginForm();

            if ($this->getEnv('ADMINER_AUTOLOGIN')) {
                echo script('
                    if (document.querySelector(\'#content > div.error\') == null) {
                        document.addEventListener(\'DOMContentLoaded\', function () {
                            document.forms[0].submit()
                        })
                    }
                ');
            }
        }

        public function loginFormField($name, $heading, $value): string
        {
            $envValue = $this->getLoginConfigValue($name);

            if ($envValue !== null) {
                $value = sprintf(
                    '<input name="auth[%s]" type="%s" value="%s">',
                    h($name),
                    h($name === 'password' ? 'password' : 'text'),
                    h($envValue)
                );
            }

            return parent::loginFormField($name, $heading, $value);
        }

        public function getLoginConfigValue(string $key): ?string
        {
            switch ($key) {
                case 'db': return $this->getEnv('ADMINER_DB');
                case 'driver': return $this->getEnv('ADMINER_DRIVER');
                case 'password': return $this->getEnv('ADMINER_PASSWORD');
                case 'server': return $this->getEnv('ADMINER_SERVER');
                case 'username': return $this->getEnv('ADMINER_USERNAME');
                case 'name': return $this->getEnv('ADMINER_NAME');
                default: return null;
            }
        }

        private function getEnv(string $key): ?string
        {
            return getenv($key) ?: null;
        }
    };
}

require __DIR__ . '/adminer.php';
