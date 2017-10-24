<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace ratingallocate\lp\executors\webservice;

class backend
{
    private $local_path = '';
    private $secret = null;

    /**
     * Creates a webservice backend
     *
     * @param $secret Secret used for backend protection
     * @param $local_path Local path where a temporary lp file is stored
     *
     * @return Webservice backend instance
     */
    public function __construct($secret, $local_path) {
        $this->secret = $secret;
        $this->local_path = $local_path;
    }

    /**
     * Returns the webservice secret
     *
     * @return Webservice secret
     */
    public function get_secret() {
        return $this->secret;
    }

    /**
     * Returns the local path
     *
     * @return Local path
     */
    public function get_local_path() {
        return $this->local_path;
    }
    
    /**
     * Returns the content of the LP file
     *
     * @return LP file content
     */
    public function get_lp_file() {
        return $_POST['lp'];
    }
    
    /**
     * Handles an incomming request
     */
    public function main() {
        if(isset($_POST['lp'])) {
            $engine = new \ratingallocate\lp\engines\cplex();
            $executor = new \ratingallocate\lp\executors\local($engine, $this->local_path);
            
            fpassthru($executor->solve($this->get_lp_file()));
        }
        
    }
    
}