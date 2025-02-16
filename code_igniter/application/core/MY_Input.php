<?php  if (!defined('BASEPATH')) {
     exit('No direct script access allowed');
 }
#
#  Copyright 2003-2015 Opmantek Limited (www.opmantek.com)
#
#  ALL CODE MODIFICATIONS MUST BE SENT TO CODE@OPMANTEK.COM
#
#  This file is part of Open-AudIT.
#
#  Open-AudIT is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as published
#  by the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  Open-AudIT is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
#
#  You should have received a copy of the GNU Affero General Public License
#  along with Open-AudIT (most likely in a file named LICENSE).
#  If not, see <http://www.gnu.org/licenses/>
#
#  For further information on Open-AudIT or for a license other than AGPL please see
#  www.opmantek.com or email contact@opmantek.com
#
# *****************************************************************************

/*
* @category  Controller
* @package   Open-AudIT
* @author    Mark Unwin <marku@opmantek.com>
* @copyright 2014 Opmantek
* @license   http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
* @version   GIT: Open-AudIT_4.3.0
* @link      http://www.open-audit.org
 */

class MY_Input extends CI_Input {

    public function __construct() {
        // make a clone of the raw post data
        $this->_POST_RAW = $_POST;
        parent::__construct();
    }

    function _clean_input_keys($str)
    {
        // Allow for a | in a variable name, think discoveries options open|filtered.
        if ( ! preg_match("/^[\|a-z0-9:_\/-]+$/i", $str))
        {
            exit('Disallowed Key Characters in ' . htmlentities($str));
        }

        // Clean UTF-8 if supported
        if (UTF8_ENABLED === TRUE)
        {
            $str = $this->uni->clean_string($str);
        }

        return $str;
    }

    public function post($index = null, $xss_clean = true) {
        if (!$xss_clean) {
            // if asked for raw post data (eg. post('key', false) ) return the raw data.
            // this is required for raw password strings that we need to output to the command line
            // escaping these strings when they have unusual characters will break the funciton
            return $this->_POST_RAW[$index];
        }
        return parent::post($index, $xss_clean);
    }
}
?>