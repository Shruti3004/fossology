
<?php

/***********************************************************
 Copyright (C) 2008 Hewlett-Packard Development Company, L.P.

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 version 2 as published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License along
 with this program; if not, write to the Free Software Foundation, Inc.,
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 ***********************************************************/

/**
 * Given a fossology page, if there is a mini menu on it, parse it and
 * return it.
 *
 * @param string $page the xhtml page to parse
 *
 * @return assocative array with menu names as keys and links as values.
 * Can return an empty array indicating no mini menus found on the page.
 * Only menus with links are returned.
 *
 * @todo add in link fixups and adjust consumers
 *
 * @version "$Id$"
 *
 * Created on Aug 19, 2008
 */

//require_once ('../commonTestFuncs.php');

class parseMiniMenu
{
  public $page;

  function __construct($page)
  {
    if (empty ($page))
    {
      return (array ());
    }
    $this->page = $page;
  }
  function parseMiniMenu()
  {
    /* take the front part of the string off, this should leave only menus */
    $matches = preg_match("/.*?id='menu1html-..*?<small>(.*)/", $this->page, $menuList);
    /*
     * parse the menus.  The first menu in the list is ignored if it
     * doesn't have a link associated with it.
     */
    $matches = preg_match_all("/<a href='((.*?).*?)'.*?>(.*?)</", $menuList[1], $parsed, PREG_PATTERN_ORDER);
    //print "parsed is:"; print_r($parsed) . "\n";
    /*
     * if we have a match, the create return array, else return empty
     * array.
     */
    if ($matches > 0)
    {
      $numMenus = count($parsed[1]);
      $menus = array ();
      for ($i = 0; $i <= $numMenus -1; $i++)
      {
        $menus[$parsed[3][$i]] = $parsed[1][$i];
      }
      //print "menus after construct:\n"; print_r($menus) . "\n";
      return ($menus);
    } else
    {
      return (array ());
    }
  }
}
?>
