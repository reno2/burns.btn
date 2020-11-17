<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if(!check_bitrix_sessid()){

return;
}


?>

<form action="<? echo($APPLICATION->GetCurPage()); ?>">
		<?echo CAdminMessage::ShowMessage(Loc::getMessage("MOD_UNINST_WARN"))?>
	<p><?echo Loc::getMessage("MOD_UNINST_SAVE")?></p>
		<input type="hidden" name="lang" value="<? echo(LANG); ?>" />
		<input type="submit" value="<? echo(Loc::getMessage("BURNS_BTN_UNSTEP_SUBMIT_BACK")); ?>">
</form>