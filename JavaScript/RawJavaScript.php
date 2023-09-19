<?php

// ===========================================================
// 1. JS Definitaiom
// ===========================================================

// JavaScript is a synchronous and single-threaded language. that means JS will execute one command
// at a time and in a specific order. So that means that it can only go to the next line once the current
// line has been finished executing. (synchronous, single-threaded language)


// ===========================================================
// 2. Execution context
// ===========================================================

// Everything in JS happens inside an 'Execution Context'. Execution context is like a big box and it has two components in it

// first component known as 'Memory Component / Variable environment'
// where every value keeps in key and pair like key:value
// Example: key:value, a:10, fn:{...}

// second component known as 'Code Component / Thread of execution'
// this is the place where code is executed one line at a time.
// Example: 


// ===========================================================
// 3. How JavaScript Code is executed in 'Execution Context'
// ===========================================================

// js code example
// -----------------------------

// var n=2; // line 01
// function square(num){ // line 02
//     var ans = num * num; // line 03
//     return ans; // line 04
// } // line 05
// var square2 = square(n); // line 06
// var square4 = square(4); // line 07


// wher we run the whole code whats happen?
// -----------------------------------------------

// step 1:
// ------------- 
// A global execution context is created. and this execution context is created
// in two phases. first phase is 'memory creation' phase and second is 'code execution' phase.

// First phase (knwon as 'memory creation' phase) : 
// ------------- -----------------------------------
// in this section JS will alocate memory to all the variables and functions.
// when line 01 will encounter and here is for var n:undefined (special value) will assign.
// when line 02 will encounter and here is for function squre:{...} (whole function body code) will assign.
// and also for var square2:undefined
// and also for var square4:undefined
// key known as 'placeholder/identfiers'

// Second phase (knwon as 'code execution' phase) : 
// ------------- -----------------------------------
// Now JS will run (whole program) from fist line to last line and execute this code now
// Now, when line 01 will encounter and here '2' will assign instead of 'undefined' var n:2 (here 'n' we can call it 'placeholder/identfiers')
// when line 02 will encounter and here is a function body and nothing to do here so whole function body will skip. (line 02 to 05)

// when line 06 will encounter and here is function invocation, and function over here mini program
// and when a functon invoked / mini progrma is invoked then all together a brand new 'Execution Context' is created.
// that means new two phase of 'new exection context' will create agaian and run as it is.
// in this step only body code will execute only

// in momory phase (phase one)
// -------------------------------
// here we take 'num' and 'ans' (placeholder/identifiers) for take memory space and assign 'undefinied'.
// num:undefined
// ans:undefined
// 'return ans' will ignore here

// in code execution phase (phase two)
// -------------------------------------
// 'num' (placeholder/identifiers) will assign 2 from function(agruments)
// then in 'ans' (placeholder/identifiers) will assign 2*2 = 4 
// then in line number 4. there is a special keyword 'return' will back to the whole program control
// to the previous execution context where this function was invoked with the 'num' result.

// as result in line number 6 where was var square2 = undefined is now square2 = 4 (in the level of global execution context)
// and just previous execution context will delete totally.

// and in line number 7 will encounter and as it is here a 'excution context' will create and every process will follow 
// and give a result with 'excution context' deleted.

// there is no line after 7 then whole 'global execution context' also deleted as well as.


// *** function invocation/calling : when function_name and round brackets is founded like 'function_name()' then function is now being executed


// call stack definition :
// -----------------------------
// it handles everything to manage 'execution context' creation, deletion and control and
// all the thing it's manage as stack so that's why it calls 'Call stack'. 

// *** 'Call stack also maintains the oreder of execution of ececution contexts'

// call stack also known as :
// -----------------------------
// 1. Call stack 
// 2. Execution context stack 
// 3. Program stack 
// 4. Control stack 
// 5. Runtime stack 
// 6. Machine stack 
// 1. call stack 
// 1. call stack 


// ===========================================================
// 4. Hoisting in JavaScript
// ===========================================================


// example :
// --------------------------
// getName();
// console.log(x);

// var x=7;
// function getName(){
//     console.log('Hello world!');
// }

// output
// ---------------------------
// Hello world!
// undefined

// ===========================================================
// 5. How functions will work in JS (
// ===========================================================


// ===========================================================
// 6. SHORTEST JS Program and window and this keywords
// ===========================================================

// shortest JS Program is empty js file and for run this file as it is 'Global execution context' will create and 
// operation will execute.

// window
//---------------------
// If we write 'window' in the console then we will see here lots of objects (functions) and variables
// and all of those are create js engine itself.

// window means global execution context instance
// if we declare a variable and function in GEC then we will access it by window.variable_name and also
// we will see it if we write 'window' in console.

// 'window' and 'this' keywords are same


// ===========================================================
// 7. undefined vs not defined in JS 
// ===========================================================
// 'undefined' means taking the memory but 'not defined'.
// 'undefined' means a special placholders/identifiers for this variable.

// loosly typed (weakly typed language) : it's not attached a vaiable to any data type
// 

// ===========================================================
// 8. The Scope Chain | Scope & Lexical Environment 
// ===========================================================

// The Scope Chain is directly related in Lexical Environment. (it's a concept)

// example :
// --------------------
// function a(){
//     cosole.log(b);
// }
// var b=10;
// a();

// output - 10

// example :
// --------------------
// function a(){
//     c();
//     function c(){
//         cosole.log(b);
//     }
// }
// var b=10;
// a();

// output - 10


// what is scope : 
// ---------------------
// scope means where you can access a specific variable and functions from code.

// Lexical Environment  : 
// ---------------------
// when a 'execution context' is created at that moment also 'Lexical Environment' is also created.
// so 'Lexical Environment' is the local memory of current execution context along with the 'Lexical Environment' of its parent execution context.
// Lexical means hirarchy/sequence


// ===========================================================
// 9. let & const & Temporal dead zone
// ===========================================================

// let & const declaration are Hoisted
// ----------------------------------------------
// when we declare let and const
// initially it take 'undefined' value
// but it is not attached with global context / current execution context
// it keep in under 'Script' section in same level
// and we can not use this 'let or const' in code without assign value on it.
// upper those roles are called 'let and const' hoisting.
// we can not re-declaire let and const in same execution context level. we will get 'syntaxError'

// var declaration
// ----------------------------------------------
// when we declare let and const
// initially it take 'undefined' value
// it is attached current execution context
// and we can use this 'var' in code without assign value on it.
// upper those roles are called 'var' hoisting.
// we can re-declaire 'var' variable in same execution context level.


// Temporal Dead Zone :
// ----------------------------------------------
// 'temporal dead zone' is the time since the 'let or const' variable hoisted and till initialized some value.
// when we try to access a variable during temporal dead zone, the we will get ReferrenceError.



// ===========================================================
// 10. BLOCK SCOPE & Shadowing
// ===========================================================

// block
// -----------------------
// {
//
// }
// this is a block
// it is also known as 'compound statement'
// 'compound statement' means multiple JS statment in one group.
// this block wrapped multiple statement.

// block has different memory space from it's current execution context. (let, const)
// but if 'var' has block scope then it's also available current execution context. (var)
// example ---
// {
// var a = 10; // available from it's current execution context.
// let b = 20; // only available different memory space from it's current execution context
// const c = 30; // only available different memory space from it's current execution context
// }


// why we need this 'compound statment' ?
// -------------------------------------------
// sometimes js exepect one statment for execute, and at this situation if we have multiple statement.
// at this moment we will put our mulitple statement code in a block. {}
// now this  mulitple statement code turned into a group of code (compound statment) and act like single line.

// example :
// -----------------------
// if(true) {...} = here if condition expect single statement that we can do by compound statement {...} 


// Shadowing :
// -----------------------

// let b=100;
//{
// var a = 10;
// let b = 20;
// const c = 30;
// console.log(a);
// console.log(b);
// console.log(c);
//}
// console.log(b);


// shadowing means, you declare a variable in a level and also declaire a
// same variable in a block {...} of same level.
// at this moment variable of inside block scope shading the outside variable
// Shawding means, representation of variable from inside to outside of a block.




// ===========================================================
// 11. Closures :
// ===========================================================
// Closures is function that bind/bundle together its lexical environment/scope.
// function that binds/bundle with it's lexical scope.

// function x(){
//  var a =7;
//  function y(){ // this function bind/bundle with it lexical env/scope
//   console.log(a);
//  }
//  y();
// }
// x();

// Uses of Closures :
// ---------------------
// 1. Module Design Pattern
// 2. Currying
// 3. Functions line once
// 4. memoize
// 5. maintaining state in async world
// 6. setTimeouts
// 7. Iterators
// many more ....


// ===========================================================
// 12. About Functions  part 01 :
// ===========================================================

// Function Statement / Function Declaration:
// -----------------------------------------------
// function a(){
//  ....
// }
// here is just a function statement


// Function Expression / Named Function Expression:
// --------------------------------------------------------
// var b = function a(){...}
// here we can assign a function in variable 'b'.


// Function Statement Vs Expression :
// -------------------------------------
// main difference is hoisting (memory creation phase)


// Anonymous Function :
// ---------------------------
// a function that has no name / has not own identity
// function(){...}
// Only we will use anonymous functions where function used as values.
// example: var b = function(){...}


// 'parameters' Vs 'arguments' :
// ----------------------------------------------
// function abcd(param1, param2){....}
// parameters are local variable of abcd functions.
// those identifiers are recived argument values are called parameters

// abcd(argumet1, argumet2)
// the value we passed during function called is argument 


// First class Functions / First class citizens:
// --------------------------------------------------
// the ability of a functions that can receive another function as parameter
// and also return function from inside a function is called 'First class functions'
// in short - ability to used like values


// ===========================================================
// 13. About Functions  part 02 :
// ===========================================================

// What is callback functions :
// ------------------------------
// a function that can pass as value into another function is called 'Callback function'.
// it is very powerful because it gives us 'Asynchronous' feature in synchronous single threaded lanaguage.
// we can do async thing in javascript