<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<nav class="nav align-items-start justify-content-xl-end align-items-xl-center justify-content-center h-100">
	<ul class="nav__list d-flex flex-column align-center justify-content-around flex-xl-row h-100">

	<?
	foreach($arResult as $arItem):
		if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
			continue;
	?>
		<?if($arItem["SELECTED"]):?>
			<li class="nav__item nav__item--active"><a href="<?=$arItem["LINK"]?>" class="nav__link"><?=$arItem["TEXT"]?></a></li>
		<?else:?>
			<li class="nav__item"><a href="<?=$arItem["LINK"]?>" class="nav__link"><?=$arItem["TEXT"]?></a></li>
		<?endif?>
		
	<?endforeach?>

	</ul>
</nav>
<?endif?>