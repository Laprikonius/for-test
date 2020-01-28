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

<?
	$iblockText = CIBlock::GetArrayByID($arParams["IBLOCK_ID"]);
?>

<div class="near d-none d-xl-block">
	<div class="near__content d-lg-flex align-items-center">
		<div class="near__about col-lg-5 order-lg-1 offset-right-1">
			<div class="title"><?=$iblockText["NAME"];?></div>
			<?=htmlspecialcharsBack($iblockText["DESCRIPTION"]);?>
		</div>
		<div class="col-lg-1 order-lg-2"></div>
		<div class="near__picture d-lg-flex col-lg-6 align-items-lg-center justify-content-lg-center">
			<div class="near__picture-items d-flex flex-wrap align-items-center justify-content-center">
				<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
					<div class="near__img" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"];?>" alt="<?=$arItem["NAME"];?>"></div>
				<?endforeach;?>
			</div>
		</div>
	</div>
</div>