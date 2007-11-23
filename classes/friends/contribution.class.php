<?php
/*******************************************************************************
 * Copyright (c) 2007 Eclipse Foundation and others.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Nathan Gervais (Eclipse Foundation)- initial API and implementation
 *******************************************************************************/
require_once($_SERVER['DOCUMENT_ROOT'] . "/eclipse.org-common/system/smartconnection.class.php");
require_once("/home/data/httpd/eclipse-php-classes/system/dbconnection_rw.class.php");

class Contribution {
	
	private $friend_id = "";
	private $contribution_id = "";
	private $date_expired = NULL;
	private $amount = "";
	private $message = "";
	private $transaction_id = "";
	
	function getFriendID(){
		return $this->friend_id;
	}
	function getContributionID(){
		return $this->contribution_id;
	}
	function getDateExpired(){
		return $this->date_expired;
	}
	function getAmount(){
		return $this->amount;
	}
	function getMessage(){
		return $this->message;
	}
	function getTransactionID(){
		return $this->transaction_id;
	}
	
	function setFriendID($_friend_id){
		$this->friend_id = $_friend_id;
	}
	function setContributionID($_contribution_id){
		$this->contribution_id = $_contribution_id;
	}
	function setDateExpired($_date_expired){
		$this->date_expired = $_date_expired;
	}
	function setAmount($_amount){
		$this->amount = $_amount;
	}
	function setMessage($_message){
		$this->message = $_message;
	}
	function setTransactionID($_transaction_id){
		$this->transaction_id = $_transaction_id;
	}
	
	function insertContribution(){
		$result = 0;
		$App = new App();
		$dbc = new DBConnectionRW();
		$dbh = $dbc->connect();
		
		if ($this->selectContributionExists($this->getTransactionID())){
			$result = -1;
		}
		else
		{
			if ($this->date_expired == NULL)
				$default_date_expired = "DATE_ADD(NOW(), INTERVAL 1 YEAR)";
			else
				$default_date_expired = $App->returnQuotedString($App->sqlSerialze($this->date_expired, $dbh));
			# insert
			$sql = "INSERT INTO friends_contributions (
					friend_id,
					contribution_id,
					date_expired,
					amount,
					message,
					transaction_id)
					VALUES (
					" . $App->returnQuotedString($App->sqlSerialze($this->getFriendID(), $dbh)) . ",
					" . $App->returnQuotedString($App->sqlSerialze($this->getContributionID(), $dbh)) . ",
					" . $default_date_expired . ",
					" . $App->returnQuotedString($App->sqlSerialze($this->getAmount(), $dbh)) . ",
					" . $App->returnQuotedString($App->sqlSerialze($this->getMessage(), $dbh)) . ",
					" . $App->returnQuotedString($App->sqlSerialze($this->getTransactionID(), $dbh)) . ")";
			mysql_query($sql, $dbh);
		}

		$dbc->disconnect();
		return $result;
	}
	
	function selectContributionExists($_transaction_id){
		$retVal = FALSE;
		if ($_transaction_id != "")
		{
			$App = new App();

			$dbc = new DBConnectionRW();
			$dbh = $dbc->connect();

			$sql = "SELECT transaction_id
					FROM friends_contributions
					WHERE transaction_id = " . $App->returnQuotedString($App->sqlSanitze($_transaction_id, $dbh));

			$result = mysql_query($sql, $dbh);
			if ($result)
			{	
				$myrow = mysql_fetch_array($result);
				if ($myrow['transaction_id'] == $_transaction_id)
				$retVal = TRUE;
			}

			$dbc->disconnect();

		}
		return $retVal;			
	}
	
	function selectContribution($_contribution_id)
	{
		if($_contribution_id != "")  {
			$App = new App();

			$dbc = new DBConnectionRW();
			$dbh = $dbc->connect();

			$sql = "SELECT friend_id,
							contribution_id,
							date_expired,
							amount,
							message,
							transaction,
					FROM friends_contributions 
					WHERE contribution_id = " . $App->returnQuotedString($App->sqlSanitize($_contribution_id, $dbh));

			$result = mysql_query($sql, $dbh);

			if ($myrow = mysql_fetch_array($result))	{
				$this->setFriendID			($myrow["friend_id"]);
				$this->setContributionID	($myrow["contribution_id"]);
				$this->setDateExpired		($myrow["date_expired"]);
				$this->setAmount			($myrow["amount"]);
				$this->setMessage			($myrow["message"]);
				$this->setTransactionID		($myrow["transaction_id"]);
			}
			$dbc->disconnect();
		}
	}
}