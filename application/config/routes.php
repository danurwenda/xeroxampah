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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//biar url nya readable, kita pakai alias instead of id
$route['master'] = 'dashboard/show/1';
//organisasi
$route['organisasi/(:num)']['DELETE'] = 'organisasi/delete/$1';
$route['organisasi']['POST'] = 'organisasi/submit';
$route['organisasi/(:num)']['PUT'] = 'organisasi/update/$1';
//individu
$route['individu/(:num)']['DELETE'] = 'individu/delete/$1';
$route['individu']['POST'] = 'individu/submit';
$route['individu/(:num)']['PUT'] = 'individu/update/$1';
//masjid
$route['masjid/(:num)']['DELETE'] = 'masjid/delete/$1';
$route['masjid']['POST'] = 'masjid/submit';
$route['masjid/(:num)']['PUT'] = 'masjid/update/$1';
//school
$route['school/(:num)']['DELETE'] = 'school/delete/$1';
$route['school']['POST'] = 'school/submit';
$route['school/(:num)']['PUT'] = 'school/update/$1';
//lapas
$route['lapas/(:num)']['DELETE'] = 'lapas/delete/$1';
$route['lapas']['POST'] = 'lapas/submit';
$route['lapas/(:num)']['PUT'] = 'lapas/update/$1';
//pengajian
$route['pengajian/(:num)']['DELETE'] = 'pengajian/delete/$1';
$route['pengajian']['POST'] = 'pengajian/submit';
$route['pengajian/(:num)']['PUT'] = 'pengajian/update/$1';
//latsen
$route['latsen/(:num)']['DELETE'] = 'latsen/delete/$1';
$route['latsen']['POST'] = 'latsen/submit';
$route['latsen/(:num)']['PUT'] = 'latsen/update/$1';
//latihan
$route['latihan/(:num)']['DELETE'] = 'latihan/delete/$1';
$route['latihan']['POST'] = 'latihan/submit';
$route['latihan/(:num)']['PUT'] = 'latihan/update/$1';
//teror
$route['teror/(:num)']['DELETE'] = 'teror/delete/$1';
$route['teror']['POST'] = 'teror/submit';
$route['teror/(:num)']['PUT'] = 'teror/update/$1';
//nonteror
$route['nonteror/(:num)']['DELETE'] = 'nonteror/delete/$1';
$route['nonteror']['POST'] = 'nonteror/submit';
$route['nonteror/(:num)']['PUT'] = 'nonteror/update/$1';