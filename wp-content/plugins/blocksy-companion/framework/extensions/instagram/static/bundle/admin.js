!function(t){var n={};function e(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,e),o.l=!0,o.exports}e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{enumerable:!0,get:r})},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},e.t=function(t,n){if(1&n&&(t=e(t)),8&n)return t;if(4&n&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(e.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&n&&"string"!=typeof t)for(var o in t)e.d(r,o,function(n){return t[n]}.bind(null,o));return r},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},e.p="",e(e.s=4)}([function(t,n){t.exports=window.wp.element},function(t,n){t.exports=window.wp.i18n},function(t,n){t.exports=window.ctEvents},function(t,n){window.ctEvents=window.ctEvents||new function(){var t={},n=1,e=!1;function r(t,n){if("string"!=typeof t)return t;for(var e=t.replace(/\s\s+/g," ").trim().split(" "),r=e.length,o=Object.create(null),i=0;i<r;i++)o[e[i]]=n;return o}function o(t,n){for(var e={},r=Object.keys(t),o=r.length,i=0;i<o;i++){var u=r[i];e[u]=n(u,t[u])}return e}function i(t,r){function o(){return new Array(n).join("│ ")}e&&(void 0!==r?console.log("[Event] "+o()+t,"─",r):console.log("[Event] "+o()+t))}this.countAll=function(n){return t[n]},this.log=i,this.debug=function(t){return e=Boolean(t),this},this.on=function(n,u){return o(r(n,u),function(n,r){(t[n]||(t[n]=[])).push(r),e&&i("✚ "+n)}),this},this.one=function(n,u){return o(r(n,u),function(n,r){var o,u,c;(t[n]||(t[n]=[])).push((o=r,c=2,function(){return--c>0&&(u=o.apply(this,arguments)),c<=1&&(o=null),u})),e&&i("✚ ["+n+"]")}),this},this.off=function(n,u){return o(r(n,u),function(n,r){t[n]&&(r?t[n].splice(t[n].indexOf(r)>>>0,1):t[n]=[],e&&i("✖ "+n))}),this},this.trigger=function(e,u){return o(r(e),function(n){i("╭─ "+n,u),c(1);try{"fw:options:init"===n&&fw.options.startListeningToEvents(u.$elements||document.body),(t[n]||[]).map(e),(t.all||[]).map(e)}catch(t){if(console.log("%c [Events] Exception raised.","color: red; font-weight: bold;"),"undefined"==typeof console)throw t;console.error(t)}function e(t){t&&t.call(window,u)}c(-1),i("╰─ "+n,u)}),this;function c(t){void 0!==t&&(n+=t>0?1:-1),n<0&&(n=0)}},this.hasListeners=function(n){return!!t&&(t[n]||[]).length>0}}},function(t,n,e){"use strict";e.r(n);e(3);var r=e(2),o=e.n(r),i=e(0),u=e(1),c=function(){return function(t,n){if(Array.isArray(t))return t;if(Symbol.iterator in Object(t))return function(t,n){var e=[],r=!0,o=!1,i=void 0;try{for(var u,c=t[Symbol.iterator]();!(r=(u=c.next()).done)&&(e.push(u.value),!n||e.length!==n);r=!0);}catch(t){o=!0,i=t}finally{try{!r&&c.return&&c.return()}finally{if(o)throw i}}return e}(t,n);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),l=function(t){var n=Object(i.useState)("idle"),e=c(n,2),r=e[0],o=e[1];return Object(i.createElement)("div",{className:"ct-reset-instagram-caches"},Object(i.createElement)("button",{className:"button",onClick:function(t){t.preventDefault(),o("loading");var n=new FormData;n.append("action","blocksy_reset_instagram_transients"),fetch(ajaxurl,{method:"POST",body:n}).then(function(){o("done"),setTimeout(function(){return o("idle")},3e3)})}},{loading:Object(u.__)("Clearing...","blc"),done:Object(u.__)("Done","blc"),idle:Object(u.__)("Clear All","blc")}[r]))};o.a.on("blocksy:options:register",function(t){t["blocksy-instagram-reset"]=l})}]);