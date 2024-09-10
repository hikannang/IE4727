//roots.js

/*Compute the real roots of a given quadratic equation,
if the roots are imaginary, this script displays NaN, 
becuase that is what results from taking the sqaure root 
of the negative number*/

//Getting the coefficients of the equation from the user:

var a = prompt("What is the value of 'a'? \n","");
var b = prompt("What is the value of 'b'? \n","");
var c = prompt("What is the value of 'c'? \n","");

//Compute teh square root and denominator of the result

var root_part = Math.sqrt(b * b - 4.0 * a * c);
var denom = 2.0 * a;

//Compute and display the 2 roots

var root1 = (-b + root_part) / denom;
var root2 = (-b - root_part) / denom;
document.write("The first root is: ", root1,"<br />");
document.write("The second root is: ", root2,"<br />");