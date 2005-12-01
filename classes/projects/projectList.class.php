<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/classes/drops/drop.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/classes/projects/project.class.php");
require_once("/home/data/httpd/eclipse-php-classes/system/dbconnection.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/app.class.php");

class ProjectList {

	#*****************************************************************************
	#
	# projectList.class.php
	#
	# Author: 	Denis Roy
	# Date:		2004-11-16
	#
	# Description: Functions and modules related Lists of projects
	#
	# HISTORY:
	#
	#*****************************************************************************

	var $list = array();
	
	
	function getList() {
		return $this->$list;
	}
	function setList($_list) {
		$this->list = $_list;
	}


    function add($_project) {
            $this->list[count($this->list)] = $_project;
    }


    function getCount() {
            return count($this->list);
    }

    function getItemAt($_pos) {
            if($_pos < $this->getCount()) {
                    return $this->list[$_pos];
            }
    }

	function selectProjectList($_project_id, $_name, $_level, $_parent_project_id, $_description, $_order_by) {
		
		$App = new App();
	    $WHERE = "";
	
	    if($_project_id != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRJ.project_id = " . $App->returnQuotedString($_project_id);
	    }
	    if($_name != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRJ.name LIKE " . $App->returnQuotedString("%" . $_name . "%");
	
	    }
	    if($_level > 0) {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRJ.level = " . $_level;
	    }
	    if($_parent_project_id != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRJ.parent_project_id = " . $App->returnQuotedString($_parent_project_id);
	    }
	    if($_description != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRJ.description LIKE " . $App->returnQuotedString("%" . $_description . "%");
	
	    }
	
	    if($WHERE != "") {
	            $WHERE = " WHERE " . $WHERE;
	    }
	
	    if($_order_by == "") {
	            $_order_by = "PRJ.name";
	    }
	
	    $_order_by = " ORDER BY " . $_order_by;
	
	
	    $dbc = new DBConnection();
	    $dbh = $dbc->connect();
	
	    $sql = "SELECT 
					PRJ.project_id,
					PRJ.name,
					PRJ.level,
					PRJ.parent_project_id,
					PRJ.description,
					PRJ.url_download,
					PRJ.url_index,
					PRJ.is_topframe
	        	FROM
					projects AS PRJ "
				. $WHERE
				. $_order_by;
# echo $sql;	
	    $result = mysql_query($sql, $dbh);

	    while($myrow = mysql_fetch_array($result))
	    {
	    		
	            $Project 	= new Project();
	            $Project->setProjectID		($myrow["project_id"]);
	            $Project->setName			($myrow["name"]);
	            $Project->setLevel			($myrow["level"]);
	            $Project->setParentProjectID($myrow["parent_project_id"]);
	            $Project->setDescription	($myrow["description"]);
	    		$Project->setUrlDownload	($myrow["url_download"]);
	    		$Project->setUrlIndex		($myrow["url_index"]);
				$Project->setIsTopframe		($myrow["is_topframe"]);
	            $this->add($Project);
	    }
	    
	    	
	    $dbc->disconnect();
	    $dbh 	= null;
	    $dbc 	= null;
	    $result = null;
	    $myrow	= null;
	}
}
?>
