<?php
$website = "";
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

//Domain blocking. Only include the domain. (e.g. example.com NOT https://example.com)
$blocklist = [""];
//URL blocking. http://example.com/test and https://example.com/test are seen as different URLs.
$blockurl = [""];
//Skiplist. (have the jump script immediately redirect to domains listed here ) Only include the domain, not https://.
$skiplist = ["world2ch.net"];

if ($website == NULL) {
    die("No Link Specified");
}
elseif (strpos($website, "https://") !== 0 && strpos($website, "http://") !== 0 && strpos($website, "mailto:") !== 0) {
    echo("Invalid URL");
    die();
}
elseif (in_array($website_host, $skiplist)) {
    die("Quickly jumping to the following link: <a href='" . htmlspecialchars($website, ENT_QUOTES) . "'>" . htmlspecialchars($website, ENT_QUOTES) . "</a><meta http-equiv='refresh' content='0; URL=$website'>");
}
elseif (in_array($website_host, $blocklist)) {
    die("Sorry, the domain you are attempting to jump to is blocked.");
}
elseif (in_array($website, $blockurl)) {
    die("Sorry, the URL you are attempting to jump to is blocked.");
    }
echo("Jumping to the following link: <a href='" . htmlspecialchars($website, ENT_QUOTES) . "'>" . htmlspecialchars($website, ENT_QUOTES) . "</a><br><br>You will automatically be redirected in 5 seconds...");
//Auto redirect to whatever site.
echo("<meta http-equiv='refresh' content='5; URL=$website'>");

echo("<hr><a href='https://github.com/RealAngeleno/JumpZero'>JumpZero</a>");
