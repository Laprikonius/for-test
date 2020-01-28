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

<div class="project">
	<div class="container">
	<ul class="nav nav-tabs project__switch d-flex" id="myTab" role="tablist">
		<?foreach($arResult["ITEMS"] as $key => $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li class="nav-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a class="nav-link <? if ($key == 0) : ?>active<? endif; ?> project__switch-item" id="<?=$arItem["CODE"];?>-tab" data-toggle="tab" href="#<?=$arItem["CODE"];?>" role="tab" aria-controls="<?=$arItem["CODE"];?>" aria-selected="true"><?=$arItem["NAME"];?></a>
			</li>
		<?endforeach;?>
	</ul>
	</div>
	<div class="tab-content" id="myTabContent">
		<?foreach($arResult["ITEMS"] as $key => $arItem):?>
			<div class="project__content tab-pane fade <? if ($key == 0) : ?>show active<? endif; ?>" id="<?=$arItem["CODE"];?>" role="tabpanel" aria-labelledby="<?=$arItem["CODE"];?>-tab">
				<div class="project__wrap container-fluid d-flex">
					<div class="row">
						<div class="project__picture col-12 col-lg-6 order-lg-1" style="background-image: url('<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>')"></div>
						<div class="container-fluid col-12 col-lg-6">
							<div class="project__about">
								<div class="title title--gold project__title"><?=$arItem["NAME"];?></div>
								<div class="text text--white project__text"><?=htmlspecialcharsBack($arItem["PREVIEW_TEXT"]);?></div>
								<?=htmlspecialcharsBack($arItem["DETAIL_TEXT"]);?>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?endforeach;?>
	</div>
</div>