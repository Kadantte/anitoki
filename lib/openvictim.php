<?php
$url = 'https://anitoki.com/2019/05/kimetsu-no-yaiba-08-subtitle-indonesia/';
$pUrl = parse_url($url);

// Load the HTML into a DOMDocument
$doc = new DOMDocument;
@$doc->loadHTMLFile($url);

// Look for all the 'a' elements
$links = $doc->getElementsByTagName('a');

$numLinks = 0;
foreach ($links as $link) {

    // Exclude if not a link or has 'nofollow'
    preg_match_all('/\S+/', strtolower($link->getAttribute('rel')), $rel);
    if (!$link->hasAttribute('href') || in_array('nofollow', $rel[0])) {
        continue;
    }

    // Exclude if internal link
    $href = $link->getAttribute('href');

    if (substr($href, 0, 2) === '//') {
        // Deal with protocol relative URLs as found on Wikipedia
        $href = $pUrl['scheme'] . ':' . $href;
    }

    $pHref = @parse_url($href);
    if (!$pHref || !isset($pHref['host']) ||
        strtolower($pHref['host']) === strtolower($pUrl['host'])
    ) {
        continue;
    }

    // Increment counter otherwise
    echo 'URL: ' . $link->getAttribute('href') . "<br>";
    $numLinks++;

}

echo "Count: $numLinks\n";