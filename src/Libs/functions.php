<?php

use App\Core\Auth;
use App\Core\Container;
use App\Core\Model;
use App\Core\Request;
use App\Core\Response;

/**
 * Function to debug
 *
 * @param mixed $data
 * @return void
 */
function dd($data): void
{
  echo '<pre>';
  print_r($data);
  echo '</pre>';
  exit;
}

/**
 * Get the public path
 *
 * @param string $path
 * @return string
 */
function public_path($path): string
{
  return PUBLIC_PATH . $path;
}

/**
 * Get the component file
 *
 * @param string $path
 * @return void
 */
function component($path, $data = []): void
{
  require_once VIEW_PATH . '/components/' . $path . '.php';
}

/**
 * Print value
 *
 * @param $mixed $value
 * @return void
 */
function __($value): void
{
  echo $value;
}

/**
 * Get the url by endpoint
 *
 * @param string $endpoint
 * @param array $params
 * @return string
 */
function url($endpoint, $params = []): string
{
  $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
  $baseUrl = strtok($baseUrl, "?");

  $base_endpoint = dirname($_SERVER['SCRIPT_NAME']);
  $base_endpoint = str_replace("\\", '/', $base_endpoint);

  $queryString = http_build_query($params);

  $url = $baseUrl . preg_replace('#/+#', '/', ($base_endpoint . '/' . $endpoint));

  if ($queryString) {
    $url .= '?' . $queryString;
  }

  return $url == '/' ? $url : rtrim($url, '/');
}

/**
 * Get and set flash message
 *
 * @param string $key
 * @param mixed $value
 * @return mixed
 */
function flash_message(string $key, mixed $value = null): mixed
{
  if (isset($key) && isset($value)) {
    $_SESSION[$key] = $value;
    return true;
  }

  $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;

  unset($_SESSION[$key]);

  return $value;
}

/**
 * Generate unique ID
 *
 * @return string
 */
function generateUniqueId(): string
{
  $prefix = substr(md5(uniqid(mt_rand(), true)), 0, 5);
  $suffix = random_int(100000, 999999);
  return $prefix . $suffix;
}

/**
 * Redirect to a url
 *
 * @param string $url
 * @return Response
 */
function redirect(string $url): Response
{
  return new Response($url);
}

/**
 * Get the authenticated user
 *
 * @return Model|null
 */
function authUser(): Model|null
{
  return Auth::user();
}

/**
 * Get the request object
 *
 * @return Request|null
 */
function request(): Request|null
{
  return Request::create();
}

/**
 * Compare two value dynamically
 *
 * @param mixed $a
 * @param mixed $operator
 * @param mixed $b
 * @return void
 */
function dynamicCompare($a, $operator, $b)
{
  if ($operator == '==') {
    return $a == $b;
  } elseif ($operator == '!=') {
    return $a != $b;
  } elseif ($operator == '>') {
    return $a > $b;
  } elseif ($operator == '<') {
    return $a < $b;
  } elseif ($operator == '>=') {
    return $a >= $b;
  } elseif ($operator == '<=') {
    return $a <= $b;
  } else {
    throw new InvalidArgumentException("Invalid operator: $operator");
  }
}

/**
 * Get the service container instance
 *
 * @return Container
 */
function container(): Container
{
  return Container::init();
}

/**
 * Get config value
 *
 * @param string $file
 * @param string $key
 * @return mixed
 */
function config(string $key, string $file = 'app'): mixed
{
  $arr = include("src/Configs/$file.php");
  return $arr[$key];
}

/**
 * Get first two letter of name
 *
 * @param string $name
 * @return string
 */
function getFirstTwoLetter(string $name): string
{
  $words = explode(' ', $name);

  if (count($words) >= 2) {
    return substr($words[0], 0, 1) . substr($words[1], 0, 1);
  }

  return substr($words[0], 0, 2);
}

/**
 * Set the request method
 * @param string $name
 * @return void
 */
function method(string $method): void
{
  echo '<input type="hidden" name="_method" value="'.strtoupper($method).'" />';
}

/**
 * Get fixed length string
 * @param string $string
 * @return string
 */
function the_excerpt(string $string, int $length = 90): string
{
  return substr($string, 0, $length) . '...';
}
