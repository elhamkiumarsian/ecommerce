<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Questions</title>
</head>
<body>
 <h1 style="color:blue;">Question One</h1>
 <h3>Create a script to construct the following pattern, using a nested for loop.</h3>
    <div style="margin-left: 20px;">
    <?php
        $n=5;
        for($i=1; $i<=$n; $i++)
        {
          for($j=1; $j<=$i; $j++)
          {
           echo " * ";
          }
           echo "<br>";
        }
        for($i=$n; $i>=1; $i--)
        {
          for($j=1; $j<=$i; $j++)
          {
           echo " * ";
          }
           echo "<br>";
        }
     ?>
    </div>
    <br>
    <br>
    
   <h1 style="color:blue;">Question Two</h1>
   <h3>Write a function to sort an array.</h3>
     <div style="margin-left: 20px;"> 
       <form action="#" method="post">
         Please insert your array: "separate elements of array with comma ( , )" <input type="text" name="array1" placeholder="apple,orange,banana,.."><br>
        (you can inser both numbers and strings)<br><br>
      	 <input type="submit" value="Sorrt Array"><br><br>
   	   </form>
    	<?php
  	 	$array=$_POST["array1"];
  	 	$array1=explode(",",$array);
   		sort($array1);
  	 	print_r($array1) ;
  	 	?>
  	 </div>
    <br>
    <br>
    <h1 style="color:blue;">Question Three</h1>
    <h3>Write a PHP script to find the first character that is different between two strings.</h3>
      <div style="margin-left: 20px;">
    	<?php
    	 $string1 = 'football';
     	 $string2 = 'footboll';
     	 $different_position = strspn($string1 ^ $string2, "\0");
     	 echo "string1:".$string1;
    	 echo "<br>";
   	     echo "string2:".$string2;
     	 echo "<br>";
    	 printf("First difference between two strings at position %d: '%s' vs '%s'",$different_position, $string1[$different_position], $string2[$different_position]);
     	echo "<br><br>";
    	?>
   		 <h4 style="color:green;">you can try this task with getting data from input.</h4>
   		 <form action="#" method="post">
        	String one: <input type="text" name="str1" placeholder="insert your first string.."><br><br>
        	String two: <input type="text" name="str2" placeholder="insert your second string.."><br><br>
      	 <input type="submit" value="Find Differance"><br><br>
   		 </form>
        <?php
    	$str1=$_POST["str1"]; 
   	    $str2=$_POST["str2"]; 
   		$diff_pos = strspn($str1 ^ $str2, "\0");
   		echo "string1:".$str1;
        echo "<br>";
        echo "string2:".$str2;
        echo "<br>";
        printf("First difference between two strings at position %d: '%s' vs '%s'",$diff_pos, $str1[$diff_pos], $str2[$diff_pos]);
        echo "<br><br>";
        ?>
    </div>  
  <br>
  <br>
 <h1 style="color:blue;">Question Four</h1>
 <h3>Write a PHP function to convert Arabic Numbers to Roman Numerals.</h3>
   <div style="margin-left: 20px;">
     	<form action="#" method="post">
    	Arabic Number: <input type="number" name="number" placeholder="insert your arabic number.."><br><br>
   	    <input type="submit" value="convert Arabic Numbers to Roman Numerals"><br><br>
		</form>
	<?php
 
   	 $num=$_POST["number"]; 
  	 print_r('Roman Numerals Of: '.$num. ' Is: '.convert_arabic_roman($num));
  	 function convert_arabic_roman($num)
 		{ 
		$x='IVXLCDM'; 
		for($i=5,$j=$result='';$num;$j++,$i^=7) 
		for( $n=$num%$i,$num=$num/$i^0;   $n--  ;   $result=$x[$n>2?$j+$num-($num=-2)+$n=1:$j].$result); 
		return $result; 
		} 

	?>

   </div>

</body>
</html>