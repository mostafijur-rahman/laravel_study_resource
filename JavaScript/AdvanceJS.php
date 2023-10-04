<?php

// ===========================================================
// 14. Event loop
// ===========================================================


// window : 
// -----------
// 1. widnow is a object that holds web API and many other thing.
// 2. 



// web API : all of the thing present in 
// ---------------------------------------------------
// 1. setTimeout()
// 2. DOM API
// 3. LocalStoreage
// 4. console

// event loop :
// ---------------------------------------------------
// event loop is check the callback queue and if it find a process/task
// inside 'callback' queue then it will pass it to 'Call stack' for execution.
// wher event loop finds that the 'call stack' is empty then it will take 
// task from microtask queue and then callback queue. 


// mircotask queue :
// ---------------------------------------------------
// micro task has same as call back but it has higher priority then call back
// if there is any task comes into this queue then it will execute imedietly then
// then callback queue.

// all the callback task from promise will go in microtask queue.
// and mutation observer task wii go in microtask queue.

// mutation observer :
// ---------------------------------------------------
// mutation observer keeps on checking weather there is mutation in DOM tree or not
// if there is any mutation on DOM tree then it will execute some call backfunction.


// callback queue / task queue :
// ---------------------------------------------------
// where every task keep before exectuion from call stack. 
// 

// starvation of callback queue / starvation of microtask queue :
// -------------------------------------------------------------------
// if microtask create another microtask and goes on, at that moment as rules.
// ther will never execute task from callback queue and it called 'starvation of callback queue'.


// ===========================================================
// 15. Callback
// ===========================================================

// Callback definition
// ----------------------------
// Callback function enables us to do async programming in JS. 
// We use this for some functions that are interdependent on each other for execution. 
// For eg: Ordering can be done after adding items in cart. So we pass cb functions as argument to functions 
// which then call the cb function passed. However this causes some problems:

// Callback Hell
// ----------------------------
// Asynchronous operations in JavaScript can be achieved through callbacks. 
// Whenever there are multiple dependent Asynchronous operations it will result in a lot of nested callbacks.
// This will cause a 'pyramid of doom' like structure.

// Inversion of control
// ----------------------------
//  When we give the control of callbacks being called to some other API, 
// this may create a lot of issues. That API may be buggy, 
// may not call our callback and create order as in the above example, may call the payment callback twice etc.


// ===========================================================
// 16.  Promises
// ===========================================================

// A promise is an object 
// that representing 
// the eventual completion or failure 
// of an asynchronous operation.

// It is an object that carry future value


// promise has major two property - PromiseState and PromiseResult
//-------------------------------------------------------------------
// prototype - Promise
// PromiseState - 'pending / fullfilled / rejected'
// PromiseResult - 'undefinied / object response'


// callback hell example 
// -------------------------
// const cart = ['prod_1', 'prod_2', 'prod_3']

// createOrder(cart, function(orderId){
//     proceedToPayment(orderId, function(paymentInfo){
//         showOrderSummary(paymentInfo, function(){
//             updateWalletBalance();
//         })
//     })
// })



// we can use promise instead of callback example 
// -----------------------------------------------

// createOrder(cart)
//     .then(function(){
//         return proceedToPayment(orderId);
//     })
//     .then(function(){
//         return showOrderSummary(paymentInfo);
//     })
//     .then(function(){
//         return updateWalletBalance();
//     })

// must 'return' when we use chain in promise.


// promise usning arrow function
// -------------------------------

// createOrder(cart)
// .then(orderId => proceedToPayment(orderId))
// .then(paymentInfo => showOrderSummary(paymentInfo))
// .then(paymentInfo => updateWalletBalance(paymentInfo))

// *** promises object are immutable that means you can not change after resolve it.



// ===========================================================
// 16. Advance topics of promise
// ===========================================================

// Creating a Promise
// -------------------------------

// function crateOrder($cartItem){
//
//     // create promise manually
//     // resolve, reject argumets are provide from javaScript.
//     return new Promise(function(resolve, reject){
//
//         // resolve if all the thing is okay!
//         if(true){
//             resolve($dataObject);
//         }
//    
//         // reject is there anything wrong!
//         if(false){
//             const err = new Error('There is something wrong!');
//             reject($err);
//         }
//     })
//
// }


// Error Handling
// -------------------------------

// createOrder(cart)
//     .then(function(){
//         return proceedToPayment(orderId);
//     })
//      .catch(function(){
//          console.log('return error!');
//      })
//     .then(function(){
//         return showOrderSummary(paymentInfo);
//     })
//      .catch(function(){
//          console.log('return error!');
//      })
//     .then(function(){
//         return updateWalletBalance();
//     })
//      .catch(function(){
//          console.log('return error!');
//      })



// Promise Chaning
// -------------------------------
// in upper example is the promise chaining example


// ===========================================================
// 17. Async and Await
// ==========================================================

// what is 'async'
// ----------------------
// 'async' is a keyword that use before a function to crate a 'async function'

// what is 'async function'
// -------------------------
// 'async function' always return a promise.
// whatever we return 'new promise(...)' or we 'any_type_of_value' that always return a promsie.

// what is await
// ----------------------
// 'await' is a keyword that only can be used inside in 'async function'
// and write 'await' infront of 'promnise'.
// 


// how async await works behind the scenes
// ----------------------------------------


// Example of usining async/await
// --------------------------------


// Error Handling
// ---------------


// Interviews
// ------------


// Async await vs promise.then/.catch
// ------------------------------------




