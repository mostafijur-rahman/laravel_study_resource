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






