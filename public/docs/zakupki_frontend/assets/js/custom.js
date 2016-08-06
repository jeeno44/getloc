$(document).ready(function () {
	$(".select2-okved").select2({
		allowClear: true
	});
	$(".select2-okpd").select2({
		allowClear: true
	});
	$(".select2-units").select2({
	});

	$('#date-range').datepicker({autoclose: true, todayHighlight: true, format: "dd.mm.yyyy г."});

});

(function (namespace, $) {
	"use strict";
	var Demo = function () {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function () {
			o.initialize();
		});

	};
	var p = Demo.prototype;
	p.initialize = function () {
		this._enableEvents();
	};
	p._enableEvents = function () {
		var o = this;
		$('.card-head .btn-collapse').on('click', function (e) {
			console.log('1111');
			o._handleCardCollapse(e);
		});
	};
	p._handleCardCollapse = function (e) {
		var card = $(e.currentTarget).closest('.card');
		materialadmin.AppCard.toggleCardCollapse(card);
	};
	namespace.Demo = new Demo;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):