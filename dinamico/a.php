<?php

echo eval( '$var = (20 - 5);' );  // don't show anything
echo '<br><hr>';

echo ' someStringA ' . eval( 'echo $var = 15;' ); // outputs 15 someString 
echo '<br><hr>';

//or
echo ' someStringB ' . eval( 'echo $var = 15;' ) . ' otherString '; // 15 someString  otherString  
echo '<br><hr>';

//or
echo ' someStringC ' . eval( 'echo $var = 15;' ) . ' otherString ' . '...' .eval( 'echo " __ " . $var = 10;' ); // 15 __ 10 someString  otherString  ...
echo '<br><hr>';




$file = file_get_contents('formB.php');
$content = eval("?>$file");
echo $content;



phpinfo();

exit;
