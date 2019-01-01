<?php
    namespace Lychee;

    # Load required files
    require(__DIR__ . '/../php/define.php');
    require(__DIR__ . '/../php/autoload.php');

    use Lychee\Modules\Database;
    use Lychee\Modules\Settings;

    $query    = Database::prepare(Database::get(), 'SELECT thumbUrl,url,medium FROM ? ORDER BY RAND() LIMIT 1', array(LYCHEE_TABLE_PHOTOS));
    $unsorted = Database::execute(Database::get(), $query, __METHOD__, __LINE__);
    $obj = $unsorted->fetch_object();
    if($obj->medium){
      $url = '../' . LYCHEE_URL_UPLOADS_MEDIUM . $obj->url;
    } else {
      $url = '../' . LYCHEE_URL_UPLOADS_BIG . $obj->url;
    }
    $thumb = '../' . LYCHEE_URL_UPLOADS_THUMB . $obj->thumbUrl;
?>

<html>
<head>
  <meta http-equiv="refresh" content="30">
  <script src="stackblur.min.js"></script>
  <style>
    body {
      padding: 0px;
      margin: 0px;
      background-color: #000000;
    }

    img.picture {
      max-height: 100%;
      height: auto;
      width: auto;
      margin: auto;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      border-radius: 20px;
      display: none;
    }

    #background_canvas {
      width: 100%;
      height: 100%;
      position: absolute;
      //left: -5%;
      //top: -5%;
      z-index: -1;
    }

    #background {
      width: 100%;
      height: 100%;
      position: absolute;
    }

    #noise {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url(noise.png);
      background-repeat: repeat;
      z-index: -1;
    }

  </style>
</head>

<body>

 <img id="background" src="<?php echo($thumb); ?>" onload="start_blur()"></img>
 <canvas id="background_canvas"></canvas>
 <div id="noise" style="background-position: 44px 44px;"></div>

 <img class="picture" src="<?php echo($url); ?>" onload="this.style.display = 'block'"></img>
  <script>
    function start_blur(){
      var img = document.getElementById('background');
      var canvas = document.getElementById('background_canvas');

      StackBlur.image(img,canvas,20)

      canvas.style.width = img.width;
      canvas.style.height = img.height;

      document.body.removeChild(img);
    }
  </script>
</body>
</html>
