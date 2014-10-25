<?php

/**
 * Pagination class makes list table string with support of paging.
 *
 * @version 1.17
 * @author MPI
 *
 */
class Pagination{
    /**
     * @optional
     * @default System::PAGE_SIZE_DEFAULT
     * */
    const KEY_CONFIG_PAGE_SIZE = 1;
    /**
     * @optional
     * @default System::SORT_DEFAULT_COLUMN
     * */
    const KEY_CONFIG_COLUMN = 2;
    /**
     * @optional
     * @default System::PAGE_ACTUAL_DEFAULT
     * */
    const KEY_CONFIG_PAGE = 3;
    /**
     * @optional
     * @default System::SORT_DEFAULT_DIRECTION
     * */
    const KEY_CONFIG_SORT_DIRECTION = 4;
    /**
     * @optional
     * @default System::DATA_COUNT_DEFAULT
     * */
    const KEY_CONFIG_DATA_COUNT = 5;
    /**
     * @optional
     * @default 0
     * */
    const KEY_CONFIG_PAGES_COUNT = 6;
    /**
     * @optional
     * @default false
     * */
    const KEY_CONFIG_DISABLE_ROW_MENU = 7;
    /**
     * @optional
     * @default false
     * */
    const KEY_CONFIG_DISABLE_SELECT_ACTION = 8;
    /**
     * @optional
     * @default false
     * */
    const KEY_CONFIG_DISABLE_PAGINATION = 9;
    /**
     * @optional
     * @default false
     * */
    const KEY_CONFIG_DISABLE_SET_PAGE_SIZE = 10;
    /**
     * @optional
     * @default base-url{=$_SERVER["REQUEST_URI"] (to last /, without QS)}-%d-%d-%s
     * */
    const KEY_URL_PAGE = 30;
    /**
     * @optional
     * @default base-url{=$_SERVER["REQUEST_URI"] (to last /, without QS)}-%d-%d-%s
     * */
    const KEY_URL_HEADER_SORT = 31;
    /**
     * @optional
     * @default base-url{=$_SERVER["REQUEST_URI"] (to last /, without QS)}
     * */
    const KEY_URL_FORM_ACTION = 32;
    /**
     * @optional
     * @default null; may contains array with following *ITEM* indexes
     * */
    const KEY_ROW_MENU = 50;
    /**
     * @optional in ROW_MENU_ITEM
     * @default empty string
     * */
    const KEY_ROW_MENU_ITEM_BODY = 51;
    /**
     * @optional in ROW_MENU_ITEM
     * @default empty string
     * */
    const KEY_ROW_MENU_ITEM_TITLE = 52;
    /**
     * @optional in ROW_MENU_ITEM
     * @default empty string
     * */
    const KEY_ROW_MENU_ITEM_URL = 53;
    /**
     * @optional in ROW_MENU_ITEM
     * @default empty string
     * */
    const KEY_ROW_MENU_ITEM_CLASS = 54;
    /**
     * @optional
     * @default null; may contains array with following indexes
     * */
    const KEY_SELECT_ACTION = 70;
    /**
     * @optional in SELECT_ACTION_ITEM
     * @default empty string
     * */
    const KEY_SELECT_ACTION_VALUE = 71;
    /**
     * @optional in SELECT_ACTION_ITEM
     * @default empty string
     * */
    const KEY_SELECT_ACTION_TITLE = 72;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_TABLE_ID = 100;
    /**
     * @optional
     * @default table
     * */
    const KEY_STYLE_TABLE_CLASS = 101;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_TABLE_HEADER_CLASS = 102;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_TABLE_MARKED_ROW_CLASS = 103;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_SUMMARY_BOX_ID = 104;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_SUMMARY_BOX_CLASS = 105;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_PAGINATION_BOX_ID = 106;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_PAGINATION_BOX_CLASS = 107;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_PAGINATION_ACIVE_PAGE_CLASS = 108;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_SELECT_ACTION_ID = 109;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_SELECT_ACTION_CLASS = 110;
    /**
     * @optional
     * @default sel_action
     * */
    const KEY_STYLE_SELECT_ACTION_NAME = 111;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_PAGE_SIZE_BOX_ID = 112;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_PAGE_SIZE_BOX_CLASS = 113;
    /**
     * @optional
     * @default sel_page_size
     * */
    const KEY_STYLE_PAGE_SIZE_SELECT_NAME = 114;
    /**
     * @optional
     * @default empty string
     * */
    const KEY_STYLE_ROW_MENU_CLASS = 115;
    /**
     * @optional
     * @default empty-result-box
     * */
    const KEY_STYLE_EMPTY_RESULT_CLASS = 116;
    
    const COLUMN_PREFIX = "col_";
    const COLUMN_SELECT_ACTION_SUFFIX = "select";
    const ROW_PREFIX = "row_";
    
    private function __construct(){
    }
    
    /**
     * Get list table string on sorted data.
     *
     * @param array $header
     *        	1D with name of columns
     * @param array $data
     *        	2D with data to present
     * @param array $config
     *         array with defined keys
     *
     * @throws NoticeException
     * @return string
     */
    public static function generatePage($header, $data, $config){
        $config = self::validateConfig($config);
        //System::trace($config);
         
        // validation
        if((!empty($config[self::KEY_CONFIG_COLUMN]) && !empty($config[self::KEY_CONFIG_PAGE])) && (!array_key_exists($config[self::KEY_CONFIG_COLUMN], $header) || $config[self::KEY_CONFIG_PAGE] < System::PAGE_MIN_PAGE || $config[self::KEY_CONFIG_PAGE] > $config[self::KEY_CONFIG_PAGES_COUNT])){
            throw new NoticeException(NoticeException::NOTICE_INVALID_PARAMETERS);
        }
    
        if(!empty($header) && !empty($data) && $data != Database::EMPTY_RESULT && count($header) > 0 && count($data) > 0 && $config[self::KEY_CONFIG_DATA_COUNT] == count($data) && count($header) == count($data[0])){
            return self::makeListTableString($header, $data, $config);
        }else{
            return sprintf("<div class=\"%s\">%s</div>", $config[self::KEY_STYLE_EMPTY_RESULT_CLASS], Translate::get(Translator::NOTHING_TO_DISPLAY));
        }
    }
    
    /**
     * Get base url.
     *
     * @return string
     */
    public static function getBaseUrl(){
        return substr($_SERVER["REQUEST_URI"], 0, strrpos($_SERVER["REQUEST_URI"], "/") + 1);
    }
    
    /**
     * Validate config array.
     *
     * @param array $config
     *        	multidim array with defined keys
     *
     * @throws NoticeException
     * @return array
     */
    private static function validateConfig($config){
        // check required arguments
        if(empty($config)){
            throw new NoticeException(NoticeException::NOTICE_INVALID_PARAMETERS);
        }
        
        $base_url = self::getBaseUrl();
        
        // check optional arguments and set default values
        $config[self::KEY_CONFIG_PAGE_SIZE] = (isset($config[self::KEY_CONFIG_PAGE_SIZE]) && is_numeric($config[self::KEY_CONFIG_PAGE_SIZE])) ? $config[self::KEY_CONFIG_PAGE_SIZE] : System::PAGE_SIZE_DEFAULT;
        $config[self::KEY_CONFIG_PAGE] = (isset($config[self::KEY_CONFIG_PAGE]) && is_numeric($config[self::KEY_CONFIG_PAGE])) ? $config[self::KEY_CONFIG_PAGE] : System::PAGE_ACTUAL_DEFAULT;
        $config[self::KEY_CONFIG_COLUMN] = (isset($config[self::KEY_CONFIG_COLUMN]) && is_numeric($config[self::KEY_CONFIG_COLUMN])) ? $config[self::KEY_CONFIG_COLUMN] : System::SORT_DEFAULT_COLUMN;
        $config[self::KEY_CONFIG_SORT_DIRECTION] = (isset($config[self::KEY_CONFIG_SORT_DIRECTION]) && ($config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_ASC || $config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_DES)) ? $config[self::KEY_CONFIG_SORT_DIRECTION] : System::SORT_DEFAULT_DIRECTION;
        $config[self::KEY_CONFIG_DATA_COUNT] = (isset($config[self::KEY_CONFIG_DATA_COUNT]) && is_numeric($config[self::KEY_CONFIG_DATA_COUNT])) ? $config[self::KEY_CONFIG_DATA_COUNT] : System::DATA_COUNT_DEFAULT;
        $config[self::KEY_CONFIG_PAGES_COUNT] = (isset($config[self::KEY_CONFIG_PAGES_COUNT]) && is_numeric($config[self::KEY_CONFIG_PAGES_COUNT])) ? $config[self::KEY_CONFIG_PAGES_COUNT] : self::getCountPages($config[self::KEY_CONFIG_PAGE_SIZE], $config[self::KEY_CONFIG_DATA_COUNT]);
        $config[self::KEY_CONFIG_DISABLE_ROW_MENU] = (isset($config[self::KEY_CONFIG_DISABLE_ROW_MENU]) && is_bool($config[self::KEY_CONFIG_DISABLE_ROW_MENU])) ? $config[self::KEY_CONFIG_DISABLE_ROW_MENU] : false;
        $config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] = (isset($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION]) && is_bool($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION])) ? $config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] : false;
        $config[self::KEY_CONFIG_DISABLE_PAGINATION] = (isset($config[self::KEY_CONFIG_DISABLE_PAGINATION]) && is_bool($config[self::KEY_CONFIG_DISABLE_PAGINATION])) ? $config[self::KEY_CONFIG_DISABLE_PAGINATION] : false;
        $config[self::KEY_CONFIG_DISABLE_SET_PAGE_SIZE] = (isset($config[self::KEY_CONFIG_DISABLE_SET_PAGE_SIZE]) && is_bool($config[self::KEY_CONFIG_DISABLE_SET_PAGE_SIZE])) ? $config[self::KEY_CONFIG_DISABLE_SET_PAGE_SIZE] : false;
        
        $config[self::KEY_URL_PAGE] = (isset($config[self::KEY_URL_PAGE]) && !empty($config[self::KEY_URL_PAGE])) ? $config[self::KEY_URL_PAGE] : $base_url . "-%d-%d-%s";
        $config[self::KEY_URL_HEADER_SORT] = (isset($config[self::KEY_URL_HEADER_SORT]) && !empty($config[self::KEY_URL_HEADER_SORT])) ? $config[self::KEY_URL_HEADER_SORT] : $base_url . "-%d-%d-%s";
        $config[self::KEY_URL_FORM_ACTION] = (isset($config[self::KEY_URL_FORM_ACTION]) && !empty($config[self::KEY_URL_FORM_ACTION])) ? $config[self::KEY_URL_FORM_ACTION] : $base_url;
        
        $config[self::KEY_STYLE_TABLE_ID] = (isset($config[self::KEY_STYLE_TABLE_ID]) && !empty($config[self::KEY_STYLE_TABLE_ID])) ? $config[self::KEY_STYLE_TABLE_ID] : "";
        $config[self::KEY_STYLE_TABLE_CLASS] = (isset($config[self::KEY_STYLE_TABLE_CLASS]) && !empty($config[self::KEY_STYLE_TABLE_CLASS])) ? $config[self::KEY_STYLE_TABLE_CLASS] : "table";
        $config[self::KEY_STYLE_TABLE_HEADER_CLASS] = (isset($config[self::KEY_STYLE_TABLE_HEADER_CLASS]) && !empty($config[self::KEY_STYLE_TABLE_HEADER_CLASS])) ? $config[self::KEY_STYLE_TABLE_HEADER_CLASS] : "";
        $config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS] = (isset($config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS]) && !empty($config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS])) ? $config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS] : "";
        $config[self::KEY_STYLE_SUMMARY_BOX_ID] = (isset($config[self::KEY_STYLE_SUMMARY_BOX_ID]) && !empty($config[self::KEY_STYLE_SUMMARY_BOX_ID])) ? $config[self::KEY_STYLE_SUMMARY_BOX_ID] : "";
        $config[self::KEY_STYLE_SUMMARY_BOX_CLASS] = (isset($config[self::KEY_STYLE_SUMMARY_BOX_CLASS]) && !empty($config[self::KEY_STYLE_SUMMARY_BOX_CLASS])) ? $config[self::KEY_STYLE_SUMMARY_BOX_CLASS] : "";
        $config[self::KEY_STYLE_PAGINATION_BOX_ID] = (isset($config[self::KEY_STYLE_PAGINATION_BOX_ID]) && !empty($config[self::KEY_STYLE_PAGINATION_BOX_ID])) ? $config[self::KEY_STYLE_PAGINATION_BOX_ID] : "";
        $config[self::KEY_STYLE_PAGINATION_BOX_CLASS] = (isset($config[self::KEY_STYLE_PAGINATION_BOX_CLASS]) && !empty($config[self::KEY_STYLE_PAGINATION_BOX_CLASS])) ? $config[self::KEY_STYLE_PAGINATION_BOX_CLASS] : "";
        $config[self::KEY_STYLE_PAGINATION_ACIVE_PAGE_CLASS] = (isset($config[self::KEY_STYLE_PAGINATION_ACIVE_PAGE_CLASS]) && !empty($config[self::KEY_STYLE_PAGINATION_ACIVE_PAGE_CLASS])) ? $config[self::KEY_STYLE_PAGINATION_ACIVE_PAGE_CLASS] : "";
        $config[self::KEY_STYLE_SELECT_ACTION_ID] = (isset($config[self::KEY_STYLE_SELECT_ACTION_ID]) && !empty($config[self::KEY_STYLE_SELECT_ACTION_ID])) ? $config[self::KEY_STYLE_SELECT_ACTION_ID] : "";
        $config[self::KEY_STYLE_SELECT_ACTION_CLASS] = (isset($config[self::KEY_STYLE_SELECT_ACTION_CLASS]) && !empty($config[self::KEY_STYLE_SELECT_ACTION_CLASS])) ? $config[self::KEY_STYLE_SELECT_ACTION_CLASS] : "";
        $config[self::KEY_STYLE_SELECT_ACTION_NAME] = (isset($config[self::KEY_STYLE_SELECT_ACTION_NAME]) && !empty($config[self::KEY_STYLE_SELECT_ACTION_NAME])) ? $config[self::KEY_STYLE_SELECT_ACTION_NAME] : "sel_action";
        $config[self::KEY_STYLE_PAGE_SIZE_BOX_ID] = (isset($config[self::KEY_STYLE_PAGE_SIZE_BOX_ID]) && !empty($config[self::KEY_STYLE_PAGE_SIZE_BOX_ID])) ? $config[self::KEY_STYLE_PAGE_SIZE_BOX_ID] : "";
        $config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS] = (isset($config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS]) && !empty($config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS])) ? $config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS] : "";
        $config[self::KEY_STYLE_PAGE_SIZE_SELECT_NAME] = (isset($config[self::KEY_STYLE_PAGE_SIZE_SELECT_NAME]) && !empty($config[self::KEY_STYLE_PAGE_SIZE_SELECT_NAME])) ? $config[self::KEY_STYLE_PAGE_SIZE_SELECT_NAME] : "sel_page_size";
        $config[self::KEY_STYLE_ROW_MENU_CLASS] = (isset($config[self::KEY_STYLE_ROW_MENU_CLASS]) && !empty($config[self::KEY_STYLE_ROW_MENU_CLASS])) ? $config[self::KEY_STYLE_ROW_MENU_CLASS] : "";
        $config[self::KEY_STYLE_EMPTY_RESULT_CLASS] = (isset($config[self::KEY_STYLE_EMPTY_RESULT_CLASS]) && !empty($config[self::KEY_STYLE_EMPTY_RESULT_CLASS])) ? $config[self::KEY_STYLE_EMPTY_RESULT_CLASS] : "empty-result-box";
        
        if(isset($config[self::KEY_ROW_MENU]) && is_array($config[self::KEY_ROW_MENU])){
            for($i=0; $i<count($config[self::KEY_ROW_MENU]); $i++){
                $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_BODY] = (isset($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_BODY]) && !empty($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_BODY])) ? $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_BODY] : "";
                $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_TITLE] = (isset($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_TITLE]) && !empty($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_TITLE])) ? $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_TITLE] : "";
                $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_URL] = (isset($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_URL]) && !empty($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_URL])) ? $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_URL] : "";
                $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_CLASS] = (isset($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_CLASS]) && !empty($config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_CLASS])) ? $config[KEY_ROW_MENU][$i][self::KEY_ROW_MENU_ITEM_CLASS] : "";
            }
        }
        
        if(isset($config[self::KEY_SELECT_ACTION]) && is_array($config[self::KEY_SELECT_ACTION])){
            for($i=0; $i<count($config[self::KEY_SELECT_ACTION]); $i++){
                $config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_VALUE] = (isset($config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_VALUE]) && !empty($config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_VALUE])) ? $config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_VALUE] : "";
                $config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_TITLE] = (isset($config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_TITLE]) && !empty($config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_TITLE])) ? $config[KEY_SELECT_ACTION][$i][self::KEY_SELECT_ACTION_TITLE] : "";
            }
        }
        
        if($config[self::KEY_CONFIG_DISABLE_PAGINATION] === true){
            $config[self::KEY_CONFIG_PAGES_COUNT] = 1;
            $config[self::KEY_CONFIG_PAGE] = 1;
        }
        
        return $config;
    }

	/**
	 * Get start row of data.
	 *
	 * @param int $page_size
	 *        	with count rows per page
	 * @param int $page
	 *        	with actual index of page
	 * @return integer
	 */
	private static function getStartRow($page, $page_size){
		return ($page * $page_size) - $page_size;
	}

	/**
	 * Get count pages of data.
	 *
	 * @param int $page_size
	 *        	with count rows per page
	 * @param int $data_count
	 *        	with count of all data found
	 * @return integer
	 */
	private static function getCountPages($page_size, $data_count){
		return ceil($data_count / $page_size);
	}

	/**
	 * Make string of list HTML TABLE if data and header are not empty
	 *
	 * @param $header array
	 *        	1D with name of columns
	 * @param $data array
	 *        	2D with data to show in table
	 * @param $config array
	 *        	array with defined keys and validated by self::validateConfig
	 * @return string
	 */
	private static function makeListTableString($header, $data, $config){
		$s = "";
		if(count($header) > 0 && count($data) > 0 && count($header) == count($data[0])){
			// page size box
			if($config[self::KEY_CONFIG_DISABLE_SET_PAGE_SIZE] === false){
				$s .= sprintf("<form method=\"post\" enctype=\"application/x-www-form-urlencoded\" action=\"%s\" %s %s>", $config[self::KEY_URL_FORM_ACTION], !empty($config[self::KEY_STYLE_PAGE_SIZE_BOX_ID]) ? " id=\"" . $config[self::KEY_STYLE_PAGE_SIZE_BOX_ID] . "\"" : "", !empty($config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS]) ? " class=\"" . $config[self::KEY_STYLE_PAGE_SIZE_BOX_CLASS] . "\"" : "");
				$s .= sprintf("<div><span>%s</span><select name=\"%s\">", Translate::get(Translator::LIST_PAGE_SIZE), $config[self::KEY_STYLE_PAGE_SIZE_SELECT_NAME]);
				foreach(System::$page_size as $v){
					$s .= sprintf("<option value=\"%d\"%s>%d</option>", $v, ($v == $config[self::KEY_CONFIG_PAGE_SIZE] ? " selected=\"selected\"" : ""), $v);
				}
				$s .= sprintf("</select><input type=\"submit\" value=\"%s\"/><div class=\"cleaner_micro\">&nbsp;</div></div></form>", Translate::get(Translator::BTN_SEND));
			}
			// select action box
			if($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] === false){
				$s .= sprintf("<form method=\"post\" enctype=\"application/x-www-form-urlencoded\" action=\"%s\" %s %s>", $config[self::KEY_URL_FORM_ACTION], !empty($config[self::KEY_STYLE_SELECT_ACTION_ID]) ? " id=\"" . $config[self::KEY_STYLE_SELECT_ACTION_ID] . "\"" : "", !empty($config[self::KEY_STYLE_SELECT_ACTION_CLASS]) ? " class=\"" . $config[self::KEY_STYLE_SELECT_ACTION_CLASS] . "\"" : "");
				$s .= sprintf("<div><select name=\"%s\">", $config[self::KEY_STYLE_SELECT_ACTION_NAME]);
				foreach($config[self::KEY_SELECT_ACTION] as $k => $v){
					$s .= sprintf("<option value=\"%s\">%s</option>", $v[self::KEY_SELECT_ACTION_VALUE], $v[self::KEY_SELECT_ACTION_TITLE]);
				}
				$s .= sprintf("</select><input type=\"submit\" value=\"%s\"/><div class=\"cleaner_micro\">&nbsp;</div></div>", Translate::get(Translator::BTN_SEND));
			}
			// data table
			$s .= sprintf("<table%s%s>", !empty($config[self::KEY_STYLE_TABLE_ID]) ? " id=\"" . $config[self::KEY_STYLE_TABLE_ID] . "\"" : "", !empty($config[self::KEY_STYLE_TABLE_CLASS]) ? " class=\"" . $config[self::KEY_STYLE_TABLE_CLASS] . "\"" : "");
			$s .= sprintf("<thead><tr%s>", !empty($config[self::KEY_STYLE_TABLE_HEADER_CLASS]) ? " class=\"" . $config[self::KEY_STYLE_TABLE_HEADER_CLASS] . "\"" : "");
			if($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] === false){
				// add select action column
				$s .= sprintf("<th class=\"%s\">&nbsp;</th>", self::COLUMN_PREFIX.self::COLUMN_SELECT_ACTION_SUFFIX);
			}
			// table header
			$j = 0;
			foreach($header as $k => $v){
				$sort_next_direction = ($k == $config[self::KEY_CONFIG_COLUMN] ? ($config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_ASC ? System::SORT_DES : ($config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_DES ? System::SORT_ASC : "")) : System::SORT_ASC);
				$sort_show = ($k == $config[self::KEY_CONFIG_COLUMN] ? ($config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_ASC ? System::SORT_ASC : ($config[self::KEY_CONFIG_SORT_DIRECTION] == System::SORT_DES ? System::SORT_DES : "")) : "");
				switch($sort_show){
					case System::SORT_ASC:
						$sort_show = "&#x2206;";
						break;
					case System::SORT_DES:
						$sort_show = "&#x2207;";
						break;
				}
				$s .= sprintf("<th class=\"%s\"><a href=\"%s\">%s</a></th>", self::COLUMN_PREFIX . $j, sprintf($config[self::KEY_URL_HEADER_SORT], $config[self::KEY_CONFIG_PAGE], $k, $sort_next_direction), $v . "&nbsp;" . $sort_show);
				// add empty columns for ROW_MENU_ITEM
				if($j == (count($header) - 1) && $config[self::KEY_CONFIG_DISABLE_ROW_MENU] === false){
					foreach($config[self::KEY_ROW_MENU] as $k => $v){
						$s .= sprintf("<th class=\"%s\">&nbsp;</th>", $v[self::KEY_STYLE_ROW_MENU_CLASS]);
					}
				}
				++$j;
			}
			$s .= sprintf("</tr></thead><tbody>");
			// table data rows
			for($i = 0; $i < count($data); $i++){
				$s .= sprintf("<tr%s>", ($i % 2 == 0 ? sprintf(" class=\"%s\"", (!empty($config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS]) ? $config[self::KEY_STYLE_TABLE_MARKED_ROW_CLASS] : "")) : ""));
				for($j = 0; $j < count($data[$i]); $j++){
					if($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] === false && $j == 0){
						$s .= sprintf("<td class=\"%s\"><input type=\"checkbox\" name=\"%s\" /></th>", self::COLUMN_PREFIX.self::COLUMN_SELECT_ACTION_SUFFIX, self::ROW_PREFIX . $i . "_" . $data[$i][$j]);
					}
					$s .= sprintf("<td class=\"%s\">%s</td>", self::COLUMN_PREFIX . $j, $data[$i][$j]);
					// add item_menu columns
					if($j == count($data[$i]) - 1 && $config[self::KEY_CONFIG_DISABLE_ROW_MENU] === false){
						foreach($config[self::KEY_ROW_MENU] as $k => $v){
							$s .= sprintf("<td class=\"%s\"><a%shref=\"%s\"%s>%s</a></td>", $config[self::KEY_STYLE_ROW_MENU_CLASS], (!empty($v[self::KEY_ROW_MENU_ITEM_TITLE]) ? " title=\"" . $v[self::KEY_ROW_MENU_ITEM_TITLE] . "\"" : " "), sprintf($v[self::KEY_ROW_MENU_ITEM_URL], $data[$i][0]), (!empty($v[self::KEY_ROW_MENU_ITEM_CLASS]) ? " class=\"" . $v[self::KEY_ROW_MENU_ITEM_CLASS] . "\"" : " "), "<span>" . $v[self::KEY_ROW_MENU_ITEM_BODY] . "</span>");
						}
					}
				}
				$s .= sprintf("</tr>");
			}
			$s .= sprintf("</tbody></table>");
			if($config[self::KEY_CONFIG_DISABLE_SELECT_ACTION] === false){
				$s .= sprintf("</form>");
			}
			// pagging box
			$s .= sprintf("<div%s>", (!empty($config["style"]["list_footer_id"]) ? " id=\"" . $config["style"]["list_footer_id"] . "\"" : ""));
			$s .= sprintf("<div%s><span>%s: %d | %s: %d | %s: %d/%d</span></div>", (!empty($config["style"]["count_box_class"]) ? sprintf(" class=\"%s\"", $config["style"]["count_box_class"]) : ""), Translate::get(Translator::LIST_DISPLAYED_ROWS), count($data), Translate::get(Translator::LIST_FOUND_ROWS), $config["config"]["data_count"], Translate::get(Translator::LIST_PAGE), $config["config"]["page"], $config["config"]["sum_pages"]);
			// box with page numbers
			$s .= sprintf("<div%s><div class=\"col-md-12 text-center\"><ul class=\"pagination\">", (isset($config["style"]["pagging_box_class"]) ? sprintf(" class=\"%s\"", $config["style"]["pagging_box_class"]) : ""));
			if($config["config"]["sum_pages"] > 5){
				$sp = isset($config["form_url"]["page"]);
				$ap = isset($config["style"]["actual_page_class"]);
				$url = (!empty($sp) ? sprintf($config["form_url"]["page"], System::PAGE_MIN_PAGE, $config["config"]["column"], $config["config"]["direction"]) : "");
				$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && System::PAGE_MIN_PAGE == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), System::PAGE_MIN_PAGE);
				if($config["config"]["page"] - 1 > 2){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"] - 1, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("...,<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] - 1 == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"] - 1);
				}else if($config["config"]["page"] - 1 > 1 && $config["config"]["page"] - 1 < 2){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"] - 1, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] - 1 == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"] - 1);
				}else if($config["config"]["page"] > 2){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"] - 1, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] - 1 == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"] - 1);
				}
				if($config["config"]["page"] + 1 < $config["config"]["sum_pages"] && $config["config"]["page"] > System::PAGE_MIN_PAGE){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"], $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"]);
				}
				if($config["config"]["page"] + 2 < $config["config"]["sum_pages"]){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"] + 1, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,...,</li>", $url, (($ap && $config["config"]["page"] + 1 == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"] + 1);
				}else if($config["config"]["page"] + 1 < $config["config"]["sum_pages"]){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"] + 1, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] + 1 == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"] + 1);
				}else if($config["config"]["page"] < $config["config"]["sum_pages"]){
					$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["page"], $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>,</li>", $url, (($ap && $config["config"]["page"] == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["page"]);
				}
				$url = (isset($sp) ? sprintf($config["form_url"]["page"], $config["config"]["sum_pages"], $config["config"]["column"], $config["config"]["direction"]) : "");
				$s .= sprintf("<li><a href=\"%s\"%s>%d</a></li>", $url, (($ap && $config["config"]["sum_pages"] == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $config["config"]["sum_pages"]);
			}else{
				for($i = 1; $i <= $config["config"]["sum_pages"]; $i++){
					$url = (!empty($config["form_url"]["page"]) ? sprintf($config["form_url"]["page"], $i, $config["config"]["column"], $config["config"]["direction"]) : "");
					$s .= sprintf("<li><a href=\"%s\"%s>%d</a>%s</li>", $url, ((!empty($config["style"]["actual_page_class"]) && $i == $config["config"]["page"]) ? sprintf(" class=\"%s\"", $config["style"]["actual_page_class"]) : ""), $i, ($i < $config["config"]["sum_pages"] ? "," : ""));
				}
			}
			$s .= sprintf("</ul></div></div>");
			$s .= sprintf("</div>");
		}
		return $s;
	}
}
?>