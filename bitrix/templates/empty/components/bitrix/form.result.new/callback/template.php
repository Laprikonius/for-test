<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?>
	<?//=$arResult["FORM_ERRORS_TEXT"];?>
<?endif;?>

<?if ($arResult["isFormNote"] != "Y" || $arResult["isFormNote"] == "Y")
{
	?>
	<div class="sign d-none d-xl-block">
		<div class="container container-callback">
			<?=$arResult["FORM_HEADER"]?>
			<div class="form d-flex flex-wrap">
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
				<div class="order__title title text--white col-10 offset-0 offset-lg-1">
					<?=$arResult["FORM_TITLE"]?>
					<p><?=$arResult["FORM_NOTE"]?></p>
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

				<p><?=$arResult["FORM_DESCRIPTION"]?></p>
				<?
			} // endif
				?>
			<?
			/***********************************************************************************
									form questions
			***********************************************************************************/
			?>
				<div class="col-12 offset-0 col-lg-5 offset-lg-1">
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
							<? if ($FIELD_SID != "MESSAGE") : ?>
								<?if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
									<span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
								<?endif;?>

								<div class="form-group">
			  						<label>
										<?=$arQuestion["HTML_CODE"]?>
									</label>
									<? if (strlen($arResult["FORM_ERRORS"][$FIELD_SID]) > 0) : ?>
										<span class="error-fld" style="display: block; color: red; text-align: left; font-size: 10px;" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>">Это поле обязательное</span>
									<? endif; ?>
								</div>
							<? endif; ?>
						<?
						}
					} //endwhile
					?>
				</div>
				<div class="form__content col-12 col-lg-5">
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
							<? if ($FIELD_SID == "MESSAGE") : ?>
								<label>
									<?=$arQuestion["HTML_CODE"]?>
								</label>
								<? if (strlen($arResult["FORM_ERRORS"][$FIELD_SID]) > 0) : ?>
									<span class="error-fld" style="display: block; color: red; text-align: left; font-size: 10px;" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>">Это поле обязательное</span>
								<? endif; ?>
								<p class="form__help text--white">Все поля обязательны для заполнения</p>
							<? endif; ?>
						<?
						}
					} //endwhile
					?>
				</div>
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
				<div class="form__send d-flex align-items-center flex-column col-12 offset-0 col-md-10 flex-md-row offset-md-1">
					<input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> class="button button--standart callback-button--standart" type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(strlen(trim($arResult["arForm"]["BUTTON"])) <= 0 ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" /><input type="hidden" name="web_form_apply" value="Y" />
					<div class="form__privacy text--white">Нажимая «Отправить», я даю согласие <a class="form__privacy-link text--white" href="/policy/">на обработку персональных данных</a>
					</div>
				</div>
			</div>
			<?=$arResult["FORM_FOOTER"]?>
		</div>
	</div>
	<?
} //endif (isFormNote)
?>