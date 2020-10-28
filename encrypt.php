

<?php
//$hash = password_hash($logSenha, PASSWORD_DEFAULT);

function troca($texto, $chave){
    $test = strrev($texto) .$chave;
    $x = 1;
    $z = 0;
    $q = 5;
    for($i = 0; $i < strlen($test) /4 ; $i++){
       $test = str_replace($test[$x], $test[$i], $test);
       $test[$z] = $test[$q];
       $x += 3;
       $q += 7;
       $z += 2;
       
       if($x >= strlen($test)){
         $x = 0; 
	   }

       if($z >= strlen($test)){
         $z = 1;
	   }

       if($q >= strlen($test)){
         $q = 0;
	   }
    };
    return $test;
}

function novaChave(){
    $texto =rand(); 
    $resultado = md5($texto); 
    return $resultado; 
}

/*function isEqual($text1, $text2){
   if ($text1 == $text2){
       return true;
   }
}*/

/*function test(){
   $tx1 = "a4fw";
   $tx1 = troca($tx1);
   $quantity = 0;

   for ($i = 0; $i < 999999; $i++){
       $teste = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_Rand(1,10))),1,4);
       $teste = troca($teste)
       if (isEqual($tx1, $teste)){
         // echo "</br>" .$tx2;
          $quantity += 1;
       };
       //$tx2 = str_replace($tx2, $i, $tx2);
   }

   echo "<br>Equals quantity = " .$quantity;
}

function encript($texto){

}
*/
?>