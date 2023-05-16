<?php
        $conn = mysqli_connect( '127.0.0.1', 'root', 'sems', 'testdb' );
        $sensor_sql = "SELECT * FROM test;";
        $image_sql = "SELECT * FROM picture;";
        $sensor_result = mysqli_query( $conn, $sensor_sql );
        $image_result = mysqli_query( $conn, $image_sql );
        $img_row = mysqli_fetch_array( $image_result )
  
    ?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TEST PAGE</title>
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,600,700&display=swap" rel="stylesheet">
<div class="layout">
  <input name="nav" type="radio" class="nav sensor-radio" id="sensor" checked="checked" />
  <div class="page home-page">
    <div class="page-contents">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php
        while( $sensor_row = mysqli_fetch_array( $sensor_result ) ) {
          echo '<tr><td>' . $sensor_row[ 'id' ] . '</td><td>'. $sensor_row[ 'title' ] . '</td><td>' . $sensor_row[ 'date' ] . '</td><td>';
        }
    ?>
      </tbody>
    </table>


    </div>
  </div>
  <label class="nav" for="sensor">
    <span>
      Sensor
    </span>


  </label>

  <input name="nav" type="radio" class="image-radio" id="image" />
  <div class="page about-page">
    <div class="page-contents">


    <figure class="fir-img-figure">

        <img class="fir-author-img fir-clickcircle" src=<?php echo $img_row[ 'path' ]?> alt="David East - Author" onclick="window.open(this.src)">

        <figcaption>
          <div class="fig-author-figure-title"> id: <?php echo $img_row[ 'id' ]?></div>
          <div class="fig-author-figure-title">path: <?php echo $img_row[ 'path' ]?></div>
          <div class="fig-author-figure-title">date: <?php echo $img_row[ 'date' ]?></div>
        </figcaption>
    </figure>


    </div>
  </div>
  <label class="nav" for="image">

    <span>
      Image
      </span>
    </label>
  
</div>
  </body>
</html>