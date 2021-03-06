<?php
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_client_partner.php');

class kit_crosssell extends CModule
{
    const MODULE_ID = 'kit.crosssell';
    var $MODULE_ID = 'kit.crosssell';
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $_1609633215 = '';

    function __construct()
    {
        $arModuleVersion = array();
        include(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage(self::MODULE_ID . '_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage(self::MODULE_ID . '_MODULE_DESC');
        $this->PARTNER_NAME = GetMessage('kit.crosssell_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('kit.crosssell_PARTNER_URI');
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB();
        $this->InstallEvents();
        ModuleManager::registerModule(self::MODULE_ID);
    }

    function InstallFiles($_1861802563 = array())
    {
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin', true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/css', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/css', true, true);
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/local', $_SERVER['DOCUMENT_ROOT'] . '/local', true, true);
        if (is_dir($_1008604548 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/components')) {
            if ($_1047317242 = opendir($_1008604548)) {
                while (false !== $_2081483366 = readdir($_1047317242)) {
                    if ($_2081483366 == '..' || $_2081483366 == '.') continue;
                    CopyDirFiles($_1008604548 . '/' . $_2081483366, $_SERVER['DOCUMENT_ROOT'] . '/bitrix/components/' . $_2081483366, $_1985542435 = True, $_1667996809 = True);
                }
                closedir($_1047317242);
            }
        }
        return true;
    }

    function installDB()
    {
        global $DB;
        $DB->runSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/db/' . strtolower($DB->type) . '/install.sql');
        return true;
    }

    function InstallEvents()
    {
        EventManager::getInstance()->registerEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlGroup', 'GetControlDescr');
        EventManager::getInstance()->registerEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlIBlockFields', 'GetControlDescr');
        EventManager::getInstance()->registerEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlIBlockProps', 'GetControlDescr');
        EventManager::getInstance()->registerEventHandler('main', 'OnBuildGlobalMenu', 'kit.crosssell', '\Kit\Crosssell\EventHandlers', 'OnBuildGlobalMenuHandler');
        return true;
    }

    function DoUninstall()
    {
        global $DB, $APPLICATION, $unstep;
        $unstep = IntVal($unstep);
        if ($unstep < 2) $APPLICATION->IncludeAdminFile(GetMessage('KIT_CROSSSELL_FORM_UNINSTALL_TITLE'), $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/unstep.php');
        $this->UnInstallFiles();
        $this->UnInstallEvents();
        $this->UnInstallDB();
        ModuleManager::unRegisterModule(self::MODULE_ID);
        if ($unstep > 2 && $_REQUEST['save'] != 'on') $DB->runSQLBatch($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/db/' . strtolower($DB->type) . '/uninstall.sql');
    }

    function UnInstallFiles()
    {
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/themes/.default/', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/themes/.default');
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/admin', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/css', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/css');
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/local', $_SERVER['DOCUMENT_ROOT'] . '/local');
        if (is_dir($_1008604548 = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . self::MODULE_ID . '/install/components')) {
            if ($_1047317242 = opendir($_1008604548)) {
                while (false !== $_2081483366 = readdir($_1047317242)) {
                    if ($_2081483366 == '..' || $_2081483366 == '.' || !is_dir($_235168559 = $_1008604548 . '/' . $_2081483366)) continue;
                    $_1532818864 = opendir($_235168559);
                    while (false !== $_578977376 = readdir($_1532818864)) {
                        if ($_578977376 == '..' || $_578977376 == '.') continue;
                        DeleteDirFilesEx('/bitrix/components/' . $_2081483366 . '/' . $_578977376);
                    }
                    closedir($_1532818864);
                }
                closedir($_1047317242);
            }
        }
        return true;
    }

    function UnInstallEvents()
    {
        EventManager::getInstance()->unRegisterEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlGroup', 'GetControlDescr');
        EventManager::getInstance()->unRegisterEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlIBlockFields', 'GetControlDescr');
        EventManager::getInstance()->unRegisterEventHandler(self::MODULE_ID, 'OnCondCatControlBuildListKitCrosssell', self::MODULE_ID, 'KitCrosssellCatalogCondCtrlIBlockProps', 'GetControlDescr');
        EventManager::getInstance()->unRegisterEventHandler('main', 'OnBuildGlobalMenu', 'kit.crosssell', '\Kit\Crosssell\EventHandlers', 'OnBuildGlobalMenuHandler');
        return true;
    }

    function UnInstallDB()
    {
    }
}