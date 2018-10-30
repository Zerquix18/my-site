<?php
$contributions_file = dirname(__FILE__) . '/contributions.json';
$modified_date = file_exists($contributions_file) ? filemtime($contributions_file) : null;

if ($modified_date || $modified_date > strtotime('-24 hours')) {
    echo file_get_contents($contributions_file);
    exit;
}

$ch = curl_init('https://api.github.com/search/issues?q=author%3Azerquix18');
curl_setopt($ch, CURLOPT_USERAGENT, 'Zerquix18');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$request = curl_exec($ch);
if (curl_error($ch)) {
    echo json_encode([
        'error' => 'Could not load contributions'
    ]);
    exit;
}

curl_close($ch);

$data = json_decode($request, true);
if (! $data) { // it wans't json, something went wrong
    echo json_encode([
        'error' => 'Could not load contributions'
    ]);
    exit;
}

$contributions = array_map(function ($contribution) {
    $return = [];
    $return['title']  = $contribution['title'];
    $return['avatar'] = $contribution['user']['avatar_url'];
    $return['type']   = strpos($contribution['html_url'], 'pull') ? 'Pull request' : 'Issue';
    $return['state']  = ucfirst($contribution['state']);
    $return['date']   = date('F j, Y', strtotime($contribution['created_at']));
    $return['url']      = $contribution['html_url'];
    $return['repo_url'] = $contribution['repository_url'];

    $repo_name = $contribution['repository_url'];
    $repo_name = explode('/', $repo_name);
    $repo_name = array_slice($repo_name, count($repo_name) -2, 2);
    $repo_name = implode('/', $repo_name);
    $return['repo_name'] = $repo_name;

    return $return;
}, $data['items']);

$contributions = array_slice($contributions, 0, 5);

$contributions = json_encode($contributions);

file_put_contents($contributions_file, $contributions);

echo $contributions;
