<?php

  if(isset($_POST['key']) && $_POST['key'] == 'Your API Key'){

    // Upload / Shortening Process
    if(isset($_POST['url'])){

      // URL Shortener
      $links = json_decode(file_get_contents('sharex.links'), true);
      do {
        $short = short();
      } while(isset($links[$short]));

      $links[$short] = $_POST['url'];

      if(file_put_contents('sharex.links', json_encode($links, JSON_PRETTY_PRINT))){
        echo '{"success": true, "url": "http://example.com/l/' . $short . '"}';
      } else {

        // Error
        echo '{"success": false, "error": "Link could not be saved."}';
      }
    } else if(isset($_FILES['file']['name'])){

      // Image / File Upload
      $file = $_FILES['file']['name'];
      $type = (preg_match('/(jpe?g|png|gif|bmp|tiff)/i', $file) ? 'i/' : 'f/');
      $path = '/srv/example.com/' . $type . $file;
      $link = 'http://example.com/' . $type . $file;
      if(!file_exists($path)){
        if(move_uploaded_file($_FILES['file']['tmp_name'], $path)){
          echo '{"success": true, "url": "' . $link . '"}';
        } else {
          echo '{"success": false, "error": "Error uploading File."}';
        }
      } else {
        echo '{"success": false, "error": "File exists."}';
      }
    }
  } else if(preg_match('/^\/l\/([A-Z0-9]{6})/i', $_SERVER['REQUEST_URI'], $short)){

    // Redirect
    $links = json_decode(file_get_contents('sharex.links'), true);
    header('Location: ' . $links[$short[1]], true, 301);
  } else {

    // Error
    echo '{"success": false, "error": "Wrong API Key."}';
  }

  function short($length = 6){
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charslength = strlen($chars);
    $short = '';
    for($i = 0; $i < $length; $i++) $short .= $chars[rand(0, $charslength - 1)];

    return $short;
  }

?>
