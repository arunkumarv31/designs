<?php
function clean($string) {
   $string = str_replace(' ', '-', $string);
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

function expand($string){
  switch($string){
    case 'n':
      return 'Noun';
      break;
    case 'a':
      return 'Adjective';
      break;
    case 'idm':
      return 'idiom';
      break;
    case '-':
      return '--';
      break;
    case 'v':
      return 'verb';
      break;
    case 'adv':
      return 'adverb';
      break;
    case 'prep':
      return 'preposition';
      break;
    case 'abbr':
      return 'abbreviation';
      break;
    case 'conj':
      return 'conjugation';
      break;
    case 'propn':
      return 'Proper noun';
      break;
    case 'interj':
      return 'interjections';
      break;
    case 'auxv':
      return 'Auxiliary verb';
      break;
    case 'sfx':
      return 'Suffix';
      break;
    case 'pfx':
      return 'Prefix';
      break;
    case 'Phrv':
      return 'Phrasal verb';
      break;
    default:
      return $string;
      break;
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Malayalam Dictionary</title>
    <style>
    </style>
  </head>
  <body>

  <?php
    $host = 'localhost';
    $user = 'mysqluser';
    $pass = 'mysqlpass';
    $database = 'malayalam';

    header('Content-type: text/html; charset=UTF-8');

    $link = mysqli_connect( $host, $user, $pass );

    mysqli_query($link, 'SET character_set_results=utf8');
    mysqli_query($link, 'SET names=utf8');
    mysqli_query($link, 'SET character_set_client=utf8');
    mysqli_query($link, 'SET character_set_connection=utf8');
    mysqli_query($link, 'SET character_set_results=utf8');
    mysqli_query($link, 'SET collation_connection=utf8_general_ci');

    mysqli_select_db($link, $database);

    if (mysqli_connect_errno()) {

        echo mysqli_connect_error();

        echo '</body></html>';

        exit();
    }
  ?>

  <?php
    $q = clean($_GET['q']);
  ?>

  <form method="GET">
    <input type="text"  value="<?php echo $_GET['q'];?>" name="q" required autofocus>
    <input type="submit" value="Search">
  </form>

  <?php
    $prev = 'zero'; // just a value

    if ( $q ){
      if ($result = mysqli_query($link, "SELECT * from dictionary where english_word like '$q' or english_word like '% $q %' order by part_of_speech")) {

        echo '<div style="font-weight:bold;padding: 10px 0;">'.mysqli_num_rows($result)." results.</div>"; 

        if ( mysqli_num_rows($result) != 0 ) {

          while ( $row=mysqli_fetch_array($result,MYSQLI_NUM)) {

   	    if ( $prev == 'zero' ){
 	      echo expand ($row[2]); // To print the first part_of_speech value
              echo '<ul>';
  	    }

            if ($prev != 'zero' && $prev != $row[2] ){ // check if part_of_speech changed
              echo '</ul>';
	      echo expand($row[2]); // part_of_speech column
              echo '<ul>';
            }
	    if ( $row[2] == '-' ) echo '<li>'.$row[1]." : " .$row[3].'</li>';
            else echo '<li>'.$row[3].'</li>';
            $prev = $row[2]; 
          }
        echo '</ul>';
        }
   
        mysqli_free_result($result);
      }
    }
    mysqli_close($link);
  ?>
  </body>
</html>
