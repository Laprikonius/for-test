function scrollToFunc(objectThis) {
	var point = objectThis.attr('href');
	var top = $(point).offset().top;
	$('body, html').animate({
		scrollTop: top
	},800);
}

$(document).ready(function() {
	$('.popup-youtube').magnificPopup({
		type: 'iframe',
		mainClass: 'mfp-fade',
		preloader: true,
	});

	$(this).on('click', '.burger-menu', function () {
		$(this).toggleClass('show');
		$('.nav-mobile').toggleClass('show');
		$('body').toggleClass('menu-open');
	})
	.on('click', '.look-map', function(event) {
		event.preventDefault();
		scrollToFunc($(this));
	});

	$('.slider__main').slick({
		arrows: false,
		fade: true,
		asNavFor: '.slider__dot'
	});

	$('.slider__dot').slick({
		slidesToShow: 5,
		arrows: false,
		focusOnSelect: true,
		asNavFor: '.slider__main'
	});

	$("body").on("submit", ".callback-form--container form" , function(e) {
		e.preventDefault();
		var dataForm = $(this).serialize() + "&web_form_submit=Y";
		$.ajax({
			url: "/ajax/callback.php",
			method: "POST",
			dataType: "html",
			data: dataForm,
			success: function(dataForm) {
				console.log(dataForm);
				$(".callback-form--container").empty();
				$(".callback-form--container").append(dataForm);
			},
		});
	});

	$(document).on("click", ".button--callback-news-popup", function(e) {
		e.preventDefault();
		$(".callback-modal-container").stop().fadeIn(400);
		var titleText = $(this).data("titlename");
		$(".callback-modal-container form textarea").val(titleText);
	});
	/**/
	$("body").on("submit", ".callback-form form" , function(e) {
		e.preventDefault();
		var dataFormWFile = new FormData($(this)[0]);
		dataFormWFile.append("web_form_submit", "Y");
		//console.log($(this)[0]);
		$.ajax({
			url: "/include/ajax/callback_w_file.php",
			method: "POST",
			dataType: "html",
			processData: false,
			contentType: false,
			data: dataFormWFile,
			success: function(dataFormWFile) {
				$(".callback-form").empty();
				$(".callback-form").append(dataFormWFile);
			},
		});
	});
	/**/
	$(document).on("click", ".callback-close", function(e) {
		e.preventDefault();
		$(".callback-modal-container").stop().fadeOut(400);
	});
	$(document).on("click", ".callback-bg", function(e) {
		e.preventDefault();
		$(".callback-modal-container").stop().fadeOut(400);
	});
});

// ymaps.ready(initMap);

// function initMap() {
//     var myMap = new ymaps.Map('map', {
//             center: [],
//             zoom: null,
//             controls: []
//         }),

//         MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
//             '<div class="balloon">' +
//             '<a class="close" href="#">&times;</a>' +
//             '<div class="arrow"></div>' +
//             '<div class="balloon__inner">' +
//             '$[[options.contentLayout observeSize minWidth=295 maxWidth=295]]' +
//             '</div>' +
//             '</div>', {
//                 /**
//                  * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
//                  * @function
//                  * @name build
//                  */
//                 build: function () {
//                     this.constructor.superclass.build.call(this);

//                     this._$element = $('.balloon', this.getParentElement());

//                     this.applyElementOffset();

//                     this._$element.find('.close')
//                         .on('click', $.proxy(this.onCloseClick, this));
//                 },

//                 /**
//                  * Удаляет содержимое макета из DOM.
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
//                  * @function
//                  * @name clear
//                  */
//                 clear: function () {
//                     this._$element.find('.close')
//                         .off('click');

//                     this.constructor.superclass.clear.call(this);
//                 },

//                 /**
//                  * Метод будет вызван системой шаблонов АПИ при изменении размеров вложенного макета.
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
//                  * @function
//                  * @name onSublayoutSizeChange
//                  */
//                 onSublayoutSizeChange: function () {
//                     MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

//                     if(!this._isElement(this._$element)) {
//                         return;
//                     }

//                     this.applyElementOffset();

//                     this.events.fire('shapechange');
//                 },

//                 /**
//                  * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
//                  * @function
//                  * @name applyElementOffset
//                  */
//                 applyElementOffset: function () {
//                     this._$element.css({
//                         left: -(this._$element[0].offsetWidth / 2),
//                         top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
//                     });
//                 },

//                 /**
//                  * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
//                  * @function
//                  * @name onCloseClick
//                  */
//                 onCloseClick: function (e) {
//                     e.preventDefault();

//                     this.events.fire('userclose');
//                 },

//                 /**
//                  * Используется для автопозиционирования (balloonAutoPan).
//                  * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/ILayout.xml#getClientBounds
//                  * @function
//                  * @name getClientBounds
//                  * @returns {Number[][]} Координаты левого верхнего и правого нижнего углов шаблона относительно точки привязки.
//                  */
//                 getShape: function () {
//                     if(!this._isElement(this._$element)) {
//                         return MyBalloonLayout.superclass.getShape.call(this);
//                     }

//                     var position = this._$element.position();

//                     return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
//                         [position.left, position.top], [
//                             position.left + this._$element[0].offsetWidth,
//                             position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
//                         ]
//                     ]));
//                 },

//                 /**
//                  * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
//                  * @function
//                  * @private
//                  * @name _isElement
//                  * @param {jQuery} [element] Элемент.
//                  * @returns {Boolean} Флаг наличия.
//                  */
//                 _isElement: function (element) {
//                     return element && element[0] && element.find('.arrow')[0];
//                 }
//             }),

//         MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
//             '<h3 class="balloon__title">$[properties.balloonHeader]</h3>' +
//             '<div class="balloon__content">$[properties.balloonContent]</div>'
//         ),

//         myPlacemarkOffice = new ymaps.Placemark([55.75186416220157,37.66260508496096], {
//             balloonHeader: 'Офис продаж',
//             balloonContent: '8 495 812-46-46, Реутов, ул. Машиностроителей, д. 19/2'
//         }, {
//             // Опции.
//             balloonLayout: MyBalloonLayout,
//             balloonContentLayout: MyBalloonContentLayout,
//             balloonPanelMaxMapArea: 0,
//             balloonOffset: [250, 0],
//             iconLayout: 'default#imageWithContent',
//             iconImageHref: '/include/img/baloon-2.svg',
//             iconImageSize: [60, 80],
//             iconImageOffset: [-50, -104],
//             iconContentOffset: [15, 15],
//             hideIconOnBalloonOpen: false,
//         }),

//         myPlacemarkBuild = new ymaps.Placemark([55.646485300704335,37.84284953076173], {
//             balloonHeader: 'Комплекс',
//             balloonContent: 'г. Котельники, микрорайон «Южный», ул. Угрешская, напротив дома №6.'
//         }, {
//             // Опции.
//             balloonLayout: MyBalloonLayout,
//             balloonContentLayout: MyBalloonContentLayout,
//             balloonPanelMaxMapArea: 0,
//             balloonOffset: [250, 0],
//             iconLayout: 'default#imageWithContent',
//             iconImageHref: '/include/img/baloon-1.svg',
//             iconImageSize: [60, 80],
//             iconImageOffset: [-50, -104],
//             iconContentOffset: [15, 15],
//             hideIconOnBalloonOpen: false,
//         });

//     myMap.behaviors.disable('scrollZoom');
//     myMap.controls.add('zoomControl');

//     myMap.geoObjects
//         .add(myPlacemarkOffice)
//         .add(myPlacemarkBuild);
//     myMap.setBounds(myMap.geoObjects.getBounds());
//     myMap.setZoom(myMap.getZoom() - 1);

// }