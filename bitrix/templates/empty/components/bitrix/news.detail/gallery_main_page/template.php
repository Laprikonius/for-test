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

<div class="slider d-none d-xl-block">
	<div class="container">
		<div class="slider__container col-12 offset-0 col-xl-10 offset-xl-1">
			<div class="slider__main">
				<?
					foreach ($arResult["DISPLAY_PROPERTIES"]["IMAGES"]["VALUE"] as $key => $valueImage) :
						?>
							<img class="slider__pic" src="<?=CFile::GetPath($valueImage);?>" alt="">
						<?
					endforeach;
				?>
			</div>
		</div>
		<div class="slider__dots-container d-none d-md-block col-md-12 offset-0 col-xl-8 offset-xl-2">
			<div class="slider__dot">
				<?
					foreach ($arResult["DISPLAY_PROPERTIES"]["IMAGES"]["VALUE"] as $key => $valueImage) :
						?>
							<img class="slider__pic" src="<?=CFile::GetPath($valueImage);?>" alt="">
						<?
					endforeach;
				?>
			</div>
		</div>
	</div>
</div>