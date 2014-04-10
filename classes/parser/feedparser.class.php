<?php
/*******************************************************************************
 * Copyright (c) 2014 Eclipse Foundation and others.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://eclipse.org/legal/epl-v10.html
 *
 * Contributors:
 *    Christopher Guindon (Eclipse Foundation) - Initial implementation
 *******************************************************************************/

class FeedParser {

	private $url = "";

	private $count = 4;

	private $description = TRUE;

	private $press_release = FALSE;

	private $items = array();

	private $more = "";

	private $date_format = "Y/m/d";

	private $limit = 200;

	public function setUrl($url) {
	  $this->url = $url;
	}

	public function setCount($count) {
		if (is_int($count)) {
			$this->count = $count;
		}
	}

	public function setLimit($limit) {
		if (is_int($limit)) {
			$this->limit = $limit;
		}
	}

	public function setPressRelease($press_release = FALSE) {
		$this->press_release = ($press_release) ? TRUE : FALSE;
	}

	public function setDescription($show = TRUE) {
		$this->description = ($show) ? TRUE : FALSE;
	}

	public function setMore($url, $caption = 'View all', $prefix = '> ') {
		$this->more = $prefix . '<a href="' . $url . '">' . $caption . '</a>';
	}

	private function parse_feed() {

		if (empty($this->url)) {
			return FALSE;
		}

		$feed = simplexml_load_file($this->url);
		$feed_array = array();
		$count = 0;

		foreach($feed->channel->item as $item){

			if ($count >= $this->count) {
				break;
			}

			$date = strtotime((string) $item->pubDate);
			$date = date($this->date_format, $date);

			$description = (string) $item->description;
			if (strlen($description) > $this->limit) {
				$description = substr(strip_tags($description), 0, $this->limit);
				$description = strip_tags($description, "<a>");
				$description .= "...";
			}

			$item_array = array (
			  'title' => (string) $item->title,
				'description' => $description,
				'link' => (string) $item->link,
				'date' => $date,
			);

			array_push($feed_array, $item_array);
			$count++;
		}
		$this->items = $feed_array;
	}

	public function output() {
		$this->parse_feed();
		$output = "";

		if (!empty($this->items)) {
			foreach ($this->items as $item) {
				$output .= '<div class="news_item">';
				$output .= '<div class="news_item_date">' .$item['date'] . '</div>';
				$output .= '<div class="news_item_title">';
				$output .= '<h3><a href="' . $item['link'] . '">' . $item['title'] . '</a></h3>';
				$output .= '</div>';
				if ($this->description) {
					$output .= '<div class="news_item_description">' .$item['description'] . '</div>';
				}
				$output .= '</div>';
			}
			if (!empty($this->more)) {
				$output .= '<div class="news_view_all">' . $this->more . '</div>';
			}
		}
		print $output;
	}
}
