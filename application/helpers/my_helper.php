<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_month')){
    function get_month($value){
        switch ($value){
            case 'jan': return "January";
                break;
            case 'feb':	return "February";
                break;
            case 'mar':	return "March";
                break;
            case 'apr':	return "April";
                break;
            case 'may':	return "May";
                break;
            case 'jun':	return "June";
                break;
            case 'jul':	return "July";
                break;
            case 'aug':	return "August";
                break;
            case 'sep':	return "September";
                break;
            case 'oct': return "October";
                break;
            case 'nov': return "November";
                break;
            case 'dec': return "December";
                break;
        }
    }
}
