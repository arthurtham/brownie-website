<?php

if (!function_exists('brownie_project_root')) {
    function brownie_project_root()
    {
        return "/brownie-website"; # Logical placeholder, lol. It's the name of the github repo.
    }
}

if (!function_exists('brownie_parse_dotenv')) {
    function brownie_parse_dotenv($dotenv_path)
    {
        $result = array();

        if (!is_readable($dotenv_path)) {
            return $result;
        }

        $lines = file($dotenv_path, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return $result;
        }

        foreach ($lines as $line_number => $line) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '#')) {
                continue;
            }

            if (str_starts_with($trimmed, 'export ')) {
                $trimmed = trim(substr($trimmed, 7));
            }

            $split_position = strpos($trimmed, '=');
            if ($split_position === false) {
                continue;
            }

            $key = trim(substr($trimmed, 0, $split_position));
            $value = trim(substr($trimmed, $split_position + 1));

            if ($key === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key) !== 1) {
                trigger_error('Invalid .env key on line ' . ($line_number + 1), E_USER_WARNING);
                continue;
            }

            if ($value !== '' && ($value[0] === '"' || $value[0] === "'")) {
                $quote = $value[0];
                if (substr($value, -1) === $quote) {
                    $value = substr($value, 1, -1);
                } else {
                    $value = substr($value, 1);
                }

                if ($quote === '"') {
                    $value = str_replace(
                        array('\\n', '\\r', '\\t', '\\"', '\\\\'),
                        array("\n", "\r", "\t", '"', '\\'),
                        $value
                    );
                }
            } else {
                $comment_position = strpos($value, ' #');
                if ($comment_position !== false) {
                    $value = rtrim(substr($value, 0, $comment_position));
                }
            }

            $result[$key] = $value;
        }

        return $result;
    }
}

if (!function_exists('brownie_load_dotenv')) {
    function brownie_load_dotenv($dotenv_path = null)
    {
        static $cache = array();

        if ($dotenv_path === null) {
            $dotenv_path = brownie_project_root() . '/.env';
        }

        if (!isset($cache[$dotenv_path])) {
            $cache[$dotenv_path] = brownie_parse_dotenv($dotenv_path);
        }

        return $cache[$dotenv_path];
    }
}

if (!function_exists('brownie_env')) {
    function brownie_env($key, $default = null, $env = null)
    {
        if ($env === null) {
            $env = brownie_load_dotenv();
        }

        if (!array_key_exists($key, $env)) {
            return $default;
        }

        return $env[$key];
    }
}

if (!function_exists('brownie_env_nullable')) {
    function brownie_env_nullable($key, $default = null, $env = null)
    {
        $value = brownie_env($key, $default, $env);
        if ($value === '') {
            return null;
        }

        return $value;
    }
}

if (!function_exists('brownie_env_array')) {
    function brownie_env_array($key, $default = array(), $env = null)
    {
        $value = brownie_env($key, null, $env);
        if ($value === null || $value === '') {
            return $default;
        }

        $decoded = json_decode($value, true);
        if (is_array($decoded)) {
            return array_values(array_filter($decoded, function ($item) {
                return $item !== null && $item !== '';
            }));
        }

        $parts = array_map('trim', explode(',', $value));
        $parts = array_values(array_filter($parts, function ($item) {
            return $item !== '';
        }));

        return count($parts) > 0 ? $parts : $default;
    }
}

?>