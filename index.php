<?php
/**
 * GoToWebinar module view file
 *
 * @package mod_gotomeeting
 * @copyright 2017 Alok Kumar Rai <alokr.mail@gmail.com,alokkumarrai@outlook.in>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('./../../config.php');
require_once('./lib.php');

$id = required_param('id', PARAM_INT);
$PAGE->set_url('/mod/gotomeeting/index.php', ['id' => $id]);
redirect(new moodle_url('/course/view.php', ['id' => $id]));