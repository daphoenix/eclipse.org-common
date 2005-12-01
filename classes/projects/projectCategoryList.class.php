<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/classes/projects/projectCategory.class.php");
require_once("/home/data/httpd/eclipse-php-classes/system/dbconnection.class.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/app.class.php");

class ProjectCategoryList {

	#*****************************************************************************
	#
	# projectCategoryList.class.php
	#
	# Author: 	Denis Roy
	# Date:		2005-10-25
	#
	# Description: Functions and modules related Lists of projectCategories
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

	function selectProjectCategoryList($_project_id, $_category_id, $_order_by) {
		
		$App = new App();
	    $WHERE = "";
	
	    if($_project_id != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRC.project_id = " . $App->returnQuotedString($_project_id);
	    }
	    if($_category_id != "") {
	            $WHERE = $App->addAndIfNotNull($WHERE);
	            $WHERE .= " PRC.category_id = " . $App->returnQuotedString($_category_id);
	    }
	
	    if($WHERE != "") {
	            $WHERE = " WHERE " . $WHERE;
	    }
	
	    if($_order_by == "") {
	            $_order_by = "PRC.description";
	    }
	
	    $_order_by = " ORDER BY " . $_order_by;
		
	    $sql = "SELECT 
					PRC.project_id,
					PRC.category_id, 
					PRC.description AS ProjectCategoryDescription,
					PRJ.name,
					PRJ.level,
					PRJ.parent_project_id,
					PRJ.description,
					PRJ.url_download,
					PRJ.url_index,
					PRJ.is_topframe,
					CAT.description AS CategoryDescription,
					CAT.image_name
	        	FROM
					project_categories 		AS PRC 
					INNER JOIN projects 	AS PRJ ON PRJ.project_id = PRC.project_id
					INNER JOIN categories 	AS CAT ON CAT.category_id = PRC.category_id "
				. $WHERE
				. $_order_by;

	    $dbc = new DBConnection();
	    $dbh = $dbc->connect();
	
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
				
				$Category = new Category();
				$Category->setCategoryID	($myrow["category_id"]);
				$Category->setDescription	($myrow["CategoryDescription"]);
				$Category->setImageName		($myrow["image_name"]);
				
				$ProjectCategory = new ProjectCategory();
				$ProjectCategory->setProjectID	($myrow["project_id"]);
				$ProjectCategory->setCategoryID	($myrow["category_id"]);
				$ProjectCategory->setDescription($myrow["ProjectCategoryDescription"]);
				$ProjectCategory->setProjectObject($Project);
				$ProjectCategory->setCategoryObject($Category);
				

	            $this->add($ProjectCategory);
	    }
	    
	    	
	    $dbc->disconnect();
	    $dbh 	= null;
	    $dbc 	= null;
	    $result = null;
	    $myrow	= null;
	}
}
?>
