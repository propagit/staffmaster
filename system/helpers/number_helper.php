<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Number Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/number_helper.html
 */
if ( ! function_exists('mobile_format'))
{
	function mobile_format($mobile)
	{
		$mobile = str_replace("+","",$mobile);
		$mobile = str_replace(".","",$mobile);
		$mobile = str_replace("(","",$mobile);
		$mobile = str_replace(")","",$mobile);
		$mobile = str_replace("-","",$mobile);
		$mobile = str_replace(" ","",$mobile);
		if (substr($mobile,0,2) == "04" && strlen($mobile) == 10) {
			$mobile = substr($mobile,1);
			$mobile = "61".$mobile;		
		} else if (substr($mobile,0,1) == "4" && strlen($mobile) == 9) {
			$mobile = "61".$mobile;
		}
		return $mobile;		
	}
}

if ( ! function_exists('money_format'))
{
	function money_format($format='%i', $number)
	{
		setlocale(LC_MONETARY, "en_US");
		echo number_format($number, 2);
	}
}

// ------------------------------------------------------------------------

/**
 * Formats a numbers as bytes, based on size, and adds the appropriate suffix
 *
 * @access	public
 * @param	mixed	// will be cast as int
 * @return	string
 */
if ( ! function_exists('byte_format'))
{
	function byte_format($num, $precision = 1)
	{
		$CI =& get_instance();
		$CI->lang->load('number');

		if ($num >= 1000000000000)
		{
			$num = round($num / 1099511627776, $precision);
			$unit = $CI->lang->line('terabyte_abbr');
		}
		elseif ($num >= 1000000000)
		{
			$num = round($num / 1073741824, $precision);
			$unit = $CI->lang->line('gigabyte_abbr');
		}
		elseif ($num >= 1000000)
		{
			$num = round($num / 1048576, $precision);
			$unit = $CI->lang->line('megabyte_abbr');
		}
		elseif ($num >= 1000)
		{
			$num = round($num / 1024, $precision);
			$unit = $CI->lang->line('kilobyte_abbr');
		}
		else
		{
			$unit = $CI->lang->line('bytes');
			return number_format($num).' '.$unit;
		}

		return number_format($num, $precision).' '.$unit;
	}
}


/* End of file number_helper.php */
/* Location: ./system/helpers/number_helper.php */