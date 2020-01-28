<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<style>
	.callback-form textarea {
	   width: 100%;
	   display: block;
	   position: relative;
	   resize: none;
	}
</style>
<?if ($arResult["isFormErrors"] == "Y"):?>
	<?=$arResult["FORM_ERRORS_TEXT"];?>
<?endif;?>

<?if ($arResult["isFormNote"] == "Y") : ?>
	<div class="form-note" style="padding-top: 35px;">
		<?=$arResult["FORM_NOTE"]?>
	</div>
<? endif; ?>
<?if ($arResult["isFormNote"] != "Y")
{
?>
<?=$arResult["FORM_HEADER"]?>


<?
if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y")
{
?>
	<?
/***********************************************************************************
					form header
***********************************************************************************/
if ($arResult["isFormTitle"])
{
?>
	<div class="callback-header">
		<?=$arResult["FORM_TITLE"]?>
	</div>
<?
} //endif ;

	if ($arResult["isFormImage"] == "Y")
	{
	?>
	<a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>"><img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" <?if($arResult["FORM_IMAGE"]["WIDTH"] > 300):?>width="300"<?elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200):?>height="200"<?else:?><?=$arResult["FORM_IMAGE"]["ATTR"]?><?endif;?> hspace="3" vscape="3" border="0" /></a>
	<?//=$arResult["FORM_IMAGE"]["HTML_CODE"]?>
	<?
	} //endif
	?>
	<div class="callback-descr">
		<?=$arResult["FORM_DESCRIPTION"]?>
	</div>
	<br>
	<?
} // endif
	?>
<?
/***********************************************************************************
						form questions
***********************************************************************************/
?>

	<?
	foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
	{
		if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
		{
			echo $arQuestion["HTML_CODE"];
		}
		else
		{
	?>
			<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
				<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
			<?endif;?>
			<label>
				<?=$arQuestion["CAPTION"]?>
				<br>
				<?/*if ($arQuestion["REQUIRED"] == "Y"):?><?=$arResult["REQUIRED_SIGN"];?><?endif;*/?>

				<?//=$arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y" ? "<br />".$arQuestion["IMAGE"]["HTML_CODE"] : ""?>

				<?=$arQuestion["HTML_CODE"]?>
			</label>
			<br>
	<?
		}
	} //endwhile
	?>
	<?
	if($arResult["isUseCaptcha"] == "Y")
	{
	?>
			<tr>
				<th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" /><img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" /></td>
			</tr>
			<tr>
				<td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
				<td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="inputtext" /></td>
			</tr>
	<?
	} // isUseCaptcha
	?>
	<br>
	<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" /><input type="hidden" name="web_form_apply" value="Y" />

<?=$arResult["FORM_FOOTER"]?>
<?
} //endif (isFormNote)
?>
<script>
	// if ($(".callback-modal-container form textarea").val() !== "") {
	// 	$(".callback-modal-container form textarea").val(titleText);
	// };
	//console.log($(".callback-modal-container form textarea").val());
</script>