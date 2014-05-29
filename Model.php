<?php
namespace Plugin\Sitemap;
class Model
{
    public static function generateHtml()
    {

        $menus = self::getMenus();

        $menuHtml = array();

        foreach ($menus as $menu){

            $slotHtml = ipSlot('menu', $menu['alias']);

            if ($slotHtml && $menu['title']){
                $menuItem['title'] = $menu['title'];
                $menuItem['html'] = $slotHtml;
                $menuHtml[] = $menuItem;
            }

        }

        $data['menus'] = $menuHtml;

        $html = ipView('view/sitemap.php', $data)->render();

        return $html;
    }

    private static function getMenuAliases()
    {

        $cfgMenuString = ipGetOption('Sitemap.menuList');
        if ($cfgMenuString){
            $menus = preg_split( "/[\s,]+/", $cfgMenuString );

        }else{

            $currLanguage = ipContent()->getCurrentLanguage()->getCode();
            $menusObj = \Ip\Internal\Pages\Service::getMenus($currLanguage );

            $menus = array();
            foreach ($menusObj as $menuObj){
                $menus[] = $menuObj['alias'];
            }

        }

        return $menus;
    }

    public static function getMenus(){

        $menuAliases = self::getMenuAliases();

        $currLangCode = ipContent()->getCurrentLanguage()->getCode();
        if (!empty($menuAliases)){

            $menuPages = Array();

            foreach ($menuAliases as $menuAlias){

                $menuRec = ipDb()->selectAll('page', 'id, title, alias', array('isDeleted' => 0, 'alias'=>$menuAlias,  'parentId' => 0, 'isDisabled' => 0, 'isSecured' => 0, 'languageCode' => $currLangCode), 'ORDER BY `pageOrder`');

                if (!empty($menuRec)){
                    $menuPages = array_merge($menuPages, $menuRec);
                }
            }
        }else{
            $menuPages = ipDb()->selectAll('page', 'id, title, alias', array('isDeleted' => 0, 'alias'=>$menuAlias,  'parentId' => 0, 'isDisabled' => 0, 'isSecured' => 0, 'languageCode' => $currLangCode), 'ORDER BY `pageOrder`');
        }


        return $menuPages;
    }



    public static function getPageUrl($pageId)
    {
        return ipPage($pageId)->getLink();
    }


}