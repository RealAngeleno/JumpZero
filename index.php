<?php
$current_url = $_SERVER['REQUEST_URI'];
$url_components = parse_url($current_url);

if (isset($url_components['query'])) {
    parse_str($url_components['query'], $query_params);
    if (isset($query_params['url'])) {
        $website = $query_params['url'];
    }
}
$website = filter_var($website, FILTER_SANITIZE_URL);
$website_host = parse_url($website, PHP_URL_HOST);

//Domain blocking. Only include the domain. (e.g. example.com NOT https://example.com) $blocklist = ["example.com", "google.com"];
$blocklist = [""];
//URL blocking. http://example.com/test and https://example.com/test are seen as different URLs. Follows same form as $blocklist, except with URLs.
$blockurl = [""];

if ($website == NULL) {
    die("No Link Specified");
}
//Die if the url doesn't start with http://, https://, or mailto:
elseif (strpos($website, "https://") !== 0 && strpos($website, "http://") !== 0 && strpos($website, "mailto:") !== 0) {
    echo("Invalid URL");
    die();
}
//Domain Blocking
elseif (in_array($website_host, $blocklist)) {
    die("Sorry, the domain you are attempting to jump to is blocked.");
}
//URL Blocking
elseif (in_array($website, $blockurl)) {
    die("Sorry, the URL you are attempting to jump to is blocked.");
    }
echo("Jumping to the following link: <a href='" . htmlspecialchars($website, ENT_QUOTES) . "'>" . htmlspecialchars($website, ENT_QUOTES) . "</a><br><br>You will automatically be redirected in 5 seconds...");
//Auto redirect to whatever site.
echo("<meta http-equiv='refresh' content='5; URL=$website'>");

echo("<hr>Made by <b>Angeleno</b> for World2ch.net");
