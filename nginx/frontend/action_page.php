<?php
if (isset($_GET['search'])) {
  $query = $_GET['search'];
  if ($query === '') {
    echo '<script>alert("Please enter a search query."); window.history.back();</script>';
    exit;
  }
  
  // Append "buy near me" to the query
  $query .= ' marijuana strain buy near me';
  $url = 'https://www.google.com/search?q=' . urlencode($query);

  // Perform web scraping
  $html = file_get_contents($url);
  $dom = new DOMDocument();
  libxml_use_internal_errors(true); // Disable error reporting for malformed HTML
  $dom->loadHTML($html);
  libxml_clear_errors();

  // Extract the top 10 search results with "add to cart" or "buy" button
  $results = [];
  $links = $dom->getElementsByTagName('a');
  foreach ($links as $link) {
    $href = $link->getAttribute('href');
    if (strpos($href, '/url?q=') === 0) {
      $url = urldecode(substr($href, 7));
      // Remove "/&sa", "&sa", or "-1&sa" and any text that follows them in the URL
      $url = preg_replace('/\/&sa.*|&sa.*|-1&sa.*/', '', $url);
      $title = $link->textContent;
    //   if (strpos($title, 'add to cart') !== false || strpos($title, 'buy') !== false) 
    {
        $hash = generateRandomHash(); // Generate a random hash
        $results[] = [
          'title' => $title,
          'link' => $url,
          'hash' => $hash
        ];
      }
    }
    if (count($results) === 10) {
      break;
    }
  }

  // Generate the results.html page
  $filename = '/var/www/html/o/results_' . $results[0]['hash'] . '.php'; // Include the hash in the filename
  $file = fopen($filename, 'w');
  if ($file) {
    fwrite($file, '<html>');
    fwrite($file, '<head>');
    fwrite($file, '<meta name="viewport" content="width=device-width, initial-scale=0.5" />');
    fwrite($file, '<link rel="stylesheet" type="text/css" href="/style/results.css">');
    fwrite($file, '</head>');
    fwrite($file, '<body>');
    fwrite($file, '<div class="container">');
    fwrite($file, '<div class="card">');
    fwrite($file, '<div class="card-header">');
    fwrite($file, '<div class="button-container">');
    fwrite($file, '<a class="goback" href="/">Go Back</a>');
    fwrite($file, '<h3 class="header-title">Search Results for: ' . $_GET['search'] . '</h3>');
    fwrite($file, '<a class="share" onclick="shareResult()">Share This Result</a>');
    fwrite($file, '</div>');
    fwrite($file, '<div class="results">');
  
    foreach ($results as $result) {
      $title = $result['title'];
      $link = $result['link'];
      fwrite($file, '<div class="result">');
      fwrite($file, '<h4>' . $title . '</h4>');
      fwrite($file, '<a href="' . $link . '">' . $link . '</a>');
      fwrite($file, '</div>');
    }
  
    fwrite($file, '</div>');
    fwrite($file, '</div>');
    fwrite($file, '</div>');
    fwrite($file, '<script>');
    fwrite($file, 'function shareResult() {');
    fwrite($file, '  if (navigator.share) {');
    fwrite($file, '    navigator.share({');
    fwrite($file, '      title: "Search Result",');
    fwrite($file, '      text: "Check out this search result:",');
    fwrite($file, '      url: window.location.href');
    fwrite($file, '    })');
    fwrite($file, '      .then(() => console.log("Shared successfully."))');
    fwrite($file, '      .catch((error) => console.log("Error sharing:", error));');
    fwrite($file, '  } else {');
    fwrite($file, '    console.log("Web Share API not supported in this browser.");');
    fwrite($file, '  }');
    fwrite($file, '}');
    fwrite($file, '</script>');
    fwrite($file, '</body>');
    fwrite($file, '</html>');
  
    fclose($file);
  
    // Redirect to the results.php page
    header('Location: /o/results_' . $results[0]['hash'] . '.php');
    exit;
  } else {
    echo 'Failed to open ' . $filename . ' file for writing.';
  }
}

function generateRandomHash() {
  $length = 10;
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $hash = '';
  for ($i = 0; $i < $length; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $hash .= $characters[$index];
  }
  return $hash;
}
?>