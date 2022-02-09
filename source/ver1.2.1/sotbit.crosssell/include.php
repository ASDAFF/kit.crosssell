<?php

use Bitrix\Main\Loader;
use Sotbit\Crosssell\Orm\CrosssellTable;

\Bitrix\Main\Loader::registerAutoloadClasses('sotbit.crosssell', array('SotbitCrosssellCatalogCondTree' => '/classes/general/CondTree.php',));

class SotbitCrosssell
{
    const moduleId = 'sotbit.crosssell';
    private static $_358421160 = false;

    public static function getSites()
    {
        $_810840136 = [];
        try {
            $_1735987118 = \Bitrix\Main\SiteTable::getList(['select' => ['SITE_NAME', 'LID', 'DEF'], 'filter' => ['ACTIVE' => 'Y'],]);
            while ($_1727822109 = $_1735987118->fetch()) {
                if ($_1727822109['DEF'] == 'Y') {
                    $_810840136[] = $_1727822109['LID'];
                } else {
                    $_810840136[$_1727822109['LID']] = $_1727822109['SITE_NAME'];
                }
            }
        } catch (ObjectPropertyException $_1833214007) {
            $_1833214007->getMessage();
        } catch (ArgumentException $_1833214007) {
            $_1833214007->getMessage();
        } catch (SystemException $_1833214007) {
            $_1833214007->getMessage();
        }
        try {
            if (!is_array($_810840136) || count($_810840136) == 0) {
                throw new SystemException('Cannt get sites');
            }
        } catch (SystemException $_407393848) {
            echo $_407393848->getMessage();
        }
        return $_810840136;
    }

    public function getDemo()
    {
        if (self::$_358421160 === false) self::__514774657();
        return !(static::$_358421160 == 0 || static::$_358421160 == 3);
    }

    private static function __514774657()
    {
        static::$_358421160 = CModule::IncludeModuleEx(self::moduleId);
    }

    public function ReturnDemo()
    {
        if (self::$_358421160 === false) self::__514774657();
        return static::$_358421160;
    }

    public function hasInfoBlock($_1907048608)
    {
        $_1724634049 = false;
        foreach ($_1907048608['CHILDREN'] as $_1103960035) {
            if ($_1724634049) {
                break;
            }
            if ($_1103960035['CLASS_ID'] == 'CondIBIBlock') {
                $_1724634049 = true;
                break;
            }
            if ($_1103960035['CLASS_ID'] == 'CondGroup') {
                foreach ($_1103960035['CHILDREN'] as $_1977148229) {
                    if ($_1977148229['CLASS_ID'] == 'CondIBIBlock') {
                        $_1724634049 = true;
                        break;
                    }
                }
            }
        }
        return $_1724634049;
    }

    public function getInfoBlocks($_1907048608)
    {
        $_122793195 = array();
        foreach ($_1907048608['CHILDREN'] as $_1103960035) {
            if ($_1103960035['CLASS_ID'] == 'CondIBIBlock') {
                array_push($_122793195, $_1103960035['DATA']['value']);
            }
            if ($_1103960035['CLASS_ID'] == 'CondGroup') {
                foreach ($_1103960035['CHILDREN'] as $_1977148229) {
                    if ($_1977148229['CLASS_ID'] == 'CondIBIBlock') {
                        array_push($_122793195, $_1977148229['DATA']['value']);
                    }
                }
            }
        }
        if (count($_122793195) > 0) {
            return $_122793195;
        } else {
            return false;
        }
    }

    public function generateCondition($_1127620332 = 0)
    {
        if ($_1127620332 == 0) {
            $_1735987118 = CrosssellTable::getList(array('select' => array('ID', 'RULE1', 'TYPE_BLOCK', "RULE2"), 'filter' => array('Active' => 'Y')));
        } else {
            $_1735987118 = CrosssellTable::getList(array('select' => array('ID', 'RULE1', 'TYPE_BLOCK', 'RULE2'), 'filter' => array('Active' => 'Y', 'ID' => $_1127620332)));
        }
        $_2043834136 = 0;
        while ($_2050530301 = $_1735987118->fetch()) {
            $_1955260941 = 0;
            if ($_2050530301['TYPE_BLOCK'] == 'CROSSSELL') {
                $_1060877338 = new \SotbitCrosssellCatalogCondTree();
                $_896660442 = $_1060877338->Init(BT_COND_MODE_PARSE, BT_COND_BUILD_CATALOG, array());
                $_790576081 = unserialize($_2050530301['RULE1']);
                $_1695536655 = $this->getProducts($_790576081);
                $_2043834136 = $_1695536655['COUNTER'];
            } else if ($_2050530301['TYPE_BLOCK'] == 'COLLECTION') {
                $_1695536655 = $this->getProducts(unserialize($_2050530301['RULE1']));
                $_1695536655['PRODUCTS'] = '';
            }
            $_1368304016 = array('NUMBER_OF_MATCHED_PRODUCTS' => $_1695536655['COUNTER'], 'PRODUCTS' => serialize($_1695536655['PRODUCTS']));
            CrosssellTable::update($_2050530301['ID'], $_1368304016);
        }
        return $_2043834136;
    }

    public function getProducts($_790576081)
    {
        $_1922378084 = $this->getFilter($_790576081);
        $_1695536655 = array('PRODUCTS' => array(),);
        $_361505742 = 0;
        Loader::includeModule('iblock');
        $_135720353 = CIBlockElement::GetList(array(), $_1922378084, false, false, array());
        while ($_1861314377 = $_135720353->fetch()) {
            array_push($_1695536655['PRODUCTS'], array('ID' => $_1861314377['ID'], 'IBLOCK_ID' => $_1861314377['IBLOCK_ID']));
            $_361505742++;
        }
        $_1695536655['COUNTER'] = $_361505742;
        return $_1695536655;
    }

    public function getFilter($_790576081)
    {
        $_1907048608 = $_790576081;
        if (is_array($_1907048608['CHILDREN']) && (count($_1907048608['CHILDREN']) > 0)) {
            $_2118047969 = array('INCLUDE_SUBSECTIONS' => 'Y', array('LOGIC' => $_1907048608['DATA']['All'],));
            $_450943884 = 0;
            $_1358408154 = 0;
            foreach ($_1907048608['CHILDREN'] as $_1824249421 => $_1103960035) {
                if (strpos($_1103960035['CLASS_ID'], 'CondIBPrice') !== false) {
                    $_1358408154++;
                }
            }
        } elseif (is_array($_1907048608['RULE3']) && (count($_1907048608['RULE3']) > 0)) {
            $_2118047969 = array('INCLUDE_SUBSECTIONS' => 'Y', array('LOGIC' => $_1907048608['DATA']['All'],));
            array_push($_2118047969[0], array('ID' => 0));
        }
        if ($_1907048608['DATA']['True'] == 'True') {
            $_444135469 = true;
        } else {
            $_444135469 = false;
        }
        if (CModule::IncludeModule('iblock')) {
            $_1588168220 = CIBlockElement::GetList(array(), array('ID' => $this->_1529115784['PRODUCT_ID']));
            if ($_841613600 = $_1588168220->GetNext()) $_46135770 = $_841613600['IBLOCK_SECTION_ID'];
        }
        foreach ($_1907048608['CHILDREN'] as $_1824249421 => $_1103960035) {
            if ($_1103960035['DATA']['logic']) $_1121337893 = $_1103960035['DATA']['logic'];
            if ($_444135469) {
                if ($_1121337893 == 'Not') {
                    $_1121337893 = '!';
                } else {
                    $_1121337893 = '';
                }
            } else {
                if ($_1121337893 == 'Not') {
                    $_1121337893 = '';
                } else {
                    $_1121337893 = '!';
                }
            }
            if ($_1103960035['CLASS_ID'] == 'CondIBSection') {
                array_push($_2118047969[0], array($_1121337893 . 'SECTION_ID' => ($_1103960035['DATA']['value'] != '') ? $_1103960035['DATA']['value'] : $_46135770, 'INCLUDE_SUBSECTIONS' => 'Y'));
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBIBlock') {
                array_push($_2118047969[0], array('IBLOCK_ID' => $_1103960035['DATA']['value']));
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBXmlID') {
                array_push($_2118047969[0], array($_1121337893 . 'XML_ID' => $_1103960035['DATA']['value']));
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBName') {
                array_push($_2118047969[0], array($_1121337893 . 'NAME' => $_1103960035['DATA']['value']));
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBElement') {
                array_push($_2118047969[0], array($_1121337893 . 'ID' => $_1103960035['DATA']['value']));
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBCode') {
                array_push($_2118047969[0], array($_1121337893 . 'CODE' => $_1103960035['DATA']['value']));
            } elseif (strpos($_1103960035['CLASS_ID'], 'CondIBPrice') !== false) {
                $_1757556510 = strpos('CondIBPrice', '', $_1103960035['CLASS_ID']);
                ($_1103960035['DATA']['logic'] != '') ? $_581200112 = $_1103960035['DATA']['logic'] : $_581200112 = '';
                $_581200112 = $this->convertLogic($_581200112, $_444135469);
                if ($_450943884 == 0) {
                    $_1120489205 = array('LOGIC' => $_1907048608['DATA']['All'], array('ACTIVE' => 'Y'), array($_581200112 . 'CATALOG_PRICE_' . $_1757556510 => $_1103960035['DATA']['value']),);
                    $_794042410 = array('IBLOCK_ID' => $this->_1537242725, 'INCLUDE_SUBSECTIONS' => 'Y', $_1120489205,);
                } else {
                    array_push($_1120489205, array($_581200112 . 'CATALOG_PRICE_' . $_1757556510 => $_1103960035['DATA']['value']));
                    $_794042410 = array('IBLOCK_ID' => $this->_1537242725, 'INCLUDE_SUBSECTIONS' => 'Y', $_1120489205,);
                }
                if ($_450943884 == ($_1358408154 - 1)) {
                    $_1613904227 = CIBlockElement::GetList(array('SORT' => 'ASC'), $_794042410, false, array(), array());
                    $_850793570 = array();
                    $_1853216539 = 0;
                    while ($_1588168220 = $_1613904227->GetNext()) {
                        $_850793570[$_1853216539]['ID'] = $_1588168220['ID'];
                        $_1853216539++;
                    }
                    if (!isset($_1463470828)) $_1463470828 = array();
                    foreach ($_850793570 as $_820772368) {
                        $_447592494 = CCatalogSku::GetProductInfo($_820772368['ID'], $this->_1537242725);
                        array_push($_1463470828, $_447592494['ID']);
                        $this->insertIdToFilter($_2118047969, $_447592494['ID'], $_1121337893);
                    }
                }
                $_581200112 = $this->convertLogic($_1103960035['DATA']['logic'], $_444135469);
                $_967659395 = array($_581200112 . 'CATALOG_PRICE_' . $_1757556510 => $_1103960035['DATA']['value']);
                array_push($_2118047969[0], $_967659395);
                $_450943884++;
            } elseif (strpos($_1103960035['CLASS_ID'], 'CondIBProp') !== false) {
                $_1520089689 = explode(':', $_1103960035['CLASS_ID']);
                $_1233990463 = $_1520089689[2];
                $_1265852639 = $_1520089689[1];
                $_2040948231 = CCatalogSKU::GetInfoByOfferIBlock($_1265852639);
                $_686118325 = $_1103960035['DATA']['value'];
                $_2014032076 = CIBlockElement::GetProperty($_1265852639, $this->_1529115784['PRODUCT_ID'], array('sort' => 'asc'), array('ID' => $_1233990463));
                $_822076149 = array();
                while ($_1288122973 = $_2014032076->GetNext()) {
                    array_push($_822076149, $_1288122973['VALUE']);
                }
                $_1831030346 = array('PROPERTY_' . $_1233990463);
                $_1532132512 = array('ID' => $this->_1529115784['ELEMENT_ID']);
                $_1588168220 = CIBlockElement::GetList(array(), $_1532132512, false, array(), $_1831030346);
                $_841613600 = $_1588168220->fetch();
                if ($_686118325 == '') {
                    $_686118325 = $_822076149;
                }
                $_967659395 = array($_1121337893 . 'PROPERTY_' . $_1233990463 => $_686118325);
                $_1823181498 = CIBlockProperty::GetList(array(), array('ID' => $_1233990463));
                if ($_1424403512 = $_1823181498->GetNext()) {
                    $_1648146089 = $_1424403512['CODE'];
                    $_1586947836 = $_1424403512['USER_TYPE'];
                    $_1376971764 = $_1424403512['PROPERTY_TYPE'];
                }
                if ($_2040948231) {
                    $_1039197765 = $_1424403512['USER_TYPE_SETTINGS']['TABLE_NAME'];
                    $_1337500284 = $_1103960035['DATA']['value'];
                    if ($_1337500284 == '') {
                        $_1588168220 = CCatalogSKU::getOffersList($this->_1529115784['PRODUCT_ID'], '', $_896671681 = array(), $_548092124 = array(), $_325238569 = array('ID' => array($_1233990463)));
                        $_907528701 = array();
                        if (is_array($_1588168220[$this->_1529115784['PRODUCT_ID']])) {
                            foreach ($_1588168220[$this->_1529115784['PRODUCT_ID']] as $_788383929) {
                                foreach ($_788383929['PROPERTIES'] as $_911007405) {
                                    if ($_911007405['VALUE'] != '') array_push($_907528701, $_911007405['VALUE']);
                                }
                            }
                        }
                    }
                    if ($_1586947836 == 'directory' && $_1376971764 == 'S') {
                        if ($_1337500284 == '') {
                            if (is_array($_907528701)) {
                                $_1367980010 = array();
                                foreach ($_907528701 as $_1024174964) {
                                    $_2118047969[0][$_1121337893 . 'ID'] = array();
                                    $_2118047969 = $this->__370288036($_1648146089, $_1024174964, $_2118047969, $_1121337893, $_1265852639);
                                    array_push($_1367980010, $_2118047969[0][$_1121337893 . 'ID']);
                                }
                            }
                            if (count($_1367980010) > 1) {
                                $_1720179285 = $_1367980010[0];
                                for ($_1853216539 = 0; $_1853216539 < count($_1367980010); $_1853216539++) {
                                    $_1720179285 = array_intersect($_1720179285, $_1367980010[$_1853216539]);
                                }
                                $_2118047969[0][$_1121337893 . 'ID'] = $_1720179285;
                            } else {
                                foreach ($_1367980010 as $_1127620332) {
                                    $_2118047969[0][$_1121337893 . 'ID'] = $_1127620332;
                                }
                            }
                        } else {
                            $_1691669412 = $this->__974123737($_1337500284, $_1039197765);
                            $_2118047969 = $this->__370288036($_1648146089, $_1691669412, $_2118047969, $_1121337893, $_1265852639);
                        }
                    } else {
                        $_2118047969 = $this->__370288036($_1648146089, $_1103960035['DATA']['value'], $_2118047969, $_1121337893, $_1265852639);
                    }
                } else {
                    array_push($_2118047969[0], $_967659395);
                }
            } elseif ($_1103960035['CLASS_ID'] == 'CondGroup') {
                $_1127447469 = ($_1103960035['DATA']['True'] == 'True') ? true : false;
                $_794349127 = $this->getChilden($_1103960035['CHILDREN'], $_1127447469, $_841613600);
                $_978984828 = array_merge(array('INCLUDE_SUBSECTIONS' => 'Y', 'LOGIC' => $_1103960035['DATA']['All'],), $_794349127);
                array_push($_2118047969[0], $_978984828);
            }
        }
        if (is_array($_1907048608['RULE3'])) {
            $_2118047969 = array('INCLUDE_SUBSECTIONS' => 'Y', array('LOGIC' => 'OR', $_2118047969[0]));
            foreach ($_1907048608['RULE3'] as $_1337959745) {
                $_1184745104 = explode(':', $_1337959745);
                $_1337959745 = $_1184745104[0];
                $_1588168220 = CIBlockElement::GetProperty($_1184745104[1], $this->_1529115784['PRODUCT_ID'], 'sort', 'asc', array('ID' => $_1337959745));
                while ($_841613600 = $_1588168220->GetNext()) {
                    if ($_841613600['VALUE']) $_744819924[] = $_841613600['VALUE'];
                }
            }
            if (is_array($_744819924) && (count($_744819924) > 0)) {
                array_push($_2118047969[0], array('ID' => $_744819924));
            }
        }
        return $_2118047969;
    }

    private function __370288036($_1648146089, $_1913854021, $_2118047969, $_1121337893, $_1265852639)
    {
        $_1532132512 = array('ID' => CIBlockElement::SubQuery('PROPERTY_CML2_LINK', array('IBLOCK_ID' => $_1265852639, 'PROPERTY_' . $_1648146089 => $_1913854021,)));
        $_1588168220 = CIBlockElement::GetList(array(), $_1532132512, false, array(), array('ID'));
        while ($_2050530301 = $_1588168220->fetch()) {
            $_1139115372[] = $_2050530301['ID'];
        }
        if (is_array($_1139115372) && (count($_1139115372) > 0)) {
            if (isset($_2118047969[0])) {
                array_push($_2118047969[0], array($_1121337893 . 'ID' => $_1139115372));
            } else {
                $_2118047969 = array_merge($_2118047969, array($_1121337893 . 'ID' => $_1139115372));
            }
        }
        return $_2118047969;
    }

    private function __974123737($_1337500284, $_1039197765)
    {
        \Bitrix\Main\Loader::IncludeModule("highloadblock");
        $_1115104401 = ['UF_XML_ID'];
        $_1922378084 = ['ID' => $_1337500284];
        $_250259347 = 1;
        $_1930705112 = \Bitrix\Highloadblock\HighloadBlockTable::getList(array('filter' => array('TABLE_NAME' => $_1039197765)))->fetch();
        $_472212541 = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($_1930705112);
        $_2034407299 = new \Bitrix\Main\Entity\Query($_472212541);
        $_2034407299->setSelect($_1115104401);
        $_2034407299->setFilter($_1922378084);
        $_2034407299->setOrder([]);
        $_2034407299->setLimit($_250259347);
        $_1720179285 = $_2034407299->exec();
        $_1720179285 = $_1720179285->fetch();
        $_1691669412 = $_1720179285['UF_XML_ID'];
        return $_1691669412;
    }

    public function getChilden($_623209077, $_1861925565)
    {
        $_552615238 = array();
        foreach ($_623209077 as $_1103960035) {
            if ($_1103960035['CLASS_ID'] == 'CondIBSection') {
                if ($_1861925565) {
                    array_push($_552615238, array('SECTION_ID' => $_1103960035['DATA']['value'], 'INCLUDE_SUBSECTIONS' => 'Y'));
                } else {
                    array_push($_552615238, array('!SECTION_ID' => $_1103960035['DATA']['value'], 'INCLUDE_SUBSECTIONS' => 'Y'));
                }
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBXmlID') {
                if ($_1861925565) {
                    array_push($_552615238, array('XML_ID' => $_1103960035['DATA']['value']));
                } else {
                    array_push($_552615238, array('!XML_ID' => $_1103960035['DATA']['value']));
                }
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBName') {
                if ($_1861925565) {
                    array_push($_552615238, array('NAME' => $_1103960035['DATA']['value']));
                } else {
                    array_push($_552615238, array('!NAME' => $_1103960035['DATA']['value']));
                }
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBElement') {
                if ($_1861925565) {
                    array_push($_552615238, array('ID' => $_1103960035['DATA']['value']));
                } else {
                    array_push($_552615238, array('!ID' => $_1103960035['DATA']['value']));
                }
            } elseif ($_1103960035['CLASS_ID'] == 'CondIBCode') {
                if ($_1861925565) {
                    array_push($_552615238, array('CODE' => $_1103960035['DATA']['value']));
                } else {
                    array_push($_552615238, array('!CODE' => $_1103960035['DATA']['value']));
                }
            } elseif (strpos($_1103960035['CLASS_ID'], 'CondIBProp') !== false) {
                $_1520089689 = explode(':', $_1103960035['CLASS_ID']);
                $_1233990463 = $_1520089689[2];
                if ($_1861925565) {
                    array_push($_552615238, array('PROPERTY_' . $_1233990463 => $_1103960035['DATA']['value']));
                } else {
                    array_push($_552615238, array('!PROPERTY_' . $_1233990463 => $_1103960035['DATA']['value']));
                }
            }
        }
        return $_552615238;
    }
}

class DataManagerCrosssell extends Bitrix\Main\Entity\DataManager
{
    public static function getList(array $_417019560 = array())
    {
        if (!SotbitCrosssell::getDemo()) return new Bitrix\Main\ORM\Query\Result(parent::query(), new \Bitrix\Main\DB\ArrayResult(array())); else return parent::getList($_417019560);
    }

    public static function getById($_1127620332 = "")
    {
        if (!SotbitCrosssell::getDemo()) return new \CDBResult; else return parent::getById($_1127620332);
    }

    public static function add(array $_464197536 = array())
    {
        if (!SotbitCrosssell::getDemo()) return new \Bitrix\Main\Entity\AddResult(); else return parent::add($_464197536);
    }

    public static function update($_1127620332 = "", array $_464197536 = array())
    {
        if (!SotbitCrosssell::getDemo()) return new \Bitrix\Main\Entity\UpdateResult(); else return parent::update($_1127620332, $_464197536);
    }
}