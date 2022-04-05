!function(t){"function"==typeof define&&define.amd?define(["jquery"],t):t("object"==typeof exports?require("jquery"):jQuery)}(function(k,b){function _(){return new Date(Date.UTC.apply(Date,arguments))}function C(){var t=new Date;return _(t.getFullYear(),t.getMonth(),t.getDate())}function n(t,e){return t.getUTCFullYear()===e.getUTCFullYear()&&t.getUTCMonth()===e.getUTCMonth()&&t.getUTCDate()===e.getUTCDate()}function t(t,e){return function(){return e!==b&&k.fn.datepicker.deprecated(e),this[t].apply(this,arguments)}}function T(t,e){k.data(t,"datepicker",this),this._events=[],this._secondaryEvents=[],this._process_options(e),this.dates=new i,this.viewDate=this.o.defaultViewDate,this.focusDate=null,this.element=k(t),this.isInput=this.element.is("input"),this.inputField=this.isInput?this.element:this.element.find("input"),this.component=!!this.element.hasClass("date")&&this.element.find(".add-on, .input-group-addon, .input-group-append, .input-group-prepend, .btn"),this.component&&0===this.component.length&&(this.component=!1),this.isInline=!this.component&&this.element.is("div"),this.picker=k(U.template),this._check_template(this.o.templates.leftArrow)&&this.picker.find(".prev").html(this.o.templates.leftArrow),this._check_template(this.o.templates.rightArrow)&&this.picker.find(".next").html(this.o.templates.rightArrow),this._buildEvents(),this._attachEvents(),this.isInline?this.picker.addClass("datepicker-inline").appendTo(this.element):this.picker.addClass("datepicker-dropdown dropdown-menu"),this.o.rtl&&this.picker.addClass("datepicker-rtl"),this.o.calendarWeeks&&this.picker.find(".datepicker-days .datepicker-switch, thead .datepicker-title, tfoot .today, tfoot .clear").attr("colspan",function(t,e){return Number(e)+1}),this._process_options({startDate:this._o.startDate,endDate:this._o.endDate,daysOfWeekDisabled:this.o.daysOfWeekDisabled,daysOfWeekHighlighted:this.o.daysOfWeekHighlighted,datesDisabled:this.o.datesDisabled}),this._allow_update=!1,this.setViewMode(this.o.startView),this._allow_update=!0,this.fillDow(),this.fillMonths(),this.update(),this.isInline&&this.show()}var e,i=(e={get:function(t){return this.slice(t)[0]},contains:function(t){for(var e=t&&t.valueOf(),i=0,a=this.length;i<a;i++)if(0<=this[i].valueOf()-e&&this[i].valueOf()-e<864e5)return i;return-1},remove:function(t){this.splice(t,1)},replace:function(t){t&&(k.isArray(t)||(t=[t]),this.clear(),this.push.apply(this,t))},clear:function(){this.length=0},copy:function(){var t=new i;return t.replace(this),t}},function(){var t=[];return t.push.apply(t,arguments),k.extend(t,e),t});T.prototype={constructor:T,_resolveViewName:function(i){return k.each(U.viewModes,function(t,e){if(i===t||-1!==k.inArray(i,e.names))return i=t,!1}),i},_resolveDaysOfWeek:function(t){return k.isArray(t)||(t=t.split(/[,\s]*/)),k.map(t,Number)},_check_template:function(t){try{return t===b||""===t?!1:(t.match(/[<>]/g)||[]).length<=0||0<k(t).length}catch(t){return!1}},_process_options:function(t){this._o=k.extend({},this._o,t);var e=this.o=k.extend({},this._o),i=e.language;M[i]||(i=i.split("-")[0],M[i]||(i=l.language)),e.language=i,e.startView=this._resolveViewName(e.startView),e.minViewMode=this._resolveViewName(e.minViewMode),e.maxViewMode=this._resolveViewName(e.maxViewMode),e.startView=Math.max(this.o.minViewMode,Math.min(this.o.maxViewMode,e.startView)),!0!==e.multidate&&(e.multidate=Number(e.multidate)||!1,!1!==e.multidate&&(e.multidate=Math.max(0,e.multidate))),e.multidateSeparator=String(e.multidateSeparator),e.weekStart%=7,e.weekEnd=(e.weekStart+6)%7;var a=U.parseFormat(e.format);e.startDate!==-1/0&&(e.startDate?e.startDate instanceof Date?e.startDate=this._local_to_utc(this._zero_time(e.startDate)):e.startDate=U.parseDate(e.startDate,a,e.language,e.assumeNearbyYear):e.startDate=-1/0),e.endDate!==1/0&&(e.endDate?e.endDate instanceof Date?e.endDate=this._local_to_utc(this._zero_time(e.endDate)):e.endDate=U.parseDate(e.endDate,a,e.language,e.assumeNearbyYear):e.endDate=1/0),e.daysOfWeekDisabled=this._resolveDaysOfWeek(e.daysOfWeekDisabled||[]),e.daysOfWeekHighlighted=this._resolveDaysOfWeek(e.daysOfWeekHighlighted||[]),e.datesDisabled=e.datesDisabled||[],k.isArray(e.datesDisabled)||(e.datesDisabled=e.datesDisabled.split(",")),e.datesDisabled=k.map(e.datesDisabled,function(t){return U.parseDate(t,a,e.language,e.assumeNearbyYear)});var s=String(e.orientation).toLowerCase().split(/\s+/g),n=e.orientation.toLowerCase(),s=k.grep(s,function(t){return/^auto|left|right|top|bottom$/.test(t)});if(e.orientation={x:"auto",y:"auto"},n&&"auto"!==n)if(1===s.length)switch(s[0]){case"top":case"bottom":e.orientation.y=s[0];break;case"left":case"right":e.orientation.x=s[0]}else n=k.grep(s,function(t){return/^left|right$/.test(t)}),e.orientation.x=n[0]||"auto",n=k.grep(s,function(t){return/^top|bottom$/.test(t)}),e.orientation.y=n[0]||"auto";e.defaultViewDate instanceof Date||"string"==typeof e.defaultViewDate?e.defaultViewDate=U.parseDate(e.defaultViewDate,a,e.language,e.assumeNearbyYear):e.defaultViewDate?(t=e.defaultViewDate.year||(new Date).getFullYear(),i=e.defaultViewDate.month||0,n=e.defaultViewDate.day||1,e.defaultViewDate=_(t,i,n)):e.defaultViewDate=C()},_applyEvents:function(t){for(var e,i,a,s=0;s<t.length;s++)e=t[s][0],2===t[s].length?(i=b,a=t[s][1]):3===t[s].length&&(i=t[s][1],a=t[s][2]),e.on(a,i)},_unapplyEvents:function(t){for(var e,i,a,s=0;s<t.length;s++)e=t[s][0],2===t[s].length?(a=b,i=t[s][1]):3===t[s].length&&(a=t[s][1],i=t[s][2]),e.off(i,a)},_buildEvents:function(){var t={keyup:k.proxy(function(t){-1===k.inArray(t.keyCode,[27,37,39,38,40,32,13,9])&&this.update()},this),keydown:k.proxy(this.keydown,this),paste:k.proxy(this.paste,this)};!0===this.o.showOnFocus&&(t.focus=k.proxy(this.show,this)),this.isInput?this._events=[[this.element,t]]:this.component&&this.inputField.length?this._events=[[this.inputField,t],[this.component,{click:k.proxy(this.show,this)}]]:this._events=[[this.element,{click:k.proxy(this.show,this),keydown:k.proxy(this.keydown,this)}]],this._events.push([this.element,"*",{blur:k.proxy(function(t){this._focused_from=t.target},this)}],[this.element,{blur:k.proxy(function(t){this._focused_from=t.target},this)}]),this.o.immediateUpdates&&this._events.push([this.element,{"changeYear changeMonth":k.proxy(function(t){this.update(t.date)},this)}]),this._secondaryEvents=[[this.picker,{click:k.proxy(this.click,this)}],[this.picker,".prev, .next",{click:k.proxy(this.navArrowsClick,this)}],[this.picker,".day:not(.disabled)",{click:k.proxy(this.dayCellClick,this)}],[k(window),{resize:k.proxy(this.place,this)}],[k(document),{"mousedown touchstart":k.proxy(function(t){this.element.is(t.target)||this.element.find(t.target).length||this.picker.is(t.target)||this.picker.find(t.target).length||this.isInline||this.hide()},this)}]]},_attachEvents:function(){this._detachEvents(),this._applyEvents(this._events)},_detachEvents:function(){this._unapplyEvents(this._events)},_attachSecondaryEvents:function(){this._detachSecondaryEvents(),this._applyEvents(this._secondaryEvents)},_detachSecondaryEvents:function(){this._unapplyEvents(this._secondaryEvents)},_trigger:function(t,e){e=e||this.dates.get(-1),e=this._utc_to_local(e);this.element.trigger({type:t,date:e,viewMode:this.viewMode,dates:k.map(this.dates,this._utc_to_local),format:k.proxy(function(t,e){0===arguments.length?(t=this.dates.length-1,e=this.o.format):"string"==typeof t&&(e=t,t=this.dates.length-1),e=e||this.o.format;var i=this.dates.get(t);return U.formatDate(i,e,this.o.language)},this)})},show:function(){if(!(this.inputField.is(":disabled")||this.inputField.prop("readonly")&&!1===this.o.enableOnReadonly))return this.isInline||this.picker.appendTo(this.o.container),this.place(),this.picker.show(),this._attachSecondaryEvents(),this._trigger("show"),(window.navigator.msMaxTouchPoints||"ontouchstart"in document)&&this.o.disableTouchKeyboard&&k(this.element).blur(),this},hide:function(){return this.isInline||!this.picker.is(":visible")||(this.focusDate=null,this.picker.hide().detach(),this._detachSecondaryEvents(),this.setViewMode(this.o.startView),this.o.forceParse&&this.inputField.val()&&this.setValue(),this._trigger("hide")),this},destroy:function(){return this.hide(),this._detachEvents(),this._detachSecondaryEvents(),this.picker.remove(),delete this.element.data().datepicker,this.isInput||delete this.element.data().date,this},paste:function(t){var e;if(t.originalEvent.clipboardData&&t.originalEvent.clipboardData.types&&-1!==k.inArray("text/plain",t.originalEvent.clipboardData.types))e=t.originalEvent.clipboardData.getData("text/plain");else{if(!window.clipboardData)return;e=window.clipboardData.getData("Text")}this.setDate(e),this.update(),t.preventDefault()},_utc_to_local:function(t){if(!t)return t;var e=new Date(t.getTime()+6e4*t.getTimezoneOffset());return e=e.getTimezoneOffset()!==t.getTimezoneOffset()?new Date(t.getTime()+6e4*e.getTimezoneOffset()):e},_local_to_utc:function(t){return t&&new Date(t.getTime()-6e4*t.getTimezoneOffset())},_zero_time:function(t){return t&&new Date(t.getFullYear(),t.getMonth(),t.getDate())},_zero_utc_time:function(t){return t&&_(t.getUTCFullYear(),t.getUTCMonth(),t.getUTCDate())},getDates:function(){return k.map(this.dates,this._utc_to_local)},getUTCDates:function(){return k.map(this.dates,function(t){return new Date(t)})},getDate:function(){return this._utc_to_local(this.getUTCDate())},getUTCDate:function(){var t=this.dates.get(-1);return t!==b?new Date(t):null},clearDates:function(){this.inputField.val(""),this.update(),this._trigger("changeDate"),this.o.autoclose&&this.hide()},setDates:function(){var t=k.isArray(arguments[0])?arguments[0]:arguments;return this.update.apply(this,t),this._trigger("changeDate"),this.setValue(),this},setUTCDates:function(){var t=k.isArray(arguments[0])?arguments[0]:arguments;return this.setDates.apply(this,k.map(t,this._utc_to_local)),this},setDate:t("setDates"),setUTCDate:t("setUTCDates"),remove:t("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead"),setValue:function(){var t=this.getFormattedDate();return this.inputField.val(t),this},getFormattedDate:function(e){e===b&&(e=this.o.format);var i=this.o.language;return k.map(this.dates,function(t){return U.formatDate(t,e,i)}).join(this.o.multidateSeparator)},getStartDate:function(){return this.o.startDate},setStartDate:function(t){return this._process_options({startDate:t}),this.update(),this.updateNavArrows(),this},getEndDate:function(){return this.o.endDate},setEndDate:function(t){return this._process_options({endDate:t}),this.update(),this.updateNavArrows(),this},setDaysOfWeekDisabled:function(t){return this._process_options({daysOfWeekDisabled:t}),this.update(),this},setDaysOfWeekHighlighted:function(t){return this._process_options({daysOfWeekHighlighted:t}),this.update(),this},setDatesDisabled:function(t){return this._process_options({datesDisabled:t}),this.update(),this},place:function(){if(this.isInline)return this;var t=this.picker.outerWidth(),e=this.picker.outerHeight(),i=k(this.o.container),a=i.width(),s=("body"===this.o.container?k(document):i).scrollTop(),n=i.offset(),o=[0];this.element.parents().each(function(){var t=k(this).css("z-index");"auto"!==t&&0!==Number(t)&&o.push(Number(t))});var r=Math.max.apply(Math,o)+this.o.zIndexOffset,h=(this.component?this.component.parent():this.element).offset(),l=this.component?this.component.outerHeight(!0):this.element.outerHeight(!1),d=this.component?this.component.outerWidth(!0):this.element.outerWidth(!1),i=h.left-n.left,n=h.top-n.top;"body"!==this.o.container&&(n+=s),this.picker.removeClass("datepicker-orient-top datepicker-orient-bottom datepicker-orient-right datepicker-orient-left"),"auto"!==this.o.orientation.x?(this.picker.addClass("datepicker-orient-"+this.o.orientation.x),"right"===this.o.orientation.x&&(i-=t-d)):h.left<0?(this.picker.addClass("datepicker-orient-left"),i-=h.left-10):a<i+t?(this.picker.addClass("datepicker-orient-right"),i+=d-t):this.o.rtl?this.picker.addClass("datepicker-orient-right"):this.picker.addClass("datepicker-orient-left");t=this.o.orientation.y;return"auto"===t&&(t=-s+n-e<0?"bottom":"top"),this.picker.addClass("datepicker-orient-"+t),"top"===t?n-=e+parseInt(this.picker.css("padding-top")):n+=l,this.o.rtl?this.picker.css({top:n,right:a-(i+d),zIndex:r}):this.picker.css({top:n,left:i,zIndex:r}),this},_allow_update:!0,update:function(){if(!this._allow_update)return this;var t=this.dates.copy(),i=[],e=!1;return arguments.length?(k.each(arguments,k.proxy(function(t,e){e instanceof Date&&(e=this._local_to_utc(e)),i.push(e)},this)),e=!0):(i=(i=this.isInput?this.element.val():this.element.data("date")||this.inputField.val())&&this.o.multidate?i.split(this.o.multidateSeparator):[i],delete this.element.data().date),i=k.map(i,k.proxy(function(t){return U.parseDate(t,this.o.format,this.o.language,this.o.assumeNearbyYear)},this)),i=k.grep(i,k.proxy(function(t){return!this.dateWithinRange(t)||!t},this),!0),this.dates.replace(i),this.o.updateViewDate&&(this.dates.length?this.viewDate=new Date(this.dates.get(-1)):this.viewDate<this.o.startDate?this.viewDate=new Date(this.o.startDate):this.viewDate>this.o.endDate?this.viewDate=new Date(this.o.endDate):this.viewDate=this.o.defaultViewDate),e?(this.setValue(),this.element.change()):this.dates.length&&String(t)!==String(this.dates)&&e&&(this._trigger("changeDate"),this.element.change()),!this.dates.length&&t.length&&(this._trigger("clearDate"),this.element.change()),this.fill(),this},fillDow:function(){if(this.o.showWeekDays){var t=this.o.weekStart,e="<tr>";for(this.o.calendarWeeks&&(e+='<th class="cw">&#160;</th>');t<this.o.weekStart+7;)e+='<th class="dow',-1!==k.inArray(t,this.o.daysOfWeekDisabled)&&(e+=" disabled"),e+='">'+M[this.o.language].daysMin[t++%7]+"</th>";e+="</tr>",this.picker.find(".datepicker-days thead").append(e)}},fillMonths:function(){for(var t=this._utc_to_local(this.viewDate),e="",i=0;i<12;i++)e+='<span class="month'+(t&&t.getMonth()===i?" focused":"")+'">'+M[this.o.language].monthsShort[i]+"</span>";this.picker.find(".datepicker-months td").html(e)},setRange:function(t){t&&t.length?this.range=k.map(t,function(t){return t.valueOf()}):delete this.range,this.fill()},getClassNames:function(t){var e=[],i=this.viewDate.getUTCFullYear(),a=this.viewDate.getUTCMonth(),s=C();return t.getUTCFullYear()<i||t.getUTCFullYear()===i&&t.getUTCMonth()<a?e.push("old"):(t.getUTCFullYear()>i||t.getUTCFullYear()===i&&t.getUTCMonth()>a)&&e.push("new"),this.focusDate&&t.valueOf()===this.focusDate.valueOf()&&e.push("focused"),this.o.todayHighlight&&n(t,s)&&e.push("today"),-1!==this.dates.contains(t)&&e.push("active"),this.dateWithinRange(t)||e.push("disabled"),this.dateIsDisabled(t)&&e.push("disabled","disabled-date"),-1!==k.inArray(t.getUTCDay(),this.o.daysOfWeekHighlighted)&&e.push("highlighted"),this.range&&(t>this.range[0]&&t<this.range[this.range.length-1]&&e.push("range"),-1!==k.inArray(t.valueOf(),this.range)&&e.push("selected"),t.valueOf()===this.range[0]&&e.push("range-start"),t.valueOf()===this.range[this.range.length-1]&&e.push("range-end")),e},_fill_yearsView:function(t,e,i,a,s,n,o){for(var r,h,l,d="",c=i/10,t=this.picker.find(t),u=Math.floor(a/i)*i,p=u+9*c,f=Math.floor(this.viewDate.getFullYear()/c)*c,g=k.map(this.dates,function(t){return Math.floor(t.getUTCFullYear()/c)*c}),D=u-c;D<=p+c;D+=c)r=[e],h=null,D===u-c?r.push("old"):D===p+c&&r.push("new"),-1!==k.inArray(D,g)&&r.push("active"),(D<s||n<D)&&r.push("disabled"),D===f&&r.push("focused"),o!==k.noop&&((l=o(new Date(D,0,1)))===b?l={}:"boolean"==typeof l?l={enabled:l}:"string"==typeof l&&(l={classes:l}),!1===l.enabled&&r.push("disabled"),l.classes&&(r=r.concat(l.classes.split(/\s+/))),l.tooltip&&(h=l.tooltip)),d+='<span class="'+r.join(" ")+'"'+(h?' title="'+h+'"':"")+">"+D+"</span>";t.find(".datepicker-switch").text(u+"-"+p),t.find("td").html(d)},fill:function(){var t,e=new Date(this.viewDate),i=e.getUTCFullYear(),a=e.getUTCMonth(),s=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,n=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,o=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,r=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,h=M[this.o.language].today||M.en.today||"",l=M[this.o.language].clear||M.en.clear||"",d=M[this.o.language].titleFormat||M.en.titleFormat,c=C(),c=(!0===this.o.todayBtn||"linked"===this.o.todayBtn)&&c>=this.o.startDate&&c<=this.o.endDate&&!this.weekOfDateIsDisabled(c);if(!isNaN(i)&&!isNaN(a)){this.picker.find(".datepicker-days .datepicker-switch").text(U.formatDate(e,d,this.o.language)),this.picker.find("tfoot .today").text(h).css("display",c?"table-cell":"none"),this.picker.find("tfoot .clear").text(l).css("display",!0===this.o.clearBtn?"table-cell":"none"),this.picker.find("thead .datepicker-title").text(this.o.title).css("display","string"==typeof this.o.title&&""!==this.o.title?"table-cell":"none"),this.updateNavArrows(),this.fillMonths();var u=_(i,a,0),a=u.getUTCDate();u.setUTCDate(a-(u.getUTCDay()-this.o.weekStart+7)%7);var p=new Date(u);u.getUTCFullYear()<100&&p.setUTCFullYear(u.getUTCFullYear()),p.setUTCDate(p.getUTCDate()+42);for(var f,g,D,p=p.valueOf(),m=[];u.valueOf()<p;){(f=u.getUTCDay())===this.o.weekStart&&(m.push("<tr>"),this.o.calendarWeeks)&&(g=new Date(+u+(this.o.weekStart-f-7)%7*864e5),y=new Date(Number(g)+(11-g.getUTCDay())%7*864e5),D=new Date(Number(D=_(y.getUTCFullYear(),0,1))+(11-D.getUTCDay())%7*864e5),m.push('<td class="cw">'+((y-D)/864e5/7+1)+"</td>")),(g=this.getClassNames(u)).push("day");var y=u.getUTCDate();this.o.beforeShowDay!==k.noop&&((D=this.o.beforeShowDay(this._utc_to_local(u)))===b?D={}:"boolean"==typeof D?D={enabled:D}:"string"==typeof D&&(D={classes:D}),!1===D.enabled&&g.push("disabled"),D.classes&&(g=g.concat(D.classes.split(/\s+/))),D.tooltip&&(t=D.tooltip),D.content&&(y=D.content)),g=k.isFunction(k.uniqueSort)?k.uniqueSort(g):k.unique(g),m.push('<td class="'+g.join(" ")+'"'+(t?' title="'+t+'"':"")+' data-date="'+u.getTime().toString()+'">'+y+"</td>"),t=null,f===this.o.weekEnd&&m.push("</tr>"),u.setUTCDate(u.getUTCDate()+1)}this.picker.find(".datepicker-days tbody").html(m.join(""));var v,a=M[this.o.language].monthsTitle||M.en.monthsTitle||"Months",w=this.picker.find(".datepicker-months").find(".datepicker-switch").text(this.o.maxViewMode<2?a:i).end().find("tbody span").removeClass("active");k.each(this.dates,function(t,e){e.getUTCFullYear()===i&&w.eq(e.getUTCMonth()).addClass("active")}),(i<s||o<i)&&w.addClass("disabled"),i===s&&w.slice(0,n).addClass("disabled"),i===o&&w.slice(r+1).addClass("disabled"),this.o.beforeShowMonth!==k.noop&&(v=this,k.each(w,function(t,e){t=new Date(i,t,1),t=v.o.beforeShowMonth(t);t===b?t={}:"boolean"==typeof t?t={enabled:t}:"string"==typeof t&&(t={classes:t}),!1!==t.enabled||k(e).hasClass("disabled")||k(e).addClass("disabled"),t.classes&&k(e).addClass(t.classes),t.tooltip&&k(e).prop("title",t.tooltip)})),this._fill_yearsView(".datepicker-years","year",10,i,s,o,this.o.beforeShowYear),this._fill_yearsView(".datepicker-decades","decade",100,i,s,o,this.o.beforeShowDecade),this._fill_yearsView(".datepicker-centuries","century",1e3,i,s,o,this.o.beforeShowCentury)}},updateNavArrows:function(){if(this._allow_update){var t,e,i=new Date(this.viewDate),a=i.getUTCFullYear(),s=i.getUTCMonth(),n=this.o.startDate!==-1/0?this.o.startDate.getUTCFullYear():-1/0,o=this.o.startDate!==-1/0?this.o.startDate.getUTCMonth():-1/0,r=this.o.endDate!==1/0?this.o.endDate.getUTCFullYear():1/0,h=this.o.endDate!==1/0?this.o.endDate.getUTCMonth():1/0,l=1;switch(this.viewMode){case 4:l*=10;case 3:l*=10;case 2:l*=10;case 1:t=Math.floor(a/l)*l<=n,e=Math.floor(a/l)*l+l>r;break;case 0:t=a<=n&&s<=o,e=r<=a&&h<=s}this.picker.find(".prev").toggleClass("disabled",t),this.picker.find(".next").toggleClass("disabled",e)}},click:function(t){var e,i;t.preventDefault(),t.stopPropagation(),(t=k(t.target)).hasClass("datepicker-switch")&&this.viewMode!==this.o.maxViewMode&&this.setViewMode(this.viewMode+1),t.hasClass("today")&&!t.hasClass("day")&&(this.setViewMode(0),this._setDate(C(),"linked"===this.o.todayBtn?null:"view")),t.hasClass("clear")&&this.clearDates(),t.hasClass("disabled")||(t.hasClass("month")||t.hasClass("year")||t.hasClass("decade")||t.hasClass("century"))&&(this.viewDate.setUTCDate(1),1===this.viewMode?(i=t.parent().find("span").index(t),e=this.viewDate.getUTCFullYear(),this.viewDate.setUTCMonth(i)):(i=0,e=Number(t.text()),this.viewDate.setUTCFullYear(e)),this._trigger(U.viewModes[this.viewMode-1].e,this.viewDate),this.viewMode===this.o.minViewMode?this._setDate(_(e,i,1)):(this.setViewMode(this.viewMode-1),this.fill())),this.picker.is(":visible")&&this._focused_from&&this._focused_from.focus(),delete this._focused_from},dayCellClick:function(t){t=k(t.currentTarget).data("date"),t=new Date(t);this.o.updateViewDate&&(t.getUTCFullYear()!==this.viewDate.getUTCFullYear()&&this._trigger("changeYear",this.viewDate),t.getUTCMonth()!==this.viewDate.getUTCMonth()&&this._trigger("changeMonth",this.viewDate)),this._setDate(t)},navArrowsClick:function(t){t=k(t.currentTarget).hasClass("prev")?-1:1;0!==this.viewMode&&(t*=12*U.viewModes[this.viewMode].navStep),this.viewDate=this.moveMonth(this.viewDate,t),this._trigger(U.viewModes[this.viewMode].e,this.viewDate),this.fill()},_toggle_multidate:function(t){var e=this.dates.contains(t);if(t||this.dates.clear(),-1!==e?(!0===this.o.multidate||1<this.o.multidate||this.o.toggleActive)&&this.dates.remove(e):(!1===this.o.multidate&&this.dates.clear(),this.dates.push(t)),"number"==typeof this.o.multidate)for(;this.dates.length>this.o.multidate;)this.dates.remove(0)},_setDate:function(t,e){e&&"date"!==e||this._toggle_multidate(t&&new Date(t)),(!e&&this.o.updateViewDate||"view"===e)&&(this.viewDate=t&&new Date(t)),this.fill(),this.setValue(),e&&"view"===e||this._trigger("changeDate"),this.inputField.trigger("change"),!this.o.autoclose||e&&"date"!==e||this.hide()},moveDay:function(t,e){var i=new Date(t);return i.setUTCDate(t.getUTCDate()+e),i},moveWeek:function(t,e){return this.moveDay(t,7*e)},moveMonth:function(t,e){if(!(i=t)||isNaN(i.getTime()))return this.o.defaultViewDate;var i;if(!e)return t;var a,s,n=new Date(t.valueOf()),o=n.getUTCDate(),r=n.getUTCMonth(),h=Math.abs(e);if(e=0<e?1:-1,1===h)s=-1===e?function(){return n.getUTCMonth()===r}:function(){return n.getUTCMonth()!==a},a=r+e,n.setUTCMonth(a),a=(a+12)%12;else{for(var l=0;l<h;l++)n=this.moveMonth(n,e);a=n.getUTCMonth(),n.setUTCDate(o),s=function(){return a!==n.getUTCMonth()}}for(;s();)n.setUTCDate(--o),n.setUTCMonth(a);return n},moveYear:function(t,e){return this.moveMonth(t,12*e)},moveAvailableDate:function(t,e,i){do{if(t=this[i](t,e),!this.dateWithinRange(t))return!1}while(i="moveDay",this.dateIsDisabled(t));return t},weekOfDateIsDisabled:function(t){return-1!==k.inArray(t.getUTCDay(),this.o.daysOfWeekDisabled)},dateIsDisabled:function(e){return this.weekOfDateIsDisabled(e)||0<k.grep(this.o.datesDisabled,function(t){return n(e,t)}).length},dateWithinRange:function(t){return t>=this.o.startDate&&t<=this.o.endDate},keydown:function(t){if(this.picker.is(":visible")){var e,i,a=!1,s=this.focusDate||this.viewDate;switch(t.keyCode){case 27:this.focusDate?(this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill()):this.hide(),t.preventDefault(),t.stopPropagation();break;case 37:case 38:case 39:case 40:if(!this.o.keyboardNavigation||7===this.o.daysOfWeekDisabled.length)break;e=37===t.keyCode||38===t.keyCode?-1:1,0===this.viewMode?t.ctrlKey?(i=this.moveAvailableDate(s,e,"moveYear"))&&this._trigger("changeYear",this.viewDate):t.shiftKey?(i=this.moveAvailableDate(s,e,"moveMonth"))&&this._trigger("changeMonth",this.viewDate):37===t.keyCode||39===t.keyCode?i=this.moveAvailableDate(s,e,"moveDay"):this.weekOfDateIsDisabled(s)||(i=this.moveAvailableDate(s,e,"moveWeek")):1===this.viewMode?(38!==t.keyCode&&40!==t.keyCode||(e*=4),i=this.moveAvailableDate(s,e,"moveMonth")):2===this.viewMode&&(38!==t.keyCode&&40!==t.keyCode||(e*=4),i=this.moveAvailableDate(s,e,"moveYear")),i&&(this.focusDate=this.viewDate=i,this.setValue(),this.fill(),t.preventDefault());break;case 13:if(!this.o.forceParse)break;s=this.focusDate||this.dates.get(-1)||this.viewDate,this.o.keyboardNavigation&&(this._toggle_multidate(s),a=!0),this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.setValue(),this.fill(),this.picker.is(":visible")&&(t.preventDefault(),t.stopPropagation(),this.o.autoclose&&this.hide());break;case 9:this.focusDate=null,this.viewDate=this.dates.get(-1)||this.viewDate,this.fill(),this.hide()}a&&(this.dates.length?this._trigger("changeDate"):this._trigger("clearDate"),this.inputField.trigger("change"))}else 40!==t.keyCode&&27!==t.keyCode||(this.show(),t.stopPropagation())},setViewMode:function(t){this.viewMode=t,this.picker.children("div").hide().filter(".datepicker-"+U.viewModes[this.viewMode].clsName).show(),this.updateNavArrows(),this._trigger("changeViewMode",new Date(this.viewDate))}};function h(t,e){k.data(t,"datepicker",this),this.element=k(t),this.inputs=k.map(e.inputs,function(t){return t.jquery?t[0]:t}),delete e.inputs,this.keepEmptyValues=e.keepEmptyValues,delete e.keepEmptyValues,s.call(k(this.inputs),e).on("changeDate",k.proxy(this.dateUpdated,this)),this.pickers=k.map(this.inputs,function(t){return k.data(t,"datepicker")}),this.updateDates()}h.prototype={updateDates:function(){this.dates=k.map(this.pickers,function(t){return t.getUTCDate()}),this.updateRanges()},updateRanges:function(){var i=k.map(this.dates,function(t){return t.valueOf()});k.each(this.pickers,function(t,e){e.setRange(i)})},clearDates:function(){k.each(this.pickers,function(t,e){e.clearDates()})},dateUpdated:function(t){if(!this.updating){this.updating=!0;var i=k.data(t.target,"datepicker");if(i!==b){var a=i.getUTCDate(),s=this.keepEmptyValues,t=k.inArray(t.target,this.inputs),e=t-1,n=t+1,o=this.inputs.length;if(-1!==t){if(k.each(this.pickers,function(t,e){e.getUTCDate()||e!==i&&s||e.setUTCDate(a)}),a<this.dates[e])for(;0<=e&&a<this.dates[e];)this.pickers[e--].setUTCDate(a);else if(a>this.dates[n])for(;n<o&&a>this.dates[n];)this.pickers[n++].setUTCDate(a);this.updateDates(),delete this.updating}}}},destroy:function(){k.map(this.pickers,function(t){t.destroy()}),k(this.inputs).off("changeDate",this.dateUpdated),delete this.element.data().datepicker},remove:t("destroy","Method `remove` is deprecated and will be removed in version 2.0. Use `destroy` instead")};var a=k.fn.datepicker,s=function(n){var o,r=Array.apply(null,arguments);if(r.shift(),this.each(function(){var t,e,i=k(this),a=i.data("datepicker"),s="object"==typeof n&&n;a||(t=function(t,e){function i(t,e){return e.toLowerCase()}var a,s,n=k(t).data(),o={},r=new RegExp("^"+e.toLowerCase()+"([A-Z])");for(s in e=new RegExp("^"+e.toLowerCase()),n)e.test(s)&&(a=s.replace(r,i),o[a]=n[s]);return o}(this,"date"),e=function(t){var i={};if(M[t]||(t=t.split("-")[0],M[t])){var a=M[t];return k.each(d,function(t,e){e in a&&(i[e]=a[e])}),i}}(k.extend({},l,t,s).language),s=k.extend({},l,e,t,s),a=i.hasClass("input-daterange")||s.inputs?(k.extend(s,{inputs:s.inputs||i.find("input").toArray()}),new h(this,s)):new T(this,s),i.data("datepicker",a)),"string"==typeof n&&"function"==typeof a[n]&&(o=a[n].apply(a,r))}),o===b||o instanceof T||o instanceof h)return this;if(1<this.length)throw new Error("Using only allowed for the collection of a single element ("+n+" function)");return o};k.fn.datepicker=s;var l=k.fn.datepicker.defaults={assumeNearbyYear:!1,autoclose:!1,beforeShowDay:k.noop,beforeShowMonth:k.noop,beforeShowYear:k.noop,beforeShowDecade:k.noop,beforeShowCentury:k.noop,calendarWeeks:!1,clearBtn:!1,toggleActive:!1,daysOfWeekDisabled:[],daysOfWeekHighlighted:[],datesDisabled:[],endDate:1/0,forceParse:!0,format:"mm/dd/yyyy",keepEmptyValues:!1,keyboardNavigation:!0,language:"en",minViewMode:0,maxViewMode:4,multidate:!1,multidateSeparator:",",orientation:"auto",rtl:!1,startDate:-1/0,startView:0,todayBtn:!1,todayHighlight:!1,updateViewDate:!0,weekStart:0,disableTouchKeyboard:!1,enableOnReadonly:!0,showOnFocus:!0,zIndexOffset:10,container:"body",immediateUpdates:!1,title:"",templates:{leftArrow:"&#x00AB;",rightArrow:"&#x00BB;"},showWeekDays:!0},d=k.fn.datepicker.locale_opts=["format","rtl","weekStart"];k.fn.datepicker.Constructor=T;var M=k.fn.datepicker.dates={en:{days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],today:"Today",clear:"Clear",titleFormat:"MM yyyy"}},U={viewModes:[{names:["days","month"],clsName:"days",e:"changeMonth"},{names:["months","year"],clsName:"months",e:"changeYear",navStep:1},{names:["years","decade"],clsName:"years",e:"changeDecade",navStep:10},{names:["decades","century"],clsName:"decades",e:"changeCentury",navStep:100},{names:["centuries","millennium"],clsName:"centuries",e:"changeMillennium",navStep:1e3}],validParts:/dd?|DD?|mm?|MM?|yy(?:yy)?/g,nonpunctuation:/[^ -\/:-@\u5e74\u6708\u65e5\[-`{-~\t\n\r]+/g,parseFormat:function(t){if("function"==typeof t.toValue&&"function"==typeof t.toDisplay)return t;var e=t.replace(this.validParts,"\0").split("\0"),t=t.match(this.validParts);if(!e||!e.length||!t||0===t.length)throw new Error("Invalid date format.");return{separators:e,parts:t}},parseDate:function(t,e,i,a){function s(){var t=this.slice(0,u[v].length),e=u[v].slice(0,t.length);return t.toLowerCase()===e.toLowerCase()}if(!t)return b;if(t instanceof Date)return t;if((e="string"==typeof e?U.parseFormat(e):e).toValue)return e.toValue(t,e,i);var n,o,r,h={d:"moveDay",m:"moveMonth",w:"moveWeek",y:"moveYear"},l={yesterday:"-1d",today:"+0d",tomorrow:"+1d"};if(/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/i.test(t=t in l?l[t]:t)){for(u=t.match(/([\-+]\d+)([dmwy])/gi),t=new Date,v=0;v<u.length;v++)n=u[v].match(/([\-+]\d+)([dmwy])/i),o=Number(n[1]),r=h[n[2].toLowerCase()],t=T.prototype[r](t,o);return T.prototype._zero_utc_time(t)}var d,c,u=t&&t.match(this.nonpunctuation)||[],p={},f=["yyyy","yy","M","MM","m","mm","d","dd"],g={yyyy:function(t,e){return t.setUTCFullYear(a?(!0===(i=a)&&(i=10),(t=e)<100&&(t+=2e3)>(new Date).getFullYear()+i&&(t-=100),t):e);var i},m:function(t,e){if(isNaN(t))return t;for(--e;e<0;)e+=12;for(t.setUTCMonth(e%=12);t.getUTCMonth()!==e;)t.setUTCDate(t.getUTCDate()-1);return t},d:function(t,e){return t.setUTCDate(e)}};g.yy=g.yyyy,g.M=g.MM=g.mm=g.m,g.dd=g.d,t=C();var D=e.parts.slice();if(u.length!==D.length&&(D=k(D).filter(function(t,e){return-1!==k.inArray(e,f)}).toArray()),u.length===D.length){for(var m,y,v=0,w=D.length;v<w;v++){if(d=parseInt(u[v],10),n=D[v],isNaN(d))switch(n){case"MM":c=k(M[i].months).filter(s),d=k.inArray(c[0],M[i].months)+1;break;case"M":c=k(M[i].monthsShort).filter(s),d=k.inArray(c[0],M[i].monthsShort)+1}p[n]=d}for(v=0;v<f.length;v++)(y=f[v])in p&&!isNaN(p[y])&&(m=new Date(t),g[y](m,p[y]),isNaN(m)||(t=m))}return t},formatDate:function(t,e,i){if(!t)return"";if((e="string"==typeof e?U.parseFormat(e):e).toDisplay)return e.toDisplay(t,e,i);var a={d:t.getUTCDate(),D:M[i].daysShort[t.getUTCDay()],DD:M[i].days[t.getUTCDay()],m:t.getUTCMonth()+1,M:M[i].monthsShort[t.getUTCMonth()],MM:M[i].months[t.getUTCMonth()],yy:t.getUTCFullYear().toString().substring(2),yyyy:t.getUTCFullYear()};a.dd=(a.d<10?"0":"")+a.d,a.mm=(a.m<10?"0":"")+a.m,t=[];for(var s=k.extend([],e.separators),n=0,o=e.parts.length;n<=o;n++)s.length&&t.push(s.shift()),t.push(a[e.parts[n]]);return t.join("")},headTemplate:'<thead><tr><th colspan="7" class="datepicker-title"></th></tr><tr><th class="prev">'+l.templates.leftArrow+'</th><th colspan="5" class="datepicker-switch"></th><th class="next">'+l.templates.rightArrow+"</th></tr></thead>",contTemplate:'<tbody><tr><td colspan="7"></td></tr></tbody>',footTemplate:'<tfoot><tr><th colspan="7" class="today"></th></tr><tr><th colspan="7" class="clear"></th></tr></tfoot>'};U.template='<div class="datepicker"><div class="datepicker-days"><table class="table-condensed">'+U.headTemplate+"<tbody></tbody>"+U.footTemplate+'</table></div><div class="datepicker-months"><table class="table-condensed">'+U.headTemplate+U.contTemplate+U.footTemplate+'</table></div><div class="datepicker-years"><table class="table-condensed">'+U.headTemplate+U.contTemplate+U.footTemplate+'</table></div><div class="datepicker-decades"><table class="table-condensed">'+U.headTemplate+U.contTemplate+U.footTemplate+'</table></div><div class="datepicker-centuries"><table class="table-condensed">'+U.headTemplate+U.contTemplate+U.footTemplate+"</table></div></div>",k.fn.datepicker.DPGlobal=U,k.fn.datepicker.noConflict=function(){return k.fn.datepicker=a,this},k.fn.datepicker.version="1.9.0",k.fn.datepicker.deprecated=function(t){var e=window.console;e&&e.warn&&e.warn("DEPRECATED: "+t)},k(document).on("focus.datepicker.data-api click.datepicker.data-api",'[data-provide="datepicker"]',function(t){var e=k(this);e.data("datepicker")||(t.preventDefault(),s.call(e,"show"))}),k(function(){s.call(k('[data-provide="datepicker-inline"]'))})});