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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;
$route['admin/cms/(:any)'] = 'admin/cms';

$route['tours/search'] = 'tours/search';
$route['tours/(:any)'] = 'tours';
$route['tours/(:any)/(:any)'] = 'tours';

/*$route['tour-packages/pdf-generator'] = 'tour_packages/pdf_generator';
$route['packages/get-package-accommodations'] = 'packages/get_package_accommodations';
$route['tour-packages/get-package-max-capacity'] = 'tour-packages/get_package_max_capacity';
$route['packages/get-package-iternaries'] = 'packages/get_package_iternaries';
$route['packages/get-pdfs'] = 'packages/get_pdfs';*/


$route['pdf/pdf-generator'] = 'pdf/pdf_generator';
$route['packages/get-package-accommodations'] = 'packages/get_package_accommodations';
$route['packages/get-package-max-capacity'] = 'packages/get_package_max_capacity';
$route['packages/get-package-iternaries'] = 'packages/get_package_iternaries';

$route['packages/get-pdfs'] = 'packages/get_pdfs';
$route['packages/get-docs'] = 'packages/get_docs';





$route['packages/search'] = 'packages/search';
$route['packages/getvehicles'] = 'packages/getvehicles';
$route['packages/enquiry'] = 'packages/enquiry';
$route['packages/getaccomodation'] = 'packages/getaccomodation';
$route['packages/geprice'] = 'packages/geprice';
$route['packages/booking'] = 'packages/booking';
$route['packages/(:any)'] = 'packages';

$route['destination/search'] = 'destination/search';
$route['destination/(:any)'] = 'destination';
$route['destination/(:any)/(:any)'] = 'destination';

$route['state/(:any)'] = 'state';

$route['places_to_visit/placesearch'] = 'places_to_visit/placesearch';
$route['places_to_visit/search'] = 'places_to_visit/search';
$route['places-to-visit/(:any)'] = 'places_to_visit';
$route['places-to-visit/(:any)/(:any)'] = 'places_to_visit';

$route['place/search'] = 'place/search';
$route['place/(:any)'] = 'place';
$route['place/(:any)/(:any)'] = 'place';
$route['place/(:any)/(:any)/(:any)'] = 'place';

$route['getaways/(:any)'] = 'getaways';
$route['getaways/(:any)/(:any)'] = 'getaways';

$route['itinerary/search'] = 'itinerary/search';
$route['itinerary/(:any)'] = 'itinerary';
$route['destination-package/(:any)'] = 'destination-package';
$route['place-package/(:any)'] = 'place-package';

$route['blog/(:any)'] = 'single_blog';
$route['blog/page/(:any)'] = 'blog';

$route['destinations/page/(:any)'] = 'destinations';
$route['getaway/page/(:any)'] = 'getaway';
$route['tour-packages/page/(:any)'] = 'tour_packages';
$route['itineraries/page/(:any)'] = 'itineraries';
$route['review/page/(:any)'] = 'review';

$route['search-package/(:any)'] = 'search_package';
$route['invoice/(:any)/(:any)'] = 'invoice';
$route['form'] = "FormController";
$route['formPost']['post'] = "FormController/formPost";
