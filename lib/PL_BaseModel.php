<?php

class PL_BaseModel {

	public function __construct() {

		global $wpdb;

		$this->db = $wpdb;

	}

}