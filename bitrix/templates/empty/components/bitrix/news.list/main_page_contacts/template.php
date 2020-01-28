<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div class="block-map d-none d-xl-block" id="block-map">
	<div class="container d-xl-flex justify-content-between d-md-block">
		<div class="block-map__places col-md-12 col-xl-3">

			<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

			//var_dump($arItem["DISPLAY_PROPERTIES"]["CONTACTS_MAP"]["VALUE"]["SRC"]["DISPLAY_PROPERTIES"]);
			?>

			  <div class="block-map__buid" data-coordinates="<?=$arItem["DISPLAY_PROPERTIES"]["CONTACTS_MAP"]["VALUE"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><img src="<?=$arItem["DISPLAY_PROPERTIES"]["CONTACTS_ICO"]["FILE_VALUE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>">
				<div class="block-map__places-content d-flex flex-column">
				  <h3><?=$arItem["NAME"];?></h3>
				  <?
				  	if ($arItem["DISPLAY_PROPERTIES"]["CONTACTS_PHONE"]["DISPLAY_VALUE"]) :
				  ?>
				  	<span class="block-map__phone text--white"><?=$arItem["DISPLAY_PROPERTIES"]["CONTACTS_PHONE"]["DISPLAY_VALUE"];?></span>
				  <?
				  	endif;
				  ?>
				  <div class="block-map__desc text--white"><?=htmlspecialcharsBack($arItem["DISPLAY_PROPERTIES"]["CONTACTS_ADDRESS"]["DISPLAY_VALUE"]);?></div>
				</div>
			  </div>

		  <?endforeach;?>

		</div>
		<div class="block-map__map col-lg-12 col-xl-9" id="map"></div>
	</div>
</div>

<script>
	ymaps.ready(initMap);

function initMap() {
    var myMap = new ymaps.Map('map', {
            center: [],
            zoom: null,
            controls: []
        }),

        MyBalloonLayout = ymaps.templateLayoutFactory.createClass(
            '<div class="balloon">' +
            '<a class="close" href="#">&times;</a>' +
            '<div class="arrow"></div>' +
            '<div class="balloon__inner">' +
            '$[[options.contentLayout observeSize minWidth=295 maxWidth=295]]' +
            '</div>' +
            '</div>', {
                /**
                 * Строит экземпляр макета на основе шаблона и добавляет его в родительский HTML-элемент.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#build
                 * @function
                 * @name build
                 */
                build: function () {
                    this.constructor.superclass.build.call(this);

                    this._$element = $('.balloon', this.getParentElement());

                    this.applyElementOffset();

                    this._$element.find('.close')
                        .on('click', $.proxy(this.onCloseClick, this));
                },

                /**
                 * Удаляет содержимое макета из DOM.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/layout.templateBased.Base.xml#clear
                 * @function
                 * @name clear
                 */
                clear: function () {
                    this._$element.find('.close')
                        .off('click');

                    this.constructor.superclass.clear.call(this);
                },

                /**
                 * Метод будет вызван системой шаблонов АПИ при изменении размеров вложенного макета.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name onSublayoutSizeChange
                 */
                onSublayoutSizeChange: function () {
                    MyBalloonLayout.superclass.onSublayoutSizeChange.apply(this, arguments);

                    if(!this._isElement(this._$element)) {
                        return;
                    }

                    this.applyElementOffset();

                    this.events.fire('shapechange');
                },

                /**
                 * Сдвигаем балун, чтобы "хвостик" указывал на точку привязки.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name applyElementOffset
                 */
                applyElementOffset: function () {
                    this._$element.css({
                        left: -(this._$element[0].offsetWidth / 2),
                        top: -(this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight)
                    });
                },

                /**
                 * Закрывает балун при клике на крестик, кидая событие "userclose" на макете.
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/IBalloonLayout.xml#event-userclose
                 * @function
                 * @name onCloseClick
                 */
                onCloseClick: function (e) {
                    e.preventDefault();

                    this.events.fire('userclose');
                },

                /**
                 * Используется для автопозиционирования (balloonAutoPan).
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/ILayout.xml#getClientBounds
                 * @function
                 * @name getClientBounds
                 * @returns {Number[][]} Координаты левого верхнего и правого нижнего углов шаблона относительно точки привязки.
                 */
                getShape: function () {
                    if(!this._isElement(this._$element)) {
                        return MyBalloonLayout.superclass.getShape.call(this);
                    }

                    var position = this._$element.position();

                    return new ymaps.shape.Rectangle(new ymaps.geometry.pixel.Rectangle([
                        [position.left, position.top], [
                            position.left + this._$element[0].offsetWidth,
                            position.top + this._$element[0].offsetHeight + this._$element.find('.arrow')[0].offsetHeight
                        ]
                    ]));
                },

                /**
                 * Проверяем наличие элемента (в ИЕ и Опере его еще может не быть).
                 * @function
                 * @private
                 * @name _isElement
                 * @param {jQuery} [element] Элемент.
                 * @returns {Boolean} Флаг наличия.
                 */
                _isElement: function (element) {
                    return element && element[0] && element.find('.arrow')[0];
                }
            });

        MyBalloonContentLayout = ymaps.templateLayoutFactory.createClass(
            '<h3 class="balloon__title">$[properties.balloonHeader]</h3>' +
            '<div class="balloon__content">$[properties.balloonContent]</div>'
        );

        // $(".block-map__buid").each(function(i) {
        // 	var coordinates = $(this).data("coordinates");
        // 	console.log(coordinates);
        // });

        <?
        	foreach($arResult["ITEMS"] as $key => $arItem):
        		?>
        			myPlacemar_<?=$key;?> = new ymaps.Placemark([<?=$arItem["DISPLAY_PROPERTIES"]["CONTACTS_MAP"]["VALUE"];?>], {
			            balloonHeader: '<?=$arItem["NAME"];?>',
			            balloonContent: '<?=htmlspecialcharsBack($arItem["DISPLAY_PROPERTIES"]["CONTACTS_ADDRESS"]["DISPLAY_VALUE"]);?>'
			        }, {
			            // Опции.
			            balloonLayout: MyBalloonLayout,
			            balloonContentLayout: MyBalloonContentLayout,
			            balloonPanelMaxMapArea: 0,
			            balloonOffset: [250, 0],
			            iconLayout: 'default#imageWithContent',
			            iconImageHref: '<?=$arItem["DISPLAY_PROPERTIES"]["CONTACTS_ICO_MAP"]["FILE_VALUE"]["SRC"];?>',
			            iconImageSize: [60, 80],
			            iconImageOffset: [-50, -104],
			            iconContentOffset: [15, 15],
			            hideIconOnBalloonOpen: false,
			        });

			        myMap.geoObjects.add(myPlacemar_<?=$key;?>);
        		<?
        	endforeach;
        ?>

        // myPlacemarkOffice = new ymaps.Placemark([55.75186416220157,37.66260508496096], {
        //     balloonHeader: 'Офис продаж',
        //     balloonContent: '8 495 812-46-46, Реутов, ул. Машиностроителей, д. 19/2'
        // }, {
        //     // Опции.
        //     balloonLayout: MyBalloonLayout,
        //     balloonContentLayout: MyBalloonContentLayout,
        //     balloonPanelMaxMapArea: 0,
        //     balloonOffset: [250, 0],
        //     iconLayout: 'default#imageWithContent',
        //     iconImageHref: '/include/img/baloon-2.svg',
        //     iconImageSize: [60, 80],
        //     iconImageOffset: [-50, -104],
        //     iconContentOffset: [15, 15],
        //     hideIconOnBalloonOpen: false,
        // });

        // myPlacemarkBuild = new ymaps.Placemark([55.646485300704335,37.84284953076173], {
        //     balloonHeader: 'Комплекс',
        //     balloonContent: 'г. Котельники, микрорайон «Южный», ул. Угрешская, напротив дома №6.'
        // }, {
        //     // Опции.
        //     balloonLayout: MyBalloonLayout,
        //     balloonContentLayout: MyBalloonContentLayout,
        //     balloonPanelMaxMapArea: 0,
        //     balloonOffset: [250, 0],
        //     iconLayout: 'default#imageWithContent',
        //     iconImageHref: '/include/img/baloon-1.svg',
        //     iconImageSize: [60, 80],
        //     iconImageOffset: [-50, -104],
        //     iconContentOffset: [15, 15],
        //     hideIconOnBalloonOpen: false,
        // });

    myMap.behaviors.disable('scrollZoom');
    myMap.controls.add('zoomControl');

    // myMap.geoObjects
    //     .add(myPlacemarkOffice)
    //     .add(myPlacemarkBuild);
    myMap.setBounds(myMap.geoObjects.getBounds());
    myMap.setZoom(myMap.getZoom() - 1);

}
</script>