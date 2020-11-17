<?
use Bitrix\Main\Localization\Loc;
use	Bitrix\Main\HttpApplication;
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;

Loc::loadMessages(__FILE__);

$request = HttpApplication::getInstance()->getContext()->getRequest();

$module_id = htmlspecialcharsbx($request["mid"] != "" ? $request["mid"] : $request["id"]);

Loader::includeModule($module_id);

$aTabs = array(
		array(
				"DIV" 	  => "edit",
				"TAB" 	  => Loc::getMessage("BURNS_BTN_OPTIONS_TAB_NAME"),
				"TITLE"   => Loc::getMessage("BURNS_BTN_OPTIONS_TAB_NAME"),
				"OPTIONS" => array(
						Loc::getMessage("BURNS_BTN_OPTIONS_TAB_COMMON"),
						array(
								"switch_on",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_SWITCH_ON"),
								"Y",
								array("checkbox")
						),


						array(
								"delay",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_DELAY"),
								"5000",
								array("text", 50)
						),

						array(
								"theme",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_THEME"),
								"dark",
								array("selectbox", array(
										"dark"  => Loc::getMessage("BURNS_BTN_OPTIONS_TAB_THEME_DARK"),
										"green" => Loc::getMessage("BURNS_BTN_OPTIONS_TAB_THEME_GREEN"),
										"red" => Loc::getMessage("BURNS_BTN_OPTIONS_TAB_THEME_RED"),
										"pravpost" => 'pravpost',
										"blagosloven" => 'blagosloven',
										"magnitik" => 'magnitik',
								))
						),

						Loc::getMessage("BURNS_BTN_OPTIONS_TAB_APPEARANCE"),
						array(
								"url",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_URL"),
								"#",
								array("text", 50)
						),

						array(
								"text_btn",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_TEXT_BTN"),
								"Ваша выгода",
								array("text",50)
						),	

						array(
								"text_main_btn",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_TEXT_MAIN_BTN"),
								"Ваша выгода",
								array("text",50)
						),	

						array(
								"msg_title",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_MSG_TITLE"),
								"Хотите повысить доходность бизнеса?",
								array("text",50)
						),
						array(
								"msg_body",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_MSG_TEXT"),
								"подпишитесь на полезный бизнес-контент, новинки и скидки?",
								array("text",50)
						),

						Loc::getMessage("BURNS_BTN_OPTIONS_TAB_ACTION"),


						array(
								"times",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_TIMES"),
								"3",
								array("text", 5)
						),

						array(
								"timer",
								Loc::getMessage("BURNS_BTN_OPTIONS_TAB_TIMER"),
								"6000",
								array("text", 5)
						),


				)
		)
);

$tabControl = new CAdminTabControl(
		"tabControl",
		$aTabs
);

$tabControl->Begin();?>
	<form action="<? echo($APPLICATION->GetCurPage()); ?>?mid=<? echo($module_id); ?>&lang=<? echo(LANG); ?>" method="post">

			<?
			foreach($aTabs as $aTab){

					if($aTab["OPTIONS"]){

							$tabControl->BeginNextTab();

							__AdmSettingsDrawList($module_id, $aTab["OPTIONS"]);
					}
			}

			$tabControl->Buttons();
			?>
		<div style="display:none;">
			<img  src="<?=COption::GetOptionString('sng.up', 'sng_up_button'.'_'.$site['LID'], "/bitrix/images/sng.up/up1.png")?>">
			<input type="file" name="sng_up_button">
		</div>
		<input type="submit" name="apply" value="<? echo(Loc::GetMessage("BURNS_BTN_OPTIONS_INPUT_APPLY")); ?>" class="adm-btn-save" />
		<input type="submit" name="default" value="<? echo(Loc::GetMessage("BURNS_BTN_OPTIONS_INPUT_DEFAULT")); ?>" />

			<?
			echo(bitrix_sessid_post());
			?>

	</form>
<?
$tabControl->End();


if($request->isPost() && check_bitrix_sessid()){

		if(strlen($_FILES['sng_up_button']["tmp_name"])>0)
		{
				$sp = preg_split("#\/#", $_FILES[sng_up_button][type]);
				if($sp[0] == 'image'){
						$tmp_name = $_FILES[sng_up_button]["tmp_name"];
						$filename = $_FILES[sng_up_button]["name"];
						move_uploaded_file($tmp_name, $_SERVER['DOCUMENT_ROOT']."/bitrix/images/burns.btn/".$filename);
						COption::SetOptionString($module_id, $name.'_'.$sitech, "/bitrix/images/burns.btn/".$filename);
				}
				else
				{
						//error file
						$message=CAdminMessage::ShowMessage(GetMessage("SNG_UP_FILE_ERROR").$sp[0]);
						$error=true;
				}
		}

		foreach($aTabs as $aTab){

				foreach($aTab["OPTIONS"] as $arOption){

						if(!is_array($arOption)){

								continue;
						}

						if($arOption["note"]){

								continue;
						}

						if($request["apply"]){

								$optionValue = $request->getPost($arOption[0]);

								if($arOption[0] == "switch_on"){

										if($optionValue == ""){

												$optionValue = "N";
										}
								}

								Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(",", $optionValue) : $optionValue);
						}elseif($request["default"]){

								Option::set($module_id, $arOption[0], $arOption[2]);
						}
				}
		}

		LocalRedirect($APPLICATION->GetCurPage()."?mid=".$module_id."&lang=".LANG);
}