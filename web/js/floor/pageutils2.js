var Dialog = {
	show: function(option) {
		var config = {};
		$.extend(config, {
			title: 'Noname',
			message: 'blablabla~~~',
			fromElement: null,
			listener: function(button) {},
			buttons: ['OK', 'Cancel']
		}, option);

		var sb = [];
		sb.push('<div class="titlebar">' + config.title + '</div>');
		sb.push('<div class="message">' + config.message + '</div>');

		sb.push('<div class="buttonbar">');
		var i = config.buttons.length - 1;
		for (; i >= 0; i--) {
			sb.push('<div class="cssbutton" value="' + config.buttons[i].toLowerCase() + '" i18n="i18n">' + config.buttons[i] + '</div>');
		}

		sb.push('<div class="clearboth"></div></div>');
		$('body').popupWindow({
			html: '<div class="dialog">' + sb.join('') + '</div>',
			fromElement: config.fromElement,
			beforeshow: function() {
				$('.cssbutton', this).click($.proxy(function(event) {
					config.listener($(event.currentTarget).attr('value'));
					this.animate({
						opacity: 0
					}, 200, $.proxy(function() {
						this.remove();
					}, this));
				}, this));
			}
		});
	}
};

var UI = {
	scroll: function(el, option) {
		if (typeof(iScroll) === 'function') {
			return new iScroll(el, option);
		}
		return {
			refresh: function() {},
			enable: function() {},
			disable: function() {}
		};
	},
	showLoadingMask: function(applyElement) {
		var lMask = null;
		if ((lMask = $('#rpc_loading', applyElement)).length == 0) {
			lMask = $('<div id="rpc_loading" class="loading" ref="1" style="display:block;"><div></div><div></div></div>').appendTo(applyElement);
		} else {
			lMask.attr('ref', parseInt(lMask.attr('ref'), 10) + 1);
		}
	},
	dismissLoadingMask: function(applyElement) {
		var lMask = null;
		if ((lMask = $('#rpc_loading', applyElement)).length > 0) {
			var ref = parseInt(lMask.attr('ref'), 10) - 1;
			lMask.attr('ref', ref);
			if (ref == 0) {
				lMask.remove();
			}
		}
	},
	showImageUploader: function(el, imageType, callback, selectedUrl) {
		el = $(el);

		var height;
		var origin = Cookie.get('origin');
		if (origin == 'restaurantbutler') {
			if (imageType == 'users') {
				var sb = ['<div class="imageuploader">',
					'<div class="uploader">', '<a class="cssbutton pnmUploadImage" style="width:95%; text-decoration:none;" href="?pnm=uploadImage&type=' + imageType + '">Take photo or upload</a>',
					'</div>',
					'<hr/>',
					'<div class="images"><div></div></div>',
					'<div class="buttonbar"><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="clearboth"></div></div>',
					'</div>'
				];
			} else {
				var sb = ['<div class="imageuploader">',
					'<div class="uploader" style="padding-left:5px;">', 'upload disabled on iPAD, please open the manager with a computer.',
					'</div>',
					'<hr/>',
					'<div class="images"><div></div></div>',
					'<div class="buttonbar"><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="clearboth"></div></div>',
					'</div>'
				];
			}
		} else {
			var sb = ['<div class="imageuploader">',
				'<div class="uploader">', '<div class="label" i18n="i18n">Add Image</div><a class="lnkaddimage" href="javascript:void(0);" i18n="i18n">Choose a file</a><div class="cssbutton" value="upload">Upload</div>',
				'<input type="file" id="datafile" name="datafile" style="display:none;position:relative;top:3px;border:0 none transparent;"/>',
				'</div>',
				'<hr/>',
				'<div class="images"><div></div></div>',
				'<div class="buttonbar"><div class="cssbutton" value="cancel" i18n="i18n">Cancel</div><div class="clearboth"></div></div>',
				'</div>'
			];
		}

		var imageUploader = localize($(sb.join('')))
			.width(el.innerWidth())
			.height(height = el.innerHeight())
			.css({
				top: height
			})
			.appendTo(el);

		if (BrowserDetect.OS === 'Windows' && BrowserDetect.browser === 'Explorer' || BrowserDetect.browser === 'Safari') {
			$('#datafile', imageUploader).show();
			$('.lnkaddimage', imageUploader).hide();
		}

		imageUploader.animate({
			top: 0
		}, 150);

		if (BrowserDetect.OS === 'iOS' && BrowserDetect.browser === 'Safari' && origin != 'restaurantbutler') {
			$('.uploader,hr', imageUploader).hide();
			$('.images', imageUploader).css({
				top: 0
			});
		}


		var refreshImages = function() {
			rpc({
				method: 'getImages',
				prefix: 'manager',
				params: [imageType],
				applyElement: imageUploader,
				success: function(json) {
					var imageContainer, clickSuspend;
					$($(json).map(function(i, e) {
						return '<img src="'+ e.imageLocationMin + '" alt="' + e.name + '" class="' + (selectedUrl === e.imageLocation ? 'selected' : '') + '" />'
					}).get().join(''))
						.appendTo(imageContainer = $('.images>div', imageUploader).empty())
						.bind(bindEvent, function(event) {
							if (clickSuspend != true) {
								imageUploader.animate({
									top: height
								}, 150, function() {
									imageUploader.remove();
								});

								var imageUrl = $(event.currentTarget).attr('src').replace(scalingUrl, "");
								if (imageUrl == selectedUrl) {
									imageUrl = null;
								}

								Function.invoke(callback, imageUrl);
							}
						});

					UI.scroll(imageContainer.append('<div class="clearboth"></div>').parent()[0], {
						onBeforeScrollMove: function() {
							clickSuspend = true;
						},
						onTouchEnd: function() {
							window.setTimeout(function() {
								clickSuspend = false;
							}, 60)
						}
					});
				}
			});
		};

		$('.lnkaddimage', imageUploader).click(function() {
			$('input[type=file]', imageUploader).click();
		});


		$('input[type=file]', imageUploader).change(function(event) {
			$('.lnkaddimage', imageUploader).text(event.currentTarget.value);
		});

		$('.cssbutton[value=upload]', imageUploader).click(function(event) {
			UI.showLoadingMask(imageUploader);
			$.ajaxFileUpload({
				url: configuration.serviceUrl + '/UploadServlet',
				data: {
					method: 'addImage',
					token: Cookie.get('apitoken'),
					type: imageType
				},
				secureuri: false,
				fileElementId: 'datafile',
				dataType: 'json',
				success: function(data, status) {
					refreshImages();
					UI.dismissLoadingMask(imageUploader);
				},
				error: function(data, status, e) {
					UI.dismissLoadingMask(imageUploader);
					Dialog.show({
						title: localizeText('Error'),
						message: localizeText('Upload failed ! only jpg, png, gif allowed and image can not be bigger than 500kb')
					});
				}
			});
		});

		$('.cssbutton[value=cancel]', imageUploader).click(function(event) {
			imageUploader.animate({
				top: height
			}, 150, function() {
				imageUploader.remove();
			});
		});

		refreshImages();
	},
	loadImage: function(callback) {
		var thatArgument = arguments;
		var imagesCount = 0,
			imagesArray = [],
			image, i;

		for (i = 1; i < arguments.length; i++) {
			if (arguments[i] === '' || arguments[i] === null) {
				imagesArray.push(null);
				continue;
			}

			image = new Image();
			$(image).load(function() {
				if (--imagesCount <= 0) {
					if (callback !== undefined && typeof(callback) === 'function') {
						callback.apply(null, imagesArray);
					}
				}
			});
			imagesArray.push(image);
			imagesCount++;
		}

		for (i = 0; i < imagesArray.length; i++) {
			if (imagesArray[i] !== null) {
				imagesArray[i].src = arguments[i + 1];
			}
		};
	},
	UISwitch: function(options) {
		this.init(options);
	}
};

UI.UISwitch.prototype = {
	init: function(options) {
		this.config = {};
		$.extend(this.config, {}, options);

		this.el = this.config.el.addClass("ui_switch")
			.append('<div class="f"></div><div class="b"></div>')
			.click($.proxy(function(event) {
				var thisMe;
				if ((uiswitch = $(event.currentTarget)).attr("isOn") == "0") {
					$("div.f", event.currentTarget).animate({
						left: 0
					}, 200, "linear", $.proxy(function() {
						uiswitch.attr("isOn", "1");
						this.invokeCallback();
					}, this));
				} else {
					$("div.f", event.currentTarget).animate({
						left: -51
					}, 200, "linear", $.proxy(function() {
						uiswitch.attr("isOn", "0");
						this.invokeCallback();
					}, this));
				}
			}, this));

		if (this.config.on == true) {
			$("div.f", this.el).css({
				left: 0
			});
			this.el.attr("isOn", "1");
		} else {
			$("div.f", this.el).css({
				left: -51
			});
			this.el.attr("isOn", "0");
		}
	},
	invokeCallback: function() {
		if (this.config.change != null && typeof(this.config.change) == 'function') {
			this.config.change(this);
		}
	},
	isOn: function() {
		return this.el.attr("isOn") != "0";
	}
};

var DataBinding = {
	takeControl: function(element) {
		var controlEvents = {
			"hex": function(inputElement) {
				$(inputElement).keydown(function(event) {
					var el = $(event.currentTarget),
						cvalue = el.val(),
						nvalue;
					var k = event.which;

				});
			},
			"float": function(inputElement) {
				$(inputElement).keydown(function(event) {
					var el = $(event.currentTarget),
						cvalue = el.val(),
						nvalue;
					var k = event.which;

					//	if(event.altKey||event.shiftKey||event.ctrlKey||event.metaKey){
					if (event.altKey || event.ctrlKey || event.metaKey) {
						event.preventDefault();
						return;
					}

					if ((k >= 48 && k <= 57) || (k >= 96 && k <= 105) || k == 190 || k == 110 || k == 109 || k == 59) {

						var k2 = k;
						if (k >= 96 && k <= 105) {
							k2 = k - 48;
						}

						nvalue = cvalue.slice(0, el.getCaretPosition()) + (k2 == 190 || k2 == 110 || k2 == 59 ? '.' : (k2 == 109 ? '-' : String.fromCharCode(k2))) + cvalue.slice(el.getCaretPosition());
						if (parseFloat(nvalue) === Number.NaN || !/^-?\d+(\.\d*)?$/.test(nvalue)) {
							event.preventDefault();
						}
					} else if (k == 189 || k == 8 || k == 46 || k == 37 || k == 39 || k == 9 || (k >= 35 && k <= 40)) {

					} else {
						event.preventDefault();
					}
				});
			},
			"integer": function(inputElement) {
				$(inputElement).keydown(function(event) {
					var el = $(event.currentTarget),
						cvalue = el.val(),
						nvalue;
					var k = event.which;
					if (!((k >= 48 && k <= 57) || (k >= 96 && k <= 105) || k == 109 || k == 8 || k == 46 || k == 37 || k == 39 || k == 9 || (k >= 35 && k <= 40))) {
						event.preventDefault();
					} else if (k == 8 || k == 46 || k == 37 || k == 39 || k == 9 || (k >= 35 && k <= 40)) {

					} else {
						nvalue = cvalue.slice(0, el.getCaretPosition()) + (k == 109 ? '-' : String.fromCharCode(k)) + cvalue.slice(el.getCaretPosition());

						if (parseInt(nvalue, 10) == Number.NaN || !/^-?\d+$/.test(parseInt(nvalue, 10))) {
							event.preventDefault();
						}
					}
				});
			}
		};

		$('input', element).each(function(i, e) {
			var dt = $(e).attr('datatype');
			if (dt != null && controlEvents.hasOwnProperty(dt)) {
				controlEvents[dt](e);
			}
		});
	},
	visualize: function(element, data) {
		$('input,textarea', element).each(function(i, e) {
			var dataValue;
			var formEl = $(e);
			if (data.hasOwnProperty(e.name) && (dataValue = data[e.name]) != null) {
				switch (formEl.attr('type')) {
					case 'checkbox':
						formEl.attr('checked', dataValue);
						break;
					case 'textarea':
						formEl.empty().text(dataValue);
						break;
					default:
						formEl.val(dataValue);
						break;
				}
			}
		});

		DataBinding.takeControl(element);
	},
	datalize: function(element, data, customizedValidators) {
		var dataParsers = {
			integer: function(str) {
				if (str === '') {
					return 0;
				}
				return parseInt(str, 10);
			}
		};

		var hasError = false;
		customizedValidators = customizedValidators || {};
		$('select,input,textarea', element).each(function(i, e) {
			var formEl = $(e),
				strVal;
			var dt = formEl.attr('datatype');
			if (data.hasOwnProperty(e.name)) {
				switch (formEl.attr('type')) {
					case 'checkbox':
						strVal = e.checked;
						break;
					case 'textarea':
						strVal = e.text();
						break;
					default:
						strVal = formEl.val();
						break;
				}

				data[formEl.attr('name')] = (dt != null && dataParsers.hasOwnProperty(dt)) ? dataParsers[dt](strVal) : strVal;
			}

			$((formEl.attr('validators') || '').split(',')).each(function(vIndex, vName) {
				var validator;
				if (customizedValidators.hasOwnProperty(vName)) {
					validator = customizedValidators[vName];
				} else if (DataBinding.validators.hasOwnProperty(vName)) {
					validator = DataBinding.validators[vName];
				}

				if (validator !== undefined) {
					validator($(e));
				}
			});
		});
	},
	validators: {
		NotNullable: function(el) {
			if (el.attr('type') === 'text' && el.val() === '') {
				return 701;
			}
			return 0;
		}
	}
};

function localize(context) {
	context = context || $('body');
	$('*[i18n=i18n]', context).each(function(i, e) {
		var el = $(e);
		var k = el.text();
		/*
		if(!i18n.hasOwnProperty(k)){
			console.log('"'+k+'":"'+'",');
		}
		*/
		el.text(i18n[k] || k);
	});
	return context;
}

function localizeText(key) {
	/*
	if(!i18n.hasOwnProperty(key)){
		console.log('"'+key+'":"'+'",');
	}
	*/
	var text = i18n[key] || key;
	for (var i = 1; i < arguments.length; i++) {
		text = text.replace('{' + (i - 1) + '}', arguments[i]);
	}
	return text;
}


//BEGINNING
var bindEvent;
var i18n = {};
var PageUI = {
	ready: function(startup) {
		$(document).ready(function() {

			var ua = navigator.userAgent;
			bindEvent = (ua.match(/iPad/i)) ? "touchend" : "click";

			var durl = document.URL;

			var l = document.createElement("a");
			l.href = durl;

			var port = l.port;
			var host = l.protocol + "//" + l.hostname;

			if (configuration.useUrlHost) {
				var separator = ":";
				if (port == "") {
					separator = "";
				}
				configuration.apiUrl = host + separator + port + configuration.jsonExtension;
				//configuration.serviceUrl = host+separator+port+configuration.extension;
				configuration.imgUrl = host + separator + port;
			} else {
				if (configuration.localDebug != undefined && !configuration.localDebug) {
					configuration.apiUrl = configuration.apiUrl.replace("8080", port);
					//configuration.serviceUrl = configuration.serviceUrl.replace("8080", port);
					configuration.imgUrl = configuration.imgUrl.replace("8080", port);
				}
			}

			console.log(configuration.apiUrl + " " + configuration.serviceUrl + " " + configuration.imgUrl);

			//locale code
			if (window.location.urlVars['rblang'] != undefined && window.location.urlVars['rblang'] != null) {
				if (Cookie.get('locale') == null) {
					var rbl = window.location.urlVars['rblang'].toLowerCase();
					if (rbl == 'fr') {
						rbl = 'fr_be';
					}
					if (rbl == 'nl') {
						rbl = 'nl_be';
					}
					if (rbl == 'cn') {
						rbl = 'zh_cn';
					}
					Cookie.create('locale', rbl);
				}
			}
			if (window.location.urlVars['locale'] != undefined && window.location.urlVars['locale'] != null) {
				Cookie.create('locale', window.location.urlVars['locale']);
			}
			//end locale code



			//switchAccount
			enableSelectBoxes();

			if (window.location.urlVars['redirect'] != null) {
				Cookie.create('origin', 'website');
				console.log('2');

			}


			//css for layout
			if (BrowserDetect != null) {
				BrowserDetect.init();
				if (BrowserDetect.browser === 'Chrome') {
					$('.maintab ul').css('background', $('.maintab ul').css('background'));
				}
			}

			var startupWrapper = function() {
				localize();

				$('#sidebar .expander').click(function(event) {
					var collapsed = $(event.currentTarget).attr('collapsed');
					$('#sidebar').animate({
						width: collapsed === 'true' ? 215 : 0
					}, {
						duration: 200,
						step: function() {
							$('#board').css({
								left: $(this).width()
							});
						},
						complete: function() {
							$('#board').css({
								left: $(this).width()
							});
							$('#elementscontainer').toggle();
							$('#sidebar .expander').css({
								backgroundPosition: 'center ' + (collapsed === 'true' ? 'right' : 'left')
							}).attr('collapsed', collapsed === 'false');
						}
					});
				});

				if (Cookie.get('origin') == 'restaurantbutler') {
					$('#lkLogout').text('Close window');
				}


				if (BrowserDetect != null && BrowserDetect.OS === 'iOS' && BrowserDetect.browser === 'Safari') {
					loadScript('js/iscroll.js', function() {
						document.addEventListener('touchmove', function(e) {
							if (e.target.tagName != 'SELECT') {
								e.preventDefault();
							}
						});
						startup();
					});
				} else {
					startup();
				}
			};

			if (Cookie.get('locale') != null) {
				$.ajax({
					url: 'js/locale/' + Cookie.get('locale') + '.js',
					dataType: 'json',
					success: function(json) {
						i18n = json;
						startupWrapper();
					},
					error: function() {
						i18n = {};
						startupWrapper();
					}
				});
			} else {
				startupWrapper();
			}



		});
	},
	memoryStorage: {}
};

function uploadImageCallback() {
	UI.refreshImages();
}

function roundToDay(date) {
	return new Date(new Date(new Date(date.setHours(0)).setMinutes(0)).setSeconds(0));
}

function setAccountText() {
	var ed = Cookie.get('lastAccountCheck');
	if (ed != null) {
		if (ed > (new Date().getTime() - 43400000)) {
			var text = Cookie.get('accountText');

			$('#email').html(text);

			return;
		}
	}
	rpc({
		method: 'getAccount',
		prefix: 'manager',
		success: function(json) {
			Cookie.create('lastAccountCheck', new Date().getTime());

			if (json.type == 'subscription')
				$('#email').text(Cookie.get('email') + " " + localizeText("(subscribed)"));

			if (json.type == 'freeAccount') {
				var timenow = new Date().getTime();

				var totalremaining = json.expirationDate - timenow;

				var numberOfRemainingDays = 0;
				numberOfRemainingDays = totalremaining / 86400000;
				numberOfRemainingDays = Math.round(numberOfRemainingDays);
				if (numberOfRemainingDays < 0)
					numberOfRemainingDays = 0;

				if (numberOfRemainingDays > 0)
					$('#email').html(Cookie.get('email') + " ( <font color='#ffffff'>" + localizeText("Trial") + ' ' + numberOfRemainingDays + " " + localizeText("remaining days, upgrade now") + "</font> )");
				else
					$('#email').html(Cookie.get('email') + " ( <font color='#E64040' i18n='i18n'>Your account has expired, upgrade now</font> )");
			}


			Cookie.create('accountText', $('#email').html());
		}
	});

}



function enableSelectBoxes() {

	var options = [];
	options.push('<a><span i18n="i18n">Restaurant </span><span id="company" i18n="i18n"></span></a>');
	$(".restaurant").html(options.join(''));

}