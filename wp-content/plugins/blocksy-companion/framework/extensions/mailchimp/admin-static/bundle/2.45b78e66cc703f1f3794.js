(window.blocksyMailchimpExtJsonp=window.blocksyMailchimpExtJsonp||[]).push([[2],{12:function(e,t,n){"use strict";n.r(t);var r=n(0),a=n(11),c=n(2),i=n(10),o=n.n(i),u=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e},l=function(){return function(e,t){if(Array.isArray(e))return e;if(Symbol.iterator in Object(e))return function(e,t){var n=[],r=!0,a=!1,c=void 0;try{for(var i,o=e[Symbol.iterator]();!(r=(i=o.next()).done)&&(n.push(i.value),!t||n.length!==t);r=!0);}catch(e){a=!0,c=e}finally{try{!r&&o.return&&o.return()}finally{if(a)throw c}}return n}(e,t);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}();var s=null;t.default=function(e){var t,n,i=e.value,d=e.onChange,p=Object(r.useState)(s||[]),f=l(p,2),m=f[0],b=f[1],v=Object(r.useState)(!s),h=l(v,2),y=h[0],O=h[1],g=(t=regeneratorRuntime.mark(function e(){var t,n,r,a=!(arguments.length>0&&void 0!==arguments[0])||arguments[0];return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return a&&O(!0),(t=new FormData).append("action","blocksy_ext_mailchimp_get_actual_lists"),e.prev=3,e.next=6,fetch(ajaxurl,{method:"POST",body:t});case 6:if(200!==(n=e.sent).status){e.next=17;break}return e.next=10,n.json();case 10:if(!(r=e.sent).success){e.next=17;break}if("api_key_invalid"===r.data.result){e.next=17;break}return O(!1),b(r.data.result),s=r.data.result,e.abrupt("return");case 17:e.next=21;break;case 19:e.prev=19,e.t0=e.catch(3);case 21:O(!1);case 22:case"end":return e.stop()}},e,void 0,[[3,19]])}),n=function(){var e=t.apply(this,arguments);return new Promise(function(t,n){return function r(a,c){try{var i=e[a](c),o=i.value}catch(e){return void n(e)}if(!i.done)return Promise.resolve(o).then(function(e){r("next",e)},function(e){r("throw",e)});t(o)}("next")})},function(){return n.apply(this,arguments)});return Object(r.useEffect)(function(){g(!s)},[]),0===m.length?Object(r.createElement)("div",{className:"ct-select-input"},Object(r.createElement)("input",{disabled:!0,placeholder:y?Object(c.__)("Loading...","blc"):Object(c.__)("Invalid API Key...","blc")})):Object(r.createElement)(a.a,{selectedItem:i||m[0].id,onChange:function(e){return d(e)},itemToString:function(e){return e?(m.find(function(t){return t.id===e})||{}).name:""}},function(e){var t=e.getInputProps,n=e.getItemProps,a=(e.getLabelProps,e.getMenuProps),i=e.isOpen,l=(e.inputValue,e.highlightedIndex),s=e.selectedItem,d=e.openMenu;return Object(r.createElement)("div",{className:"ct-select-input"},Object(r.createElement)("input",u({},t({onFocus:function(){return d()},onClick:function(){return d()}}),{placeholder:Object(c.__)("Select list...","blc"),readOnly:!0})),i&&Object(r.createElement)("div",a({className:"ct-select-dropdown"}),m.map(function(e,t){return Object(r.createElement)("div",n({key:e.id,index:t,item:e.id,className:o()("ct-select-dropdown-item",{active:l===t,selected:s===e.id})}),e.name)})))})}}}]);