<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
// FILTER // ------------------------------------------------------------------------------------------------------------------------------------------------------------------
global ${$arParams["FILTER_NAME"]};

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if (isset($arParams['SECTION_TEMPLATE']) && (strlen($arParams['SECTION_TEMPLATE']) > 0)){
    $sectionTemplate = $arParams['SECTION_TEMPLATE'];
} else {
    $sectionTemplate = '';
}

//if works in section mode
if ( is_array($arResult['CROSSSELL_ARRAY']))
{
    $isAjax = $arParams['AJAX_MODE'];
    if ($arParams['SHOW_TABS'] == 'Y')
    {
        $crosssells = $arResult['CROSSSELL_ARRAY'];
        ?>
        <section class="catalog_section_block catalog_section_block_tabs">
            <ul id="crosssells" class="tabs_sale_block__caption">
                <?
                $i = 0;
                $collectionParameters = array();
                foreach ($crosssells as $tabId => $crosssell) {
                    $collectionParameters[$tabId]['IBLOCK_ID'] = $arParams['IBLOCK_ID'];
                    $collectionParameters[$tabId]['FROM_COMPLEX'] = $arParams['FROM_COMPLEX'];
                    $collectionParameters[$tabId]['SECTION_ID'] = $sectionId;
                    if ($isAjax == 'Y') {
                        ?>
                        <li class="collection-<?= $tabId; ?><?= ($i == 0) ? " active collection-loaded" : '' ?>"
                            data-collection-id="<? echo $tabId ?>"><?= $crosssell['NAME'] ?></li>
                        <?
                    } else {
                        ?>
                        <li class="collection-<?= $tabId; ?>  collection-loaded<?= ($i == 0) ? " active" : '' ?>"
                            data-collection-id="<? echo $tabId ?>"><?= $crosssell['NAME'] ?></li>
                        <?
                    }
                    $i++;}?>
            </ul>
            <div class="tabs_sale_block">
                <? if ($crosssells)
                {
                    $i = 0;
                    foreach ($crosssells as $tabId => $crosssell)
                    {
                        ${$arParams["FILTER_NAME"]} = $crosssell['FILTER'];
                        ?>
                        <div class="tabs_sale_block__content <?=($i == 0)?'active ':''?>collection-id-<? echo $tabId?>">
                            <?
                            if (($i == 0) || ($isAjax != 'Y'))
                            {
                                $APPLICATION->IncludeComponent("bitrix:catalog.section",
                                    $arParams['SECTION_TEMPLATE'],
                                    Array(
                                        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                                        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                                        "CACHE_TIME" => $arParams["CACHE_TIME"],
                                        "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                                        "DISPLAY_TOP_PAGER" => $arParams['DISPLAY_TOP_PAGER'],
                                        "DISPLAY_BOTTOM_PAGER" => $arParams['DISPLAY_BOTTOM_PAGER'],
                                        "SHOW_ALL_WO_SECTION" => "Y",
                                        "ELEMENT_SORT_FIELD" => $crosssell["SORT_BY"],
                                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                                        "ELEMENT_SORT_ORDER" => $crosssell["SORT_ORDER"],
                                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                                        "FILTER_NAME" => $arParams["FILTER_NAME"],
                                        "USE_FILTER" => 'Y',
                                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "ITEM_TEMPLATE" => $crosssell['ITEM_TEMPLATE'],
                                        "LABEL_PROP" => $arParams["LABEL_PROP"],
                                        "LINE_ELEMENT_COUNT" => $arParams['LINE_ELEMENT_COUNT'],
                                        "PAGE_ELEMENT_COUNT" => $crosssell['PRODUCT_NUMBER'],
                                        "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                                        "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                                        "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                                        "AJAX_MODE" => $arParams['AJAX_MODE'],
                                        "AJAX_OPTION_ADDITIONAL" => $arParams['AJAX_OPTION_ADDITIONAL'],
                                        "AJAX_OPTION_HISTORY" => $arParams['AJAX_OPTION_HISTORY'],
                                        "AJAX_OPTION_JUMP" => $arParams['AJAX_OPTION_JUMP'],
                                        "AJAX_OPTION_STYLE" => $arParams['AJAX_OPTION_STYLE'],
                                        "BACKGROUND_IMAGE" => $arParams['BACKGROUND_IMAGE'],
                                        "BASKET_URL" => $arParams['BASKET_URL'],
                                        "BROWSER_TITLE" => $arParams['BROWSER_TITLE'],
                                        "COMPATIBLE_MODE" => $arParams['COMPATIBLE_MODE'],
                                        "CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
                                        "DETAIL_URL" => $arParams['DETAIL_URL'],
                                        "DISABLE_INIT_JS_IN_COMPONENT" => $arParams['DISABLE_INIT_JS_IN_COMPONENT'],
                                        "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                                        "ENLARGE_PRODUCT" => $arParams['ENLARGE_PRODUCT'],
                                        "HIDE_NOT_AVAILABLE" => $arParams['HIDE_NOT_AVAILABLE'],
                                        "HIDE_NOT_AVAILABLE_OFFERS" => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
                                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                        "LAZY_LOAD" => $arParams['LAZY_LOAD'],
                                        "LOAD_ON_SCROLL" => $arParams['LOAD_ON_SCROLL'],
                                        "MESSAGE_404" => $arParams['MESSAGE_404'],
                                        "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                                        "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                                        "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                                        "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                                        "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                                        "META_DESCRIPTION" => $arParams['META_DESCRIPTION'],
                                        "META_KEYWORDS" => $arParams['META_KEYWORDS'],
                                        "OFFERS_LIMIT" => $arParams['OFFERS_LIMIT'],
                                        "PAGER_BASE_LINK_ENABLE" => $arParams['PAGER_BASE_LINK_ENABLE'],
                                        "PAGER_DESC_NUMBERING" => $arParams['PAGER_DESC_NUMBERING'],
                                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                                        "PAGER_SHOW_ALL" => $arParams['PAGER_SHOW_ALL'],
                                        "PAGER_SHOW_ALWAYS" => $arParams['PAGER_SHOW_ALWAYS'],
                                        "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
                                        "PAGER_TITLE" => $arParams['PAGER_TITLE'],
                                        "PARTIAL_PRODUCT_PROPERTIES" => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                                        "PRICE_CODE" => $arParams['PRICE_CODE'],
                                        "PRICE_VAT_INCLUDE" => $arParams['PRICE_VAT_INCLUDE'],
                                        "PRODUCT_BLOCKS_ORDER" => $arParams['PRODUCT_BLOCKS_ORDER'],
                                        "PRODUCT_ID_VARIABLE" => $arParams['PRODUCT_ID_VARIABLE'],
                                        "PRODUCT_PROPERTIES" => $arParams['PRODUCT_PROPERTIES'],
                                        "PRODUCT_PROPS_VARIABLE" => $arParams['PRODUCT_PROPS_VARIABLE'],
                                        "PRODUCT_QUANTITY_VARIABLE" => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                                        "PRODUCT_ROW_VARIANTS" => $arParams['PRODUCT_ROW_VARIANTS'],
                                        "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
                                        "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
                                        "RCM_PROD_ID" => $arParams['RCM_PROD_ID'],
                                        "RCM_TYPE" => $arParams['RCM_TYPE'],
                                        "SEF_MODE" => $arParams['SEF_MODE'],
                                        "SET_BROWSER_TITLE" => $arParams['SET_BROWSER_TITLE'],
                                        "SET_LAST_MODIFIED" => $arParams['PRODUCT_PROPS_VARIABLE'],
                                        "SET_META_DESCRIPTION" => $arParams['SET_META_DESCRIPTION'],
                                        "SET_META_KEYWORDS" => $arParams['SET_META_KEYWORDS'],
                                        "SET_STATUS_404" => $arParams['SET_STATUS_404'],
                                        "SET_TITLE" => $arParams['SET_TITLE'],
                                        "SHOW_404" => $arParams['SHOW_404'],
                                        "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                                        "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                                        "SHOW_FROM_SECTION" => $arParams['SHOW_FROM_SECTION'],
                                        "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                                        "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                                        "SHOW_PRICE_COUNT" => $arParams['SHOW_PRICE_COUNT'],
                                        "SHOW_SLIDER" => $arParams['SHOW_SLIDER'],
                                        "TEMPLATE_THEME" => $arParams['TEMPLATE_THEME'],
                                        "USE_ENHANCED_ECOMMERCE" => $arParams['USE_ENHANCED_ECOMMERCE'],
                                        "USE_MAIN_ELEMENT_SECTION" => $arParams['USE_MAIN_ELEMENT_SECTION'],
                                        "USE_PRICE_COUNT" => $arParams['USE_PRICE_COUNT'],
                                        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                                    ),
                                    $component
                                );
                            }
                            ?>
                        </div>
                        <?
                        $i++;
                    }
                }
                ?>
            </div>
        </section>
        <?
        $componentPath = $arResult['COMPONENT_PATH'];
        ?>
        <script>
            $( document ).ready(function() {
                $('ul#crosssells').on('click', 'li:not(.active)', function () {
                    if (!$(this).hasClass("collection-loaded")){
                        getCrosssell($(this).data("collection-id"));
                    }
                    $(this)
                        .addClass('active').siblings().removeClass('active')
                        .closest('.catalog_section_block_tabs').find('.tabs_sale_block__content').removeClass('active').eq($(this).index()).addClass('active');
                });
            });
            function getCrosssell(crosssellId){
                var crosssellTab = $('.collection-id-'+crosssellId);
                createLoadersMore(crosssellTab);
                $.ajax({
                    url: <?= CUtil::PhpToJSObject($componentPath, false, true) ?> + '/ajax.php' + (document.location.href.indexOf('clear_cache=Y') !== -1 ? '?clear_cache=Y' : ''),
                    method: 'POST',
                    dataType: 'html',
                    timeout: 3000,
                    data: {
                        params : <?=CUtil::PhpToJSObject($arParams, false, true)?>,
                        crosssellId: crosssellId,
                        crosssellArray: <?=CUtil::PhpToJSObject($arResult['CROSSSELL_ARRAY'], false, true)?>
                    },
                    success: function (result) {
                        removeLoadersMore(crosssellTab);
                        crosssellTab.html(result).html(result);
                        if (!crosssellTab.hasClass("collection-loaded")){
                            $('li.collection-' + crosssellId).addClass("collection-loaded");
                        }
                    },
                    error: function (result) {
                        removeLoadersMore(crosssellTab);
                        $('.collection-id-'+crosssellId).html(<?= CUtil::PhpToJSObject(GetMessage("LOADING_ERROR"), false, true) ?>);
                    }
                });
            }
        </script>

        <?
    } else {
        foreach ($arResult['CROSSSELL_ARRAY'] as $crosssell)
        {
            ${$arParams["FILTER_NAME"]} = $crosssell['FILTER'];
            ?>
            <h2><?= $crosssell['NAME'] ?></h2>
            <?
            if ($arResult['SAFE'])
            {
                $APPLICATION->IncludeComponent("bitrix:catalog.section",
                    $arParams['SECTION_TEMPLATE'],
                    Array(
                        "CACHE_FILTER" => $arParams['CACHE_FILTER'],
                        "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        "DISPLAY_TOP_PAGER" => $arParams['DISPLAY_TOP_PAGER'],
                        "DISPLAY_BOTTOM_PAGER" => $arParams['DISPLAY_BOTTOM_PAGER'],
                        "SHOW_ALL_WO_SECTION" => "Y",
                        "ELEMENT_SORT_FIELD" => $crosssell["SORT_BY"],
                        "ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
                        "ELEMENT_SORT_ORDER" => $crosssell["SORT_ORDER"],
                        "ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
                        "FILTER_NAME" => $arParams['FILTER_NAME'],
                        "USE_FILTER" => 'Y',
                        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "LABEL_PROP" => $arParams['LABEL_PROP'],
                        "LINE_ELEMENT_COUNT" => $arParams['LINE_ELEMENT_COUNT'],
                        "PAGE_ELEMENT_COUNT" => $crosssell['PRODUCT_NUMBER'],
                        "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                        "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                        "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                        "AJAX_MODE" => $arParams['AJAX_MODE'],
                        "AJAX_OPTION_ADDITIONAL" => $arParams['AJAX_OPTION_ADDITIONAL'],
                        "AJAX_OPTION_HISTORY" => $arParams['AJAX_OPTION_HISTORY'],
                        "AJAX_OPTION_JUMP" => $arParams['AJAX_OPTION_JUMP'],
                        "AJAX_OPTION_STYLE" => $arParams['AJAX_OPTION_STYLE'],
                        "BACKGROUND_IMAGE" => $arParams['BACKGROUND_IMAGE'],
                        "BASKET_URL" => $arParams['BASKET_URL'],
                        "BROWSER_TITLE" => $arParams['BROWSER_TITLE'],
                        "COMPATIBLE_MODE" => $arParams['COMPATIBLE_MODE'],
                        "CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
                        "DETAIL_URL" => $arParams['DETAIL_URL'],
                        "DISABLE_INIT_JS_IN_COMPONENT" => $arParams['DISABLE_INIT_JS_IN_COMPONENT'],
                        "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                        "ENLARGE_PRODUCT" => $arParams['ENLARGE_PRODUCT'],
                        "HIDE_NOT_AVAILABLE" => $arParams['HIDE_NOT_AVAILABLE'],
                        "HIDE_NOT_AVAILABLE_OFFERS" => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
                        "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                        "LAZY_LOAD" => $arParams['LAZY_LOAD'],
                        "LOAD_ON_SCROLL" => $arParams['LOAD_ON_SCROLL'],
                        "MESSAGE_404" => $arParams['MESSAGE_404'],
                        "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                        "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                        "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                        "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                        "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                        "META_DESCRIPTION" => $arParams['META_DESCRIPTION'],
                        "META_KEYWORDS" => $arParams['META_KEYWORDS'],
                        "OFFERS_LIMIT" => $arParams['OFFERS_LIMIT'],
                        "PAGER_BASE_LINK_ENABLE" => $arParams['PAGER_BASE_LINK_ENABLE'],
                        "PAGER_DESC_NUMBERING" => $arParams['PAGER_DESC_NUMBERING'],
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                        "PAGER_SHOW_ALL" => $arParams['PAGER_SHOW_ALL'],
                        "PAGER_SHOW_ALWAYS" => $arParams['PAGER_SHOW_ALWAYS'],
                        "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
                        "PAGER_TITLE" => $arParams['PAGER_TITLE'],
                        "PARTIAL_PRODUCT_PROPERTIES" => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                        "PRICE_CODE" => $arParams['PRICE_CODE'],
                        "PRICE_VAT_INCLUDE" => $arParams['PRICE_VAT_INCLUDE'],
                        "PRODUCT_BLOCKS_ORDER" => $arParams['PRODUCT_BLOCKS_ORDER'],
                        "PRODUCT_ID_VARIABLE" => $arParams['PRODUCT_ID_VARIABLE'],
                        "PRODUCT_PROPERTIES" => $arParams['PRODUCT_PROPERTIES'],
                        "PRODUCT_PROPS_VARIABLE" => $arParams['PRODUCT_PROPS_VARIABLE'],
                        "PRODUCT_QUANTITY_VARIABLE" => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                        "PRODUCT_ROW_VARIANTS" => $arParams['PRODUCT_ROW_VARIANTS'],
                        "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
                        "PROPERTY_CODE" => $arParams['PROPERTY_CODE'],
                        "RCM_PROD_ID" => $arParams['RCM_PROD_ID'],
                        "RCM_TYPE" => $arParams['RCM_TYPE'],
                        "SEF_MODE" => $arParams['SEF_MODE'],
                        "SET_BROWSER_TITLE" => $arParams['SET_BROWSER_TITLE'],
                        "SET_LAST_MODIFIED" => $arParams['PRODUCT_PROPS_VARIABLE'],
                        "SET_META_DESCRIPTION" => $arParams['SET_META_DESCRIPTION'],
                        "SET_META_KEYWORDS" => $arParams['SET_META_KEYWORDS'],
                        "SET_STATUS_404" => $arParams['SET_STATUS_404'],
                        "SET_TITLE" => $arParams['SET_TITLE'],
                        "SHOW_404" => $arParams['SHOW_404'],
                        "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                        "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                        "SHOW_FROM_SECTION" => $arParams['SHOW_FROM_SECTION'],
                        "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                        "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                        "SHOW_PRICE_COUNT" => $arParams['SHOW_PRICE_COUNT'],
                        "SHOW_SLIDER" => $arParams['SHOW_SLIDER'],
                        "TEMPLATE_THEME" => $arParams['TEMPLATE_THEME'],
                        "USE_ENHANCED_ECOMMERCE" => $arParams['USE_ENHANCED_ECOMMERCE'],
                        "USE_MAIN_ELEMENT_SECTION" => $arParams['USE_MAIN_ELEMENT_SECTION'],
                        "USE_PRICE_COUNT" => $arParams['USE_PRICE_COUNT'],
                        "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
                    ),
                    $component
                );

            }
        }
    }
} else {
    //standard behavior (if called not section mode)
    ${$arParams["FILTER_NAME"]} = $arResult['arFilter'];

    $iblockId = $arResult['IBLOCK_ID'];
    ?>
    <h2><?= $arResult['COND_NAME'] ?></h2>
    <?
    if ($arResult['SAFE'])
    {
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            $arParams['SECTION_TEMPLATE'],
            Array(
                "CACHE_FILTER" => $arParams['CACHE_FILTER'],
                "CACHE_GROUPS" => $arParams['CACHE_GROUPS'],
                "CACHE_TIME" => $arParams['CACHE_TIME'],
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                "DISPLAY_TOP_PAGER" => $arParams['DISPLAY_TOP_PAGER'],
                "DISPLAY_BOTTOM_PAGER" => $arParams['DISPLAY_BOTTOM_PAGER'],
                "SHOW_ALL_WO_SECTION" => 'Y',
                "ELEMENT_SORT_FIELD" => $arResult['SORT_BY'],
                "ELEMENT_SORT_FIELD2" => $arParams['ELEMENT_SORT_FIELD2'],
                "ELEMENT_SORT_ORDER" => $arResult['SORT_ORDER'],
                "ELEMENT_SORT_ORDER2" => $arParams['ELEMENT_SORT_ORDER2'],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "USE_FILTER" => 'Y',
                "IBLOCK_ID" => $arResult['IBLOCK_ID'],
                "INCLUDE_SUBSECTIONS" => "Y",
                "LABEL_PROP" => $arParams["LABEL_PROP"],
                "LINE_ELEMENT_COUNT" => $arParams['LINE_ELEMENT_COUNT'],
                "PAGE_ELEMENT_COUNT" => $arResult['NUMBER_OF_PRODUCTS'],
                "ADD_PROPERTIES_TO_BASKET" => $arParams['ADD_PROPERTIES_TO_BASKET'],
                "ADD_SECTIONS_CHAIN" => $arParams['ADD_SECTIONS_CHAIN'],
                "ADD_TO_BASKET_ACTION" => $arParams['ADD_TO_BASKET_ACTION'],
                "AJAX_MODE" => $arParams['AJAX_MODE'],
                "AJAX_OPTION_ADDITIONAL" => $arParams['AJAX_OPTION_ADDITIONAL'],
                "AJAX_OPTION_HISTORY" => $arParams['AJAX_OPTION_HISTORY'],
                "AJAX_OPTION_JUMP" => $arParams['AJAX_OPTION_JUMP'],
                "AJAX_OPTION_STYLE" => $arParams['AJAX_OPTION_STYLE'],
                "BACKGROUND_IMAGE" => $arParams['BACKGROUND_IMAGE'],
                "BASKET_URL" => $arParams['BASKET_URL'],
                "BROWSER_TITLE" => $arParams['BROWSER_TITLE'],
                "COMPATIBLE_MODE" => $arParams['COMPATIBLE_MODE'],
                "CONVERT_CURRENCY" => $arParams['CONVERT_CURRENCY'],
                "DETAIL_URL" => $arParams['DETAIL_URL'],
                "DISABLE_INIT_JS_IN_COMPONENT" => $arParams['DISABLE_INIT_JS_IN_COMPONENT'],
                "DISPLAY_COMPARE" => $arParams['DISPLAY_COMPARE'],
                "ENLARGE_PRODUCT" => $arParams['ENLARGE_PRODUCT'],
                "HIDE_NOT_AVAILABLE" => $arParams['HIDE_NOT_AVAILABLE'],
                "HIDE_NOT_AVAILABLE_OFFERS" => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                "ITEM_TEMPLATE" => $arParams['ITEM_TEMPLATE'],
                "LAZY_LOAD" => $arParams['LAZY_LOAD'],
                "LOAD_ON_SCROLL" => $arParams['LOAD_ON_SCROLL'],
                "MESSAGE_404" => $arParams['MESSAGE_404'],
                "MESS_BTN_ADD_TO_BASKET" => $arParams['MESS_BTN_ADD_TO_BASKET'],
                "MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
                "MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
                "MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
                "MESS_NOT_AVAILABLE" => $arParams['MESS_NOT_AVAILABLE'],
                "META_DESCRIPTION" => $arParams['META_DESCRIPTION'],
                "META_KEYWORDS" => $arParams['META_KEYWORDS'],
                "OFFERS_LIMIT" => $arParams['OFFERS_LIMIT'],
                "PAGER_BASE_LINK_ENABLE" => $arParams['PAGER_BASE_LINK_ENABLE'],
                "PAGER_DESC_NUMBERING" => $arParams['PAGER_DESC_NUMBERING'],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams['PAGER_DESC_NUMBERING_CACHE_TIME'],
                "PAGER_SHOW_ALL" => $arParams['PAGER_SHOW_ALL'],
                "PAGER_SHOW_ALWAYS" => $arParams['PAGER_SHOW_ALWAYS'],
                "PAGER_TEMPLATE" => $arParams['PAGER_TEMPLATE'],
                "PAGER_TITLE" => $arParams['PAGER_TITLE'],
                "PARTIAL_PRODUCT_PROPERTIES" => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                "PRICE_CODE" => $arParams['PRICE_CODE'],
                "PRICE_VAT_INCLUDE" => $arParams['PRICE_VAT_INCLUDE'],
                "PRODUCT_BLOCKS_ORDER" => $arParams['PRODUCT_BLOCKS_ORDER'],
                "PRODUCT_ID_VARIABLE" => $arParams['PRODUCT_ID_VARIABLE'],
                "PRODUCT_PROPERTIES" => $arParams['PRODUCT_PROPERTIES'],
                "PRODUCT_PROPS_VARIABLE" => $arParams['PRODUCT_PROPS_VARIABLE'],
                "PRODUCT_QUANTITY_VARIABLE" => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                "PRODUCT_ROW_VARIANTS" => $arParams['PRODUCT_ROW_VARIANTS'],
                "PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
                "RCM_PROD_ID" => $arParams['RCM_PROD_ID'],
                "RCM_TYPE" => $arParams['RCM_TYPE'],
                "SEF_MODE" => $arParams['SEF_MODE'],
                "SET_BROWSER_TITLE" => $arParams['SET_BROWSER_TITLE'],
                "SET_LAST_MODIFIED" => $arParams['PRODUCT_PROPS_VARIABLE'],
                "SET_META_DESCRIPTION" => $arParams['SET_META_DESCRIPTION'],
                "SET_META_KEYWORDS" => $arParams['SET_META_KEYWORDS'],
                "SET_STATUS_404" => $arParams['SET_STATUS_404'],
                "SET_TITLE" => $arParams['SET_TITLE'],
                "SHOW_404" => $arParams['SHOW_404'],
                "SHOW_CLOSE_POPUP" => $arParams['SHOW_CLOSE_POPUP'],
                "SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
                "SHOW_FROM_SECTION" => $arParams['SHOW_FROM_SECTION'],
                "SHOW_MAX_QUANTITY" => $arParams['SHOW_MAX_QUANTITY'],
                "SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
                "SHOW_PRICE_COUNT" => $arParams['SHOW_PRICE_COUNT'],
                "SHOW_SLIDER" => $arParams['SHOW_SLIDER'],
                "TEMPLATE_THEME" => $arParams['TEMPLATE_THEME'],
                "USE_ENHANCED_ECOMMERCE" => $arParams['USE_ENHANCED_ECOMMERCE'],
                "USE_MAIN_ELEMENT_SECTION" => $arParams['USE_MAIN_ELEMENT_SECTION'],
                "USE_PRICE_COUNT" => $arParams['USE_PRICE_COUNT'],
                "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            ),
            $component
        );

    }

}

