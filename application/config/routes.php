<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  | example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  | https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  | $route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  | $route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  | $route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples: my-controller/index -> my_controller/index
  |   my-controller/my-method -> my_controller/my_method
 */
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
  | -------------------------------------------------------------------------
  | Sample REST API Routes
  | -------------------------------------------------------------------------
 */
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8

$route['person/person/(:num)'] = 'person/person/id/$1';
$route['person/person/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'person/person/id/$1/format/$3$4';

$route['person/employee/(:num)'] = 'person/employee/id/$1';
$route['person/employee/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'person/employee/id/$1/format/$3$4';

$route['person/user/(:num)'] = 'person/user/id/$1';
$route['person/user/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'person/user/id/$1/format/$3$4';

$route['company/company/(:num)'] = 'company/company/id/$1';
$route['company/company/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'company/company/id/$1/format/$3$4';

$route['company/employees/(:num)'] = 'company/employees/id/$1';
$route['company/employees/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'company/employees/id/$1/format/$3$4';

$route['payroll/summary/(:num)'] = 'payroll/summary/id/$1';
$route['payroll/summary/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'payroll/summary/id/$1/format/$3$4';

$route['payroll/employee_postings/(:num)'] = 'payroll/employee_postings/id/$1';
$route['payroll/employee_postings/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'payroll/employee_postings/id/$1/format/$3$4';

$route['payroll/posting_types/(:num)'] = 'payroll/posting_types/id/$1';
$route['payroll/posting_types/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'payroll/posting_types/id/$1/format/$3$4';

$route['payroll/earning_deduction_codes/(:num)'] = 'payroll/earning_deduction_codes/id/$1';
$route['payroll/earning_deduction_codes/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'payroll/earning_deduction_codes/id/$1/format/$3$4';

$route['payroll/earning_deduction_code/(:num)'] = 'payroll/earning_deduction_code/id/$1';
$route['payroll/earning_deduction_code/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'payroll/earning_deduction_code/id/$1/format/$3$4';

//The Rest API Resourcses Starts here :-)
//$route['departments/(:num)'] = 'departments/index/company_id/$1';
//$route['departments/(:num)/(:num)'] = 'departments/index/company_id/$1/department_id/$2';
//$route['departments/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'departments/index/company_id/$1/format/$3$4';

$route['departments/find/(:num)'] = 'departments/find/department_id/$1'; //GET
$route['departments/(:num)'] = 'departments/index/company_id/$1'; //GET
//$route['departments/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'departments/index/id/$1/format/$3$4';//post

$route['paygrades/(:num)'] = 'paygrades/index/company_id/$1'; //GET
$route['paygrades/find/(:num)'] = 'paygrades/find/pay_grade_id/$1'; //GET










