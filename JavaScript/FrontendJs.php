<?php

// ==========================================================
// 01. Bubbling, Capturing or Trickling
// ==========================================================

// Event Bubbling :
// ------------------------------
// when we called a event then, a propogation will happed from current DOM tree to upper DOM tree.
// propogation means called upper DOM tree event. up the hirarchy
// event should bubble up.


// example of a click event :
// ------------------------------
// idOfDOMTree.addEventHandler('click', function(){
//     // any action
// }, useCapture (true = enable capture / false or nothing = disabled means bubble will happen));


// Event Capturing / Trickling :
// ------------------------------
// Event Capturing is opposite from 'Event Bubbling'.
// Event will start calling from root DOM tree.


// How to stop the propagation of events while Event bubbling and Capturing? 
// --------------------------------------------------------------------------------
// idOfDOMTree.addEventHandler('click', (e) => {
//      e.stopPropagation();
// }, false);



// ==========================================================
// 02. Event Delegation
// ==========================================================
// Delegation is a technique for event handling in better way.
// Event Bubbling is exist then Event delegation also exist.


// ==========================================================
// 03. call, apply and bind method
// ==========================================================



// ==========================================================
// 04. Thinking Recursively
// ==========================================================


// ==========================================================
// 05. Debouncing in Javascript
// ==========================================================
// debouncing is a function that prevent a function call again and again
// a function call will occure when a specific time condition has meet.
// It is generally use in search bar, when user pause during typing, at this momonet
// an API call will happen.


// ==========================================================
// 06. Throttling in Javascript
// ==========================================================
// Generally use for performance optimizaton or rate limiting for function call or execution.

// suppose we have a button and when we clicked this then a network call will happen.
// Now if we clicked button again and again then network call will go again and again and that is performance issue.
// at this moment we can do this by help of setTimeout function.


// ==========================================================
// 07. Debouncing vs Throttling :
// ==========================================================
// both of using for performance optimization
// used for rate limiting of function call or a specific execution.



// - What is Debouncing
// -------------------------
// after certain condtion, then our expected function will occure.
// example : like during type search bar you paused more then 300 ms then api call will happen

// - What is Throttling
// -------------------------
// after certain limit of time, then our expected function will occure.
// example : api call will happen after every 300ms 


// - Difference between Debounce and Throttle functions
// -------------------------


// - Web performance optimization by Debouncing
// -------------------------


// - Rate limiting of function calls by Throttling
// -------------------------


// ==========================================================
// 08. CORS, Preflight Request, OPTIONS Method | Access Control Allow Origin Error Explained
// ==========================================================
// CORS is a mechanisume which is uses additional HTTP headers to tell the browser weathear a
// specific web app can share resource with another web app
// but both the web app should have different origin.

// Cross-Origin Resource Sharing (CORS) is an HTTP-header based mechanism that allows a server to indicate 
// any origins (domain, scheme, or port) other than its own from which a browser should permit loading resources


// Preflight Request, OPTIONS Method :
// -------------------------------------



// Access Control Allow Origin :
// -------------------------------------


// ==========================================================
// 08. Polyfill for bind method
// ==========================================================

