var rpc = function(option) {
	var config = {};
	$.extend(config, {
		method: 'getVersion',
		prefix: 'posios',
		params: [],
		success: function(json) {},
		error: function(httpcode, error) {

		},
		applyElement: null,
		progress: true
	}, option);

	var lMask = null;
	if (config.applyElement != null) {
		if ((lMask = $('#rpc_loading', config.applyElement)).length == 0) {
			lMask = $('<div id="rpc_loading" class="loading ' + (config.progress == false ? 'transparent' : '') + '" ref="1" style="display:block;"><div></div><div></div></div>').appendTo(config.applyElement);
		} else {
			lMask.attr('ref', parseInt(lMask.attr('ref'), 10) + 1);
		}
	}

	var dismissLoadingMask = function() {
		if (lMask != null) {
			var ref = parseInt(lMask.attr('ref'), 10) - 1;
			lMask.attr('ref', ref);
			if (ref == 0) {
				lMask.remove();
			}
		}
	};

	var invokeMethod = $.proxy(function() {
		$.ajax({
			url: configuration.apiUrl,
			dataType: 'json',
			type: 'POST',
			processData: false,
			contentType: 'text/plain; charset=UTF-8',
			data: JSON.stringify({
				'id': 0,
				'method': config.prefix + '.' + config.method,
				'params': config.params
			}),
			success: $.proxy(function(data, textStatus, jqXHR) {
				if (data.hasOwnProperty('error')) {
					config.error(jqXHR.status, data.error);
				} else {
					config.success(data.result);
				}
				dismissLoadingMask();
			}, this),
			error: function(jqXHR, textStatus, errorThrown) {
				//alert("error occured");
				if (jqXHR.readyState == 4) {
					var errorData;
					try {
						errorData = JSON.parse(jqXHR.responseText).error;
					} catch (e) {
						errorData = {};
					}
					config.error(jqXHR.status, errorData);
				}
				dismissLoadingMask();
			}
		});
	}, this);

	var freeToken = ["getToken", "getVersion", "getTokenFromCompany", "resetPassword"];
	var isTokenFree = false;
	$(freeToken).each(function(i, e) {
		if (e == config.method) {
			isTokenFree = true;
			return false;
		}
	});


	invokeMethod();

};