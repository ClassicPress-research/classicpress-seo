!function(t){var n={};function e(a){if(n[a])return n[a].exports;var r=n[a]={i:a,l:!1,exports:{}};return t[a].call(r.exports,r,r.exports,e),r.l=!0,r.exports}e.m=t,e.c=n,e.d=function(t,n,a){e.o(t,n)||Object.defineProperty(t,n,{enumerable:!0,get:a})},e.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},e.t=function(t,n){if(1&n&&(t=e(t)),8&n)return t;if(4&n&&"object"==typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(e.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&n&&"string"!=typeof t)for(var r in t)e.d(a,r,function(n){return t[n]}.bind(null,r));return a},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},e.p="",e(e.s=212)}({212:function(t,n,e){"use strict";var a,r;a=jQuery,r={init:function(){this.addButtons(),this.editingEvents(),this.saveEvents()},addButtons:function(){var t=a("#cpseo_seo_details, #cpseo_title, #cpseo_description, #cpseo_image_alt, #cpseo_image_title");t.each((function(){var t=a(this);t.append(' <a href=#" class="dashicons dashicons-edit" title="'+classicSEO.bulkEditTitle+'"></a>'),t.wrapInner("<span/>"),t.append(' <span><a href="#" class="button button-primary button-small cpseo-column-save-all">'+classicSEO.buttonSaveAll+'</a> <a href="#" class="button-link button-link-delete cpseo-column-cancel-all">'+classicSEO.buttonCancel+"</a></span>")})),t.on("click",".dashicons-edit, .cpseo-column-cancel-all",(function(n){n.preventDefault();var e=a(this).closest("th");a(this).hasClass("cpseo-column-cancel-all")?(t.removeClass("bulk-editing"),a(".cpseo-column-cancel","td.bulk-editing.dirty").trigger("click"),a("td.bulk-editing").removeClass("bulk-editing")):(e.toggleClass("bulk-editing"),a("td.column-"+e.attr("id")).toggleClass("bulk-editing"))}))},editingEvents:function(){a(".cpseo-column-value").on("input",(function(){var t=a(this),n=t.closest("td");t.text()!==t.prev().text()?n.addClass("dirty"):n.removeClass("dirty")})).on("keypress",(function(t){if(13===t.keyCode)return a(this).parent().find(".cpseo-column-save").trigger("click"),!1})),a(".cpseo-column-cancel").on("click",(function(t){t.preventDefault();var n=a(this).closest("td");n.removeClass("dirty");var e=n.find(".cpseo-column-value").prev(".cpseo-column-display");e.find("span").length&&(e=e.find("span")),n.find(".cpseo-column-value").text(e.text())}))},saveEvents:function(){var t=this;a(".cpseo-column-save-all").on("click",(function(n){n.preventDefault();var e={},r=[];a(".dirty.bulk-editing").each((function(){var t=a(this),n=parseInt(t.closest("tr").attr("id").replace("post-","")),i=t.find(".cpseo-column-value");r.push(t),e[n]=e[n]||{},e[n][i.data("field")]=i.text()})),t.save(e).done((function(n){n.success&&(r.forEach((function(n){t.setColumn(n)})),a(".cpseo-column-cancel-all","#cpseo_seo_details").trigger("click"))}))})),a(".cpseo-column-save").on("click",(function(n){n.preventDefault();var e=a(this).closest(".dirty"),r=parseInt(e.closest("tr").attr("id").replace("post-","")),i=e.find(".cpseo-column-value"),l={};l[r]={},l[r][i.data("field")]=i.text(),t.save(l).done((function(n){n.success&&t.setColumn(e)}))}))},setColumn:function(t){t.removeClass("dirty bulk-editing");var n=t.find(".cpseo-column-value").prev(".cpseo-column-display");n.find("span").length&&(n=n.find("span")),n.text(t.find(".cpseo-column-value").text())},save:function(t){return a.ajax({url:ajaxurl,type:"POST",dataType:"json",data:{action:"cpseo_bulk_edit_columns",security:classicSEO.security,rows:t}})}},a((function(){r.init()}))}});