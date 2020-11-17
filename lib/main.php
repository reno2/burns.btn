<?php
namespace Burns\Btn;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

class Main{

		public function appendScriptsToPage(){
				if(!defined("ADMIN_SECTION") && $ADMIN_SECTION !== true){
						$module_id = pathinfo(dirname(__DIR__))["basename"];

						Asset::getInstance()->addJs("/bitrix/js/".$module_id."/jquery.min.js");
						Asset::getInstance()->addJs("/bitrix/js/".$module_id."/script.min.js");
						Asset::getInstance()->addJs("/bitrix/js/".$module_id."/widget.js");
						Asset::getInstance()->addCss("/bitrix/css/".$module_id."/style.min.css");
						Asset::getInstance()->addCss("/bitrix/css/".$module_id."/widget.css");


						Asset::getInstance()->addString(
								"<script id=\"".str_replace(".", "_", $module_id)."-params\" data-params='".json_encode(
										array(
												"switch_on" 	=> Option::get($module_id, "switch_on", "Y"),
												"delay"    	=> Option::get($module_id, "delay", "5000"),
												"times"    	=> Option::get($module_id, "times", "3"),
												"timer"     	=> Option::get($module_id, "timer", "6000"),
												"text_btn"     	=> Option::get($module_id, "text_btn", "Посказка"),
												"text_main_btn"     	=> Option::get($module_id, "text_main_btn", "Ваша выгода"),
												"url"     	=> Option::get($module_id, "url", "#"),
												"theme"   	    => Option::get($module_id, "theme", "dark"),
												"msg_title"   	    => Option::get($module_id, "msg_title", ""),
												"msg_body"   	    => Option::get($module_id, "msg_body", ""),
										)
								)."'></script>",
								true
						);
				}

				return false;
		}
}