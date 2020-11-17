<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\EventManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\Loader;
use Bitrix\Main\Entity\Base;

Loc::loadMessages(__FILE__);

class burns_btn extends CModule{
		public function __construct()
		{
				if(file_exists(__DIR__."/version.php")){

						$arModuleVersion = array();

						include_once(__DIR__."/version.php");

						$this->MODULE_ID 		   = 'burns.btn';
						$this->MODULE_VERSION 	   = $arModuleVersion["VERSION"];
						$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
						$this->MODULE_NAME 		   = Loc::getMessage("BURNS_BTN_NAME");
						$this->MODULE_DESCRIPTION  = Loc::getMessage("BURNS_BTN_DESCRIPTION");
						$this->PARTNER_NAME 	   = Loc::getMessage("BURNS_BTN_PARTNER_NAME");
						$this->PARTNER_URI  	   = Loc::getMessage("BURNS_BTN_PARTNER_URI");
				}
		}
		public function DoInstall(){

				global $APPLICATION;

				if(CheckVersion(ModuleManager::getVersion("main"), "14.00.00")){
						ModuleManager::registerModule($this->MODULE_ID);

						$this->InstallFiles();
						$this->InstallDB();
						$this->InstallEvents();
				}else{

						$APPLICATION->ThrowException(
								Loc::getMessage("BURNS_BTN_INSTALL_ERROR_VERSION")
						);
				}

				$APPLICATION->IncludeAdminFile(
						Loc::getMessage("BURNS_BTN_INSTALL_TITLE")." \"".Loc::getMessage("BURNS_BTN_NAME")."\"",
						__DIR__."/step.php"
				);

				return false;
		}

		public function InstallFiles(){
				CopyDirFiles(
						__DIR__."/assets/scripts",
						Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID."/",
						true,
						true
				);


				CopyDirFiles(
						__DIR__."/assets/styles",
						Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID."/",
						true,
						true
				);

				CopyDirFiles(
						__DIR__."/assets/images",
						Application::getDocumentRoot()."/bitrix/images/".$this->MODULE_ID."/",
					true,
				true
				);
				return false;
		}
		public function InstallDB(){
return false;


		}

		public function InstallEvents(){

				EventManager::getInstance()->registerEventHandler(
						"main",
						"OnBeforeEndBufferContent",
						$this->MODULE_ID,
						"Burns\Btn\Main",
						"appendScriptsToPage"
				);


				return true;
		}

		public function DoUninstall(){
				global $APPLICATION;

				$this->UnInstallFiles();
				$this->UnInstallDB();
				$this->UnInstallEvents();
				ModuleManager::unRegisterModule($this->MODULE_ID);
				$APPLICATION->IncludeAdminFile(
						Loc::getMessage("BURNS_BTN_UNINSTALL_TITLE")." \"".Loc::getMessage("BURNS_BTN_NAME")."\"",
						__DIR__."/unstep.php"
				);
				return false;
		}

		public function UnInstallFiles(){
				Directory::deleteDirectory(
						Application::getDocumentRoot()."/bitrix/js/".$this->MODULE_ID
				);
				Directory::deleteDirectory(
						Application::getDocumentRoot()."/bitrix/css/".$this->MODULE_ID
				);
				Directory::deleteDirectory(
						Application::getDocumentRoot()."/bitrix/images/".$this->MODULE_ID
				);
				return false;
		}

		public function UnInstallDB(){
				Option::delete($this->MODULE_ID);
				return false;
		}

		public function UnInstallEvents(){


				EventManager::getInstance()->unRegisterEventHandler(
						"main",
						"OnBeforeEndBufferContent",
						$this->MODULE_ID,
						"Burns\Btn\Main",
						"appendScriptsToPage"
				);




				return false;
		}


}