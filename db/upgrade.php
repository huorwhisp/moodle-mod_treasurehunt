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

/**
 * This file keeps track of upgrades to the treasurehunt module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_treasurehunt
 * @copyright  2015 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Execute treasurehunt upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_treasurehunt_upgrade($oldversion) {
    global $DB, $CFG;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2016052608) {

        // Define field grademethod,gradepenlocation and gradepenanswer.
        $table = new xmldb_table('treasurehunt');
        $field = new xmldb_field('grademethod', XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 1);


        // Add grademethod if not exists.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('gradepenlocation', XMLDB_TYPE_NUMBER, '10,5', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 0);
        // Add gradepenlocation if not exists.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        $field = new xmldb_field('gradepenanswer', XMLDB_TYPE_NUMBER, '10,5', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 0);
        // Add gradepenanswer if not exists.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Quiz savepoint reached.
        upgrade_mod_savepoint(true, 2016052608, 'treasurehunt');
    }


    /* Finally, return of upgrade result (true, all went good) to Moodle.
     */
    return true;
}
